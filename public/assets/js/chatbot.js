/**
 * Banglz Professional Chatbot
 * Dynamic messaging with static responses
 */

class BanglzChatbot {
    constructor() {
        this.isOpen = false;
        this.messageCount = 0;
        this.responses = this.initializeResponses();
        this.init();
    }

    init() {
        this.bindEvents();
        this.showInitialNotification();
    }

    bindEvents() {
        const toggle = document.getElementById('chatbot-toggle');
        const minimize = document.getElementById('chatbot-minimize');
        const sendBtn = document.getElementById('chatbot-send-btn');
        const input = document.getElementById('chatbot-input');
        const quickActions = document.querySelectorAll('.quick-action-btn');

        if (toggle) {
            toggle.addEventListener('click', () => this.toggleChat());
        }

        if (minimize) {
            minimize.addEventListener('click', () => this.closeChat());
        }

        if (sendBtn) {
            sendBtn.addEventListener('click', () => this.sendMessage());
        }

        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.sendMessage();
                }
            });

            input.addEventListener('input', () => {
                this.updateSendButton();
            });
        }

        quickActions.forEach(btn => {
            btn.addEventListener('click', () => {
                const message = btn.getAttribute('data-message');
                this.sendUserMessage(message);
            });
        });
    }

    initializeResponses() {
        return {
            greetings: [
                "Hello! Welcome to Banglz! 👋 How can I help you today?",
                "Hi there! Thanks for visiting Banglz. What can I assist you with?",
                "Welcome! I'm here to help you find the perfect bangles. What would you like to know?"
            ],
            products: [
                "We offer a stunning collection of bangles in various styles! 💍\n\n✨ Traditional Bangles\n✨ Modern Designer Pieces\n✨ Custom Bangle Sets\n✨ Bridal Collections\n\nWould you like to explore any specific category?",
                "Our bangle collection features over 250+ unique designs! From classic gold to contemporary styles, we have something for every occasion. Check out our 'Banglz Box' to create your custom set!",
                "Discover our beautiful range:\n\n🌟 Everyday Elegance\n🌟 Special Occasion Sets\n🌟 Bridal Collections\n🌟 Custom Designs\n\nVisit our catalog to see the full collection!"
            ],
            sizing: [
                "Finding the right size is important! 📏\n\nHere's how to measure:\n1. Use a measuring tape around your wrist\n2. Add 0.5-1 inch for comfort\n3. Check our size guide for exact measurements\n\nNeed help with a specific size? I'm here to assist!",
                "Our bangles come in standard sizes from XS to XL. For the perfect fit:\n\n• Measure your wrist circumference\n• Consider the bangle width\n• Think about your comfort preference\n\nWould you like me to guide you through measuring?",
                "Size matters for comfort and style! 💫\n\nWe offer:\n- Standard sizes (XS-XL)\n- Custom sizing available\n- Size exchange policy\n\nCheck our detailed size guide or contact us for personalized assistance!"
            ],
            shipping: [
                "We offer several shipping options! 🚚\n\n📦 Standard Shipping (3-5 days) - Free on orders $75+\n⚡ Express Shipping (1-2 days) - $15\n🎁 Gift Wrapping Available\n\nAll orders are carefully packaged and insured!",
                "Shipping made simple:\n\n✅ Free standard shipping on orders over $75\n✅ Express options available\n✅ International shipping to select countries\n✅ Order tracking included\n\nWhere would you like your order shipped?",
                "Fast and secure shipping worldwide! 🌍\n\n• Standard: 3-5 business days\n• Express: 1-2 business days\n• International: 7-14 business days\n\nAll packages include tracking and insurance!"
            ],
            orders: [
                "Track your order easily! 📱\n\n1. Check your email for tracking info\n2. Use our order tracking page\n3. Contact us with your order number\n\nNeed help finding your tracking details?",
                "Order tracking is simple:\n\n✉️ Check your confirmation email\n🔍 Visit our 'Track Order' page\n📞 Call us with your order number\n\nWhat's your order number? I can help you track it!",
                "Stay updated on your order! 📦\n\n• Automatic email updates\n• Real-time tracking\n• SMS notifications available\n\nEnter your order number on our tracking page or share it with me!"
            ],
            returns: [
                "We want you to love your bangles! 💝\n\n✅ 30-day return policy\n✅ Free return shipping\n✅ Full refund or exchange\n✅ Easy return process\n\nNeed to return something? I'll guide you through it!",
                "Returns made easy:\n\n• 30 days from delivery\n• Original condition required\n• Free return labels provided\n• Quick refund processing\n\nWhat would you like to return?",
                "Your satisfaction is guaranteed! 🌟\n\n📅 30-day return window\n💰 Full refunds available\n🔄 Easy exchanges\n📦 Free return shipping\n\nStart your return process anytime!"
            ],
            care: [
                "Keep your bangles beautiful! ✨\n\n💎 Clean with soft cloth\n💧 Avoid harsh chemicals\n🏠 Store in jewelry box\n🌙 Remove before sleeping\n\nProper care ensures lasting beauty!",
                "Bangle care tips:\n\n• Gentle cleaning only\n• Store separately to avoid scratches\n• Keep away from perfumes/lotions\n• Professional cleaning available\n\nNeed specific care instructions for your bangles?",
                "Maintain that sparkle! 💫\n\n🧽 Regular gentle cleaning\n📦 Proper storage\n🚿 Remove before water activities\n💍 Professional maintenance available\n\nWant detailed care instructions?"
            ],
            appointment: [
                "Book a personal styling session! 👩‍💼\n\n📅 Virtual consultations available\n🏪 In-store appointments\n💎 Personal styling service\n🎨 Custom design consultations\n\nReady to schedule your appointment?",
                "Personal service at its best:\n\n• One-on-one styling sessions\n• Custom design consultations\n• Virtual or in-person meetings\n• Expert advice included\n\nWhat type of appointment interests you?",
                "Experience personalized service! ⭐\n\n🗓️ Flexible scheduling\n👥 Expert stylists\n💻 Virtual options available\n🎯 Tailored recommendations\n\nLet's book your session today!"
            ],
            default: [
                "I'd be happy to help! Could you please provide more details about what you're looking for?",
                "That's a great question! Let me connect you with the right information. What specifically would you like to know?",
                "I'm here to assist! Could you rephrase your question or choose from our quick options below?",
                "Thanks for reaching out! For the best assistance, could you be more specific about your inquiry?"
            ],
            thanks: [
                "You're very welcome! Is there anything else I can help you with today? 😊",
                "Happy to help! Feel free to ask if you have any other questions!",
                "My pleasure! Don't hesitate to reach out if you need anything else!"
            ]
        };
    }

    showInitialNotification() {
        setTimeout(() => {
            const notification = document.getElementById('chatbot-notification');
            if (notification && !this.isOpen) {
                notification.classList.remove('hidden');
            }
        }, 3000);
    }

    toggleChat() {
        const container = document.getElementById('chatbot-container');
        const notification = document.getElementById('chatbot-notification');
        
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        const container = document.getElementById('chatbot-container');
        const notification = document.getElementById('chatbot-notification');
        const quickActions = document.getElementById('chatbot-quick-actions');
        
        container.classList.add('active');
        notification.classList.add('hidden');
        this.isOpen = true;
        
        // Show quick actions initially
        if (quickActions && this.messageCount === 0) {
            quickActions.style.display = 'flex';
        }
        
        // Focus input
        setTimeout(() => {
            const input = document.getElementById('chatbot-input');
            if (input) input.focus();
        }, 300);
    }

    closeChat() {
        const container = document.getElementById('chatbot-container');
        container.classList.remove('active');
        this.isOpen = false;
    }

    sendMessage() {
        const input = document.getElementById('chatbot-input');
        const message = input.value.trim();
        
        if (message) {
            this.sendUserMessage(message);
            input.value = '';
            this.updateSendButton();
        }
    }

    sendUserMessage(message) {
        this.addMessage(message, 'user');
        this.hideQuickActions();
        
        // Show typing indicator
        this.showTypingIndicator();
        
        // Generate and send bot response
        setTimeout(() => {
            this.hideTypingIndicator();
            const response = this.generateResponse(message);
            this.addMessage(response, 'bot');
        }, 1000 + Math.random() * 1500); // Random delay for realism
    }

    addMessage(text, sender) {
        const messagesContainer = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${sender}-message`;
        
        const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <div class="${sender}-avatar">${sender === 'user' ? 'U' : 'B'}</div>
            </div>
            <div class="message-content">
                <div class="message-bubble">
                    ${this.formatMessage(text)}
                </div>
                <div class="message-time">${currentTime}</div>
            </div>
        `;
        
        messagesContainer.appendChild(messageDiv);
        this.scrollToBottom();
        this.messageCount++;
    }

    formatMessage(text) {
        // Convert line breaks to paragraphs
        const paragraphs = text.split('\n').filter(p => p.trim());
        return paragraphs.map(p => `<p>${this.escapeHtml(p)}</p>`).join('');
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    generateResponse(userMessage) {
        const message = userMessage.toLowerCase();
        
        // Greeting patterns
        if (this.matchesPattern(message, ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening'])) {
            return this.getRandomResponse('greetings');
        }
        
        // Product inquiries
        if (this.matchesPattern(message, ['product', 'bangle', 'jewelry', 'collection', 'catalog', 'what do you sell', 'show me'])) {
            return this.getRandomResponse('products');
        }
        
        // Sizing questions
        if (this.matchesPattern(message, ['size', 'sizing', 'measure', 'fit', 'how to measure', 'what size'])) {
            return this.getRandomResponse('sizing');
        }
        
        // Shipping inquiries
        if (this.matchesPattern(message, ['shipping', 'delivery', 'ship', 'how long', 'when will', 'shipping cost'])) {
            return this.getRandomResponse('shipping');
        }
        
        // Order tracking
        if (this.matchesPattern(message, ['track', 'order', 'tracking', 'where is my', 'order status', 'delivery status'])) {
            return this.getRandomResponse('orders');
        }
        
        // Returns and exchanges
        if (this.matchesPattern(message, ['return', 'exchange', 'refund', 'send back', 'not satisfied'])) {
            return this.getRandomResponse('returns');
        }
        
        // Care instructions
        if (this.matchesPattern(message, ['care', 'clean', 'maintain', 'polish', 'how to care', 'cleaning'])) {
            return this.getRandomResponse('care');
        }
        
        // Appointments
        if (this.matchesPattern(message, ['appointment', 'consultation', 'book', 'schedule', 'meet', 'styling'])) {
            return this.getRandomResponse('appointment');
        }
        
        // Thanks
        if (this.matchesPattern(message, ['thank', 'thanks', 'appreciate', 'helpful'])) {
            return this.getRandomResponse('thanks');
        }
        
        // Default response
        return this.getRandomResponse('default');
    }

    matchesPattern(message, patterns) {
        return patterns.some(pattern => message.includes(pattern));
    }

    getRandomResponse(category) {
        const responses = this.responses[category];
        return responses[Math.floor(Math.random() * responses.length)];
    }

    showTypingIndicator() {
        const indicator = document.getElementById('chatbot-typing');
        if (indicator) {
            indicator.classList.add('active');
            this.scrollToBottom();
        }
    }

    hideTypingIndicator() {
        const indicator = document.getElementById('chatbot-typing');
        if (indicator) {
            indicator.classList.remove('active');
        }
    }

    hideQuickActions() {
        const quickActions = document.getElementById('chatbot-quick-actions');
        if (quickActions && this.messageCount > 0) {
            quickActions.style.display = 'none';
        }
    }

    updateSendButton() {
        const input = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send-btn');
        
        if (input && sendBtn) {
            sendBtn.disabled = !input.value.trim();
        }
    }

    scrollToBottom() {
        const messagesContainer = document.getElementById('chatbot-messages');
        if (messagesContainer) {
            setTimeout(() => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 100);
        }
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new BanglzChatbot();
});

// Handle page visibility changes
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        // Page is visible again, could show notification
        const notification = document.getElementById('chatbot-notification');
        const container = document.getElementById('chatbot-container');
        
        if (notification && container && !container.classList.contains('active')) {
            setTimeout(() => {
                notification.classList.remove('hidden');
            }, 2000);
        }
    }
});
