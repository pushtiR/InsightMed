<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InsightMed - Virtual Healthcare System</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="logo">InsightMed</div>
    <ul class="nav-links">
      <li><a href="#home">Home</a></li>
      <li><a href="#services">Services</a></li>
      <li>
        <a href="<?php echo isset($_SESSION['user_id']) ? 'medical_records.php' : 'login.html'; ?>">Medical Records</a>
      </li>
      <li><a href="#chat">AI Chat</a></li>
      <li><a href="#about-us">About Us</a></li>
      
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="logout.php"  class="button login-btn" style="color:#276d5a">Log Out</a></li>
      <?php else: ?>
        <li><a href="login.html" class="button login-btn" style="color:#276d5a">Login</a></li>
        <li><a href="signup.html" class="button signup-btn" style="color:#276d5a">Sign Up</a></li>
      <?php endif; ?>
    </ul>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
  </nav>

  <!-- Home Section -->
  <section id="home" class="section home">
    <div class="home-content">
      <div class="text-content">
        <h1>
          <?php echo isset($_SESSION['user_id']) ? "Welcome, " . htmlspecialchars($_SESSION['user_name']) . "!" : "Welcome to InsightMed"; ?>
        </h1>
        <p><?php echo isset($_SESSION['user_id']) ? "How can we help you?" : "Your virtual healthcare companion for reliable medical assistance and health insights."; ?></p>
        <a href="#services" class="cta-button">Explore Our Services</a>
      </div>
      <div class="vector-image">
        <img src="image1.svg" alt="Healthcare Illustration" />
      </div>
    </div>
  </section>
  
  <!-- Services Section -->
  <section id="services" class="section services">
    <h2>Our Services</h2>
    <div class="services-container">
      <a href="get_nearby_doctors.html" class="service-link">
        <div class="service-card">
          <img src="doctors.svg" alt="Service 1 Icon" class="service-icon">
          <h3>Get Nearby Doctors</h3>
          <p>Locate healthcare professionals in your area for quick access to medical assistance.</p>
        </div>
      </a>
      <a href="chatindex.html" class="service-link">
        <div class="service-card">
          <img src="ai.svg" alt="Service 3 Icon" class="service-icon">
          <h3>AI Assistance</h3>
          <p>Our chatbot is here to answer healthcare-related questions and provide guidance.</p>
        </div>
      </a>
      <a href="<?php echo isset($_SESSION['user_id']) ? 'medical_records.php' : 'login.html'; ?>" class="service-link">
        <div class="service-card">
          <img src="history.svg" alt="Service 2 Icon" class="service-icon">
          <h3>Medical Records</h3>
          <p>Access your medical history and records in one secure, convenient location.</p>
        </div>
      </a>
    </div>
  </section>

  <!-- Chat Section -->
<section id="chat" class="section">
    <div class="chat-description">
        <div class="text-content">
            <h2>AI Healthcare Chat</h2>
            <p style="color:#000;">Welcome to our AI-powered Healthcare Chatbot! This bot is here to assist you with a wide range of health-related queries, from general wellness tips to specific medical advice (please note, it is not a substitute for professional medical care). To get the most accurate responses, make sure to ask clear and specific questions. For example:</p>
            <ul style="color:#555;">
                <li>"What are the symptoms of the flu?"</li>
                <li>"How can I manage stress and anxiety?"</li>
                <li>"What are the benefits of a balanced diet?"</li>
                <li>"Can you provide tips for better sleep?"</li>
            </ul>
            <p style="color:#000;">Simply type your healthcare-related question, and our AI chatbot will provide helpful and reliable information. Click the button below to start chatting with the bot!</p>
            <a href= "chatindex.html" class="cta-button">Chat with AI</a>
            </div>
        <div class="vector-image">
            <!-- Placeholder for vector image or illustration -->
            <img src="chatvector.svg" alt="AI Healthcare Chat Illustration" />
        </div>
    </div>
</section>


<!-- about us -->
<section id="about-us" style="background-color: #f2f4f3; padding: 150px 0; text-align: center;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <h2 style="font-size: 2.5em; color: #276d5a; margin-bottom: 50px;">About Us</h2>
        <p style="font-size: 1em; line-height: 1.5; color: #000;">
            This website aims to provide an easy-to-use user interface for healthcare-related queries. 
            Our goal is to assist users in accessing relevant healthcare information quickly and conveniently.
        </p>
        <p style="font-size: 1em; line-height: 1.5; color: #000;">
            Whether you’re looking for basic health information, common symptoms, or appointment scheduling tips, 
            our chatbot is designed to help guide you through your healthcare-related questions.
        </p>
    </div>
</section>

<!-- footer -->
<footer style="background-color: #276d5a; color: #fff; padding: 40px 0; text-align: center;">
    <div class="footer-container" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; flex-wrap: wrap; padding: 0 20px;">
        
        <!-- Quick Links Section -->
        <div class="footer-section" style="flex: 1; min-width: 200px; margin-bottom: 20px; padding: 10px;">
            <h3 style="font-size: 1.2em; margin-bottom: 15px; font-weight: bold;">Quick Links</h3>
            <ul style="list-style: none; padding-left: 0; font-size: 1em;">
                <li><a href="/" style="color: #fff; text-decoration: none; margin-bottom: 8px; display: block; transition: color 0.3s;">Home</a></li>
                <li><a href="#about-us" style="color: #fff; text-decoration: none; margin-bottom: 8px; display: block; transition: color 0.3s;">About Us</a></li>
                <li><a href="#chat" style="color: #fff; text-decoration: none; margin-bottom: 8px; display: block; transition: color 0.3s;">Chat with Us</a></li>
                <li><a href="#contact" style="color: #fff; text-decoration: none; margin-bottom: 8px; display: block; transition: color 0.3s;">Contact</a></li>
            </ul>
        </div>

        <!-- Contact Information Section -->
        <div class="footer-section" style="flex: 1; min-width: 200px; margin-bottom: 20px; padding: 10px;">
            <h3 style="font-size: 1.2em; margin-bottom: 15px; font-weight: bold;">Contact Us</h3>
            <p style="font-size: 1em; margin-bottom: 10px;">Email: <a href="mailto:pushti2403@gmail.com" style="color: #fff; text-decoration: none;">pushti2403@gmail.com</a></p>
            <p style="font-size: 1em;">Phone: +91 6352898800</p>
        </div>

        <!-- Social Media Section -->
<div class="footer-section" style="flex: 1; min-width: 200px; margin-bottom: 20px; padding: 10px;">
    <h3 style="font-size: 1.2em; margin-bottom: 15px; font-weight: bold;">Follow Us</h3>
    <div style="display: flex; justify-content: space-evenly; font-size: 1.5em;">
        <a href="https://www.facebook.com" target="_blank" style="color: #fff; text-decoration: none; transition: color 0.3s;">
            <i class="fab fa-facebook"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank" style="color: #fff; text-decoration: none; transition: color 0.3s;">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" style="color: #fff; text-decoration: none; transition: color 0.3s;">
            <i class="fab fa-linkedin"></i>
        </a>
    </div>
</div>

        </div>
    </div>

    <!-- Footer Bottom Section -->
    <div style="border-top: 1px solid #fff; padding-top: 20px; margin-top: 30px;">
        <p style="font-size: 1em; color: #fff;">&copy; 2024 InsightMed. All Rights Reserved.</p>
    </div>
</footer>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>



  <!-- Scripts -->
  <script src="script.js"></script>
</body>
</html>
