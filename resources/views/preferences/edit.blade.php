<x-layouts.user-default>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Communication Preferences</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="text-muted mb-4">
                            Choose which types of emails you'd like to receive from us. You can update these preferences at any time.
                        </p>

                        <form action="{{ route('preferences.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="marketing_emails" 
                                           name="marketing_emails" value="1" 
                                           {{ old('marketing_emails', $preferences['marketing_emails'] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="marketing_emails">
                                        <strong>Marketing Emails</strong>
                                        <p class="text-muted small mb-0">Receive promotional offers, new product announcements, and special deals.</p>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="order_updates" 
                                           name="order_updates" value="1" 
                                           {{ old('order_updates', $preferences['order_updates'] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="order_updates">
                                        <strong>Order Updates</strong>
                                        <p class="text-muted small mb-0">Get notified about your order status, shipping updates, and delivery confirmations.</p>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="newsletter" 
                                           name="newsletter" value="1" 
                                           {{ old('newsletter', $preferences['newsletter'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="newsletter">
                                        <strong>Newsletter</strong>
                                        <p class="text-muted small mb-0">Subscribe to our monthly newsletter with tips, trends, and exclusive content.</p>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="product_recommendations" 
                                           name="product_recommendations" value="1" 
                                           {{ old('product_recommendations', $preferences['product_recommendations'] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_recommendations">
                                        <strong>Product Recommendations</strong>
                                        <p class="text-muted small mb-0">Receive personalized product suggestions based on your preferences and browsing history.</p>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('personal-account') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Preferences</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.user-default>
