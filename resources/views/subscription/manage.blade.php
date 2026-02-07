<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>
            .subscription-container {
                max-width: 600px;
                margin: 80px auto;
                padding: 40px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .subscription-header {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .subscription-header h1 {
                font-size: 28px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
            }
            
            .subscription-header p {
                font-size: 16px;
                color: #666;
            }
            
            .subscription-form {
                margin-bottom: 30px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-group label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
            }
            
            .form-group input {
                width: 100%;
                padding: 12px 15px;
                font-size: 16px;
                border: 1px solid #ddd;
                border-radius: 5px;
                transition: border-color 0.3s;
            }
            
            .form-group input:focus {
                outline: none;
                border-color: #8d5943;
            }
            
            .btn-group {
                display: flex;
                gap: 10px;
                margin-top: 20px;
            }
            
            .btn {
                flex: 1;
                padding: 12px 20px;
                font-size: 16px;
                font-weight: 600;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.3s;
            }
            
            .btn-check {
                background: #6c757d;
                color: white;
            }
            
            .btn-check:hover {
                background: #5a6268;
            }
            
            .btn-unsubscribe {
                background: #dc3545;
                color: white;
            }
            
            .btn-unsubscribe:hover {
                background: #c82333;
            }
            
            .btn-subscribe {
                background: #28a745;
                color: white;
            }
            
            .btn-subscribe:hover {
                background: #218838;
            }
            
            .btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }
            
            .status-message {
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                display: none;
            }
            
            .status-message.success {
                background: #d4edda;
                border: 1px solid #c3e6cb;
                color: #155724;
            }
            
            .status-message.error {
                background: #f8d7da;
                border: 1px solid #f5c6cb;
                color: #721c24;
            }
            
            .status-message.info {
                background: #d1ecf1;
                border: 1px solid #bee5eb;
                color: #0c5460;
            }
            
            .current-status {
                padding: 15px;
                background: #f8f9fa;
                border-radius: 5px;
                margin-bottom: 20px;
                display: none;
            }
            
            .current-status.subscribed {
                border-left: 4px solid #28a745;
            }
            
            .current-status.unsubscribed {
                border-left: 4px solid #dc3545;
            }
            
            .current-status h3 {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 5px;
            }
            
            .current-status p {
                font-size: 14px;
                color: #666;
                margin: 0;
            }
        </style>
    </x-slot>
    
    <x-slot name="content">
        <div class="subscription-container">
            <div class="subscription-header">
                <h1>Manage Email Subscriptions</h1>
                <p>Enter your email address to manage your subscription preferences</p>
            </div>
            
            <div id="statusMessage" class="status-message"></div>
            
            <div id="currentStatus" class="current-status"></div>
            
            <div class="subscription-form">
                <form id="subscriptionForm">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </div>
                    
                    <div class="btn-group">
                        <button type="button" id="checkStatusBtn" class="btn btn-check">
                            Check Status
                        </button>
                        <button type="button" id="unsubscribeBtn" class="btn btn-unsubscribe" style="display: none;">
                            Unsubscribe
                        </button>
                        <button type="button" id="subscribeBtn" class="btn btn-subscribe" style="display: none;">
                            Re-Subscribe
                        </button>
                    </div>
                </form>
            </div>
            
            <div style="text-align: center; margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee;">
                <p style="font-size: 14px; color: #666;">
                    Have questions? <a href="{{ route('contact-us') }}" style="color: #8d5943;">Contact us</a>
                </p>
            </div>
        </div>
    </x-slot>
    
    <x-slot name="insertjavascript">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const emailInput = document.getElementById('email');
            const checkStatusBtn = document.getElementById('checkStatusBtn');
            const unsubscribeBtn = document.getElementById('unsubscribeBtn');
            const subscribeBtn = document.getElementById('subscribeBtn');
            const statusMessage = document.getElementById('statusMessage');
            const currentStatus = document.getElementById('currentStatus');
            
            let currentEmail = '';
            let isSubscribed = null;
            
            // Check status button
            checkStatusBtn.addEventListener('click', function() {
                const email = emailInput.value.trim();
                
                if (!email) {
                    showMessage('Please enter your email address.', 'error');
                    return;
                }
                
                if (!isValidEmail(email)) {
                    showMessage('Please enter a valid email address.', 'error');
                    return;
                }
                
                checkStatus(email);
            });
            
            // Unsubscribe button
            unsubscribeBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Unsubscribe from Marketing Emails?',
                    text: "You will no longer receive promotional offers and special deals.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, unsubscribe',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        unsubscribe(currentEmail);
                    }
                });
            });
            
            // Subscribe button
            subscribeBtn.addEventListener('click', function() {
                subscribe(currentEmail);
            });
            
            // Check subscription status
            function checkStatus(email) {
                checkStatusBtn.disabled = true;
                checkStatusBtn.textContent = 'Checking...';
                
                fetch('{{ route("subscription.check") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(res => res.json())
                .then(data => {
                    checkStatusBtn.disabled = false;
                    checkStatusBtn.textContent = 'Check Status';
                    
                    if (data.success) {
                        currentEmail = email;
                        isSubscribed = data.subscribed;
                        showCurrentStatus(data.subscribed);
                        showMessage(data.message, 'info');
                        updateButtons(data.subscribed);
                    } else {
                        showMessage(data.message, 'error');
                        hideButtons();
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    checkStatusBtn.disabled = false;
                    checkStatusBtn.textContent = 'Check Status';
                    showMessage('An error occurred. Please try again.', 'error');
                });
            }
            
            // Unsubscribe
            function unsubscribe(email) {
                unsubscribeBtn.disabled = true;
                unsubscribeBtn.textContent = 'Unsubscribing...';
                
                fetch('{{ route("subscription.unsubscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(res => res.json())
                .then(data => {
                    unsubscribeBtn.disabled = false;
                    unsubscribeBtn.textContent = 'Unsubscribe';
                    
                    if (data.success) {
                        isSubscribed = false;
                        showCurrentStatus(false);
                        updateButtons(false);
                        
                        Swal.fire({
                            title: 'Unsubscribed!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#8d5943'
                        });
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    unsubscribeBtn.disabled = false;
                    unsubscribeBtn.textContent = 'Unsubscribe';
                    showMessage('An error occurred. Please try again.', 'error');
                });
            }
            
            // Subscribe
            function subscribe(email) {
                subscribeBtn.disabled = true;
                subscribeBtn.textContent = 'Subscribing...';
                
                fetch('{{ route("subscription.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(res => res.json())
                .then(data => {
                    subscribeBtn.disabled = false;
                    subscribeBtn.textContent = 'Re-Subscribe';
                    
                    if (data.success) {
                        isSubscribed = true;
                        showCurrentStatus(true);
                        updateButtons(true);
                        
                        Swal.fire({
                            title: 'Subscribed!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#8d5943'
                        });
                    } else {
                        showMessage(data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    subscribeBtn.disabled = false;
                    subscribeBtn.textContent = 'Re-Subscribe';
                    showMessage('An error occurred. Please try again.', 'error');
                });
            }
            
            // Show message
            function showMessage(message, type) {
                statusMessage.textContent = message;
                statusMessage.className = 'status-message ' + type;
                statusMessage.style.display = 'block';
                
                setTimeout(() => {
                    statusMessage.style.display = 'none';
                }, 5000);
            }
            
            // Show current status
            function showCurrentStatus(subscribed) {
                currentStatus.className = 'current-status ' + (subscribed ? 'subscribed' : 'unsubscribed');
                currentStatus.innerHTML = `
                    <h3>${subscribed ? '✓ Subscribed' : '✗ Unsubscribed'}</h3>
                    <p>${subscribed ? 'You are receiving marketing emails' : 'You are not receiving marketing emails'}</p>
                `;
                currentStatus.style.display = 'block';
            }
            
            // Update buttons
            function updateButtons(subscribed) {
                if (subscribed) {
                    unsubscribeBtn.style.display = 'block';
                    subscribeBtn.style.display = 'none';
                } else {
                    unsubscribeBtn.style.display = 'none';
                    subscribeBtn.style.display = 'block';
                }
            }
            
            // Hide buttons
            function hideButtons() {
                unsubscribeBtn.style.display = 'none';
                subscribeBtn.style.display = 'none';
                currentStatus.style.display = 'none';
            }
            
            // Validate email
            function isValidEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }
            
            // Allow Enter key to check status
            emailInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    checkStatusBtn.click();
                }
            });
        </script>
    </x-slot>
</x-layouts.user-default>
