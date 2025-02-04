// Utility functions
const createMessage = (content, type) => {
    const div = document.createElement('div');
    div.className = `message ${type}-message`;
    div.textContent = content;
    return div;
};

const showTypingIndicator = () => {
    const indicator = document.getElementById('typing-indicator');
    indicator.style.display = 'block';
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
};

const hideTypingIndicator = () => {
    const indicator = document.getElementById('typing-indicator');
    indicator.style.display = 'none';
};

const showError = (message) => {
    const chatBox = document.getElementById('chat-box');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    chatBox.appendChild(errorDiv);
    chatBox.scrollTop = chatBox.scrollHeight;
    
    // Remove error message after 5 seconds
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
};

// Auto-resize textarea
const userInput = document.getElementById('user-input');
userInput.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 100) + 'px';
});

// Send message when Enter is pressed (without Shift)
userInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('send-btn').click();
    }
});

// Main send message function
document.getElementById('send-btn').addEventListener('click', async function() {
    const userInput = document.getElementById('user-input');
    const sendBtn = document.getElementById('send-btn');
    const chatBox = document.getElementById('chat-box');
    const message = userInput.value.trim();
    
    if (message === '') return;
    
    // Disable input and button while processing
    userInput.disabled = true;
    sendBtn.disabled = true;
    
    // Add user message to chat
    chatBox.appendChild(createMessage(message, 'user'));
    userInput.value = '';
    userInput.style.height = 'auto';
    
    // Show typing indicator
    showTypingIndicator();
    chatBox.scrollTop = chatBox.scrollHeight;
    
    try {
        const response = await fetch('chatbot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        });
        
        const data = await response.json();
        
        // Hide typing indicator
        hideTypingIndicator();
        
        if (data.status === 'error') {
            showError('Sorry, I encountered an error. Please try again.');
        } else {
            chatBox.appendChild(createMessage(data.response, 'bot'));
        }
        
    } catch (error) {
        hideTypingIndicator();
        showError('Network error. Please check your connection and try again.');
        console.error('Error:', error);
    } finally {
        // Re-enable input and button
        userInput.disabled = false;
        sendBtn.disabled = false;
        userInput.focus();
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});

// Initial focus
document.getElementById('user-input').focus();