<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to send JSON response
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

try {
    // Get and validate input
    $input = file_get_contents('php://input');
    $inputData = json_decode($input, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input: ' . json_last_error_msg());
    }
    
    if (!isset($inputData['message'])) {
        throw new Exception('Message field is required');
    }
    
    $userMessage = $inputData['message'];
    
    // API Configuration
    $apiKey = 'AIzaSyATjHMRV9Lgh2l5QasIY-jDHVVseCuF-rE'; // Get API key from environment variable
    if (!$apiKey) {
        throw new Exception('API key not configured');
    }
    
    $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';
    
    // Prepare API request payload according to Gemini API format
    $requestData = [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => $userMessage]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.7,
            'maxOutputTokens' => 800,
            'topP' => 0.8,
            'topK' => 40
        ],
        'safetySettings' => [
            [
                'category' => 'HARM_CATEGORY_HARASSMENT',
                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
            ]
        ]
    ];
    
    // Initialize cURL session
    $ch = curl_init($apiUrl . '?key=' . $apiKey);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($requestData),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_TIMEOUT => 30
    ]);
    
    // Execute API request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Check for cURL errors
    if ($response === false) {
        throw new Exception('cURL error: ' . curl_error($ch));
    }
    
    curl_close($ch);
    
    // Decode response
    $responseData = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON response from API: ' . json_last_error_msg() . 
                          ' Raw response: ' . substr($response, 0, 1000));
    }
    
    // Handle API errors
    if ($httpCode !== 200) {
        $errorMessage = isset($responseData['error']['message']) 
            ? $responseData['error']['message'] 
            : 'API returned status code ' . $httpCode;
        throw new Exception($errorMessage);
    }
    
    // Extract the bot's response
    if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        throw new Exception('Unexpected API response structure: ' . json_encode($responseData));
    }
    
    $botResponse = $responseData['candidates'][0]['content']['parts'][0]['text'];
    
    // Database operations - using PDO for better security
    try {
        $dbConfig = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'chatbot_db'
        ];
        
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4";
        $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        
        $stmt = $pdo->prepare("INSERT INTO chat_logs (user_message, bot_response) VALUES (?, ?)");
        $stmt->execute([$userMessage, $botResponse]);
        
    } catch (PDOException $e) {
        // Log database error but don't expose details to client
        error_log("Database error: " . $e->getMessage());
        // Continue with the response even if database logging fails
    }
    
    // Send success response
    sendResponse([
        'status' => 'success',
        'response' => $botResponse
    ]);
    
} catch (Exception $e) {
    // Log error
    error_log("Error in chatbot API: " . $e->getMessage());
    
    // Send error response without exposing sensitive details
    sendResponse([
        'status' => 'error',
        'message' => 'An error occurred while processing your request'
    ], 500);
}
?>