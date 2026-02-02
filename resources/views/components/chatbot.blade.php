<!-- Chatbot Component -->
<div class="chatbot-container" id="chatbot-container">
    <!-- Chatbot Toggle Button -->
    <div class="chatbot-toggle" id="chatbot-toggle">
        <div class="chatbot-toggle-icon">
            <svg class="chat-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12C2 13.54 2.36 14.99 3.01 16.28L2 22L7.72 20.99C9.01 21.64 10.46 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C10.74 20 9.54 19.75 8.47 19.3L8 19.11L4.91 19.91L5.71 16.82L5.52 16.35C5.07 15.28 4.82 14.08 4.82 12.82C4.82 7.58 8.58 3.82 13.82 3.82C16.39 3.82 18.77 4.82 20.54 6.59C22.31 8.36 23.31 10.74 23.31 13.31C23.31 18.55 19.55 22.31 14.31 22.31L12 20Z" fill="currentColor"/>
            </svg>
            <svg class="close-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="chatbot-notification" id="chatbot-notification">1</div>
    </div>

    <!-- Chatbot Window -->
    <div class="chatbot-window" id="chatbot-window">
        <!-- Chatbot Header -->
        <div class="chatbot-header">
            <div class="chatbot-header-info">
                <div class="chatbot-avatar">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Banglz Assistant" onerror="this.style.display='none'">
                    <div class="chatbot-avatar-fallback">B</div>
                </div>
                <div class="chatbot-header-text">
                    <h4>Banglz Assistant</h4>
                    <span class="chatbot-status">
                        <span class="status-dot"></span>
                        Online
                    </span>
                </div>
            </div>
            <button class="chatbot-minimize" id="chatbot-minimize">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 13H5V11H19V13Z" fill="currentColor"/>
                </svg>
            </button>
        </div>

        <!-- Chatbot Messages -->
        <div class="chatbot-messages" id="chatbot-messages">
            <div class="chatbot-message bot-message">
                <div class="message-avatar">
                    <div class="bot-avatar">B</div>
                </div>
                <div class="message-content">
                    <div class="message-bubble">
                        <p>Hello! Welcome to Banglz! 👋</p>
                        <p>I'm here to help you with any questions about our beautiful bangles and jewelry. How can I assist you today?</p>
                    </div>
                    <div class="message-time">Just now</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="chatbot-quick-actions" id="chatbot-quick-actions">
            <button class="quick-action-btn" data-message="Tell me about your products">
                🛍️ Our Products
            </button>
            <button class="quick-action-btn" data-message="How can I track my order?">
                📦 Track Order
            </button>
            <button class="quick-action-btn" data-message="What are your shipping options?">
                🚚 Shipping Info
            </button>
            <button class="quick-action-btn" data-message="I need help with sizing">
                📏 Size Guide
            </button>
        </div>

        <!-- Chatbot Input -->
        <div class="chatbot-input-container">
            <div class="chatbot-input-wrapper">
                <input type="text" class="chatbot-input" id="chatbot-input" placeholder="Type your message..." maxlength="500">
                <button class="chatbot-send-btn" id="chatbot-send-btn">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="chatbot-typing-indicator" id="chatbot-typing">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="typing-text">Banglz Assistant is typing...</span>
            </div>
        </div>
    </div>
</div>
