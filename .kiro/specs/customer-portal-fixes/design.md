# Design Document: Customer Portal Fixes

## Overview

This design addresses five critical functional gaps in the Laravel e-commerce Customer Portal: search bar email auto-population, non-functional address management, broken password change functionality, non-working communication preferences, and a non-functional subscription management system. The solution implements proper Laravel MVC architecture with dedicated controllers, service classes for business logic, form request validation, database migrations, and email notifications using Laravel's built-in mail system.

The design follows Laravel best practices including:
- Service classes for business logic separation
- Form Request classes for validation
- Eloquent ORM for database operations
- Laravel Mail for email notifications
- Blade templates for views
- RESTful routing conventions

## Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Customer Portal UI                       │
│  (Blade Templates: search bar, addresses, password, prefs)  │
└────────────────────┬────────────────────────────────────────┘
                     │ HTTP Requests
                     ▼
┌─────────────────────────────────────────────────────────────┐
│                    Laravel Routes Layer                      │
│         (web.php: authenticated route definitions)          │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│                   Controller Layer                           │
│  AddressController | PasswordController | PreferenceController│
│              SubscriptionController                          │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│                  Service Layer                               │
│  AddressService | PasswordService | PreferenceService |      │
│              SubscriptionService                             │
└────────────────────┬────────────────────────────────────────┘
                     │
        ┌────────────┼────────────┐
        ▼            ▼            ▼
┌──────────────┐ ┌──────────┐ ┌──────────────┐
│   Eloquent   │ │  Email   │ │  Validation  │
│    Models    │ │ Service  │ │   Service    │
│              │ │          │ │              │
│ User         │ │ Mailable │ │ Form Request │
│ Address      │ │ Classes  │ │   Classes    │
└──────┬───────┘ └────┬─────┘ └──────────────┘
       │              │
       ▼              ▼
┌──────────────┐ ┌──────────────┐
│   Database   │ │ Email Queue  │
│   (MySQL)    │ │   (Redis)    │
└──────────────┘ └──────────────┘
```

### Component Interaction Flow

**Address Management Flow:**
1. User submits address form → AddressController receives request
2. Controller validates via StoreAddressRequest/UpdateAddressRequest
3. Controller calls AddressService to perform business logic
4. AddressService interacts with Address model to persist data
5. Controller returns response with success/error messages

**Password Change Flow:**
1. User submits password form → PasswordController receives request
2. Controller validates via ChangePasswordRequest
3. Controller calls PasswordService to verify current password
4. PasswordService updates password hash via User model
5. PasswordService triggers PasswordChangedMail notification
6. Controller returns success response

**Preference Update Flow:**
1. User updates preferences → PreferenceController receives request
2. Controller validates via UpdatePreferencesRequest
3. Controller calls PreferenceService to update preferences
4. PreferenceService updates User model or UserPreference model
5. PreferenceService triggers PreferencesUpdatedMail notification
6. Controller returns success response

**Subscription Management Flow:**
1. User clicks subscribe/unsubscribe → SubscriptionController receives request
2. Controller calls SubscriptionService to toggle status
3. SubscriptionService updates User model's email_subscribed field
4. Controller returns updated subscription status

## Components and Interfaces

### Controllers

#### AddressController

```php
class AddressController extends Controller
{
    private AddressService $addressService;
    
    public function __construct(AddressService $addressService)
    {
        $this->middleware('auth');
        $this->addressService = $addressService;
    }
    
    // Display all addresses for authenticated user
    public function index(): View
    
    // Show form for creating new address
    public function create(): View
    
    // Store new address
    public function store(StoreAddressRequest $request): RedirectResponse
    
    // Show form for editing address
    public function edit(Address $address): View
    
    // Update existing address
    public function update(UpdateAddressRequest $request, Address $address): RedirectResponse
    
    // Delete address
    public function destroy(Address $address): RedirectResponse
}
```

#### PasswordController

```php
class PasswordController extends Controller
{
    private PasswordService $passwordService;
    
    public function __construct(PasswordService $passwordService)
    {
        $this->middleware('auth');
        $this->passwordService = $passwordService;
    }
    
    // Show password change form
    public function edit(): View
    
    // Process password change
    public function update(ChangePasswordRequest $request): RedirectResponse
}
```

#### PreferenceController

```php
class PreferenceController extends Controller
{
    private PreferenceService $preferenceService;
    
    public function __construct(PreferenceService $preferenceService)
    {
        $this->middleware('auth');
        $this->preferenceService = $preferenceService;
    }
    
    // Show preferences form
    public function edit(): View
    
    // Update preferences
    public function update(UpdatePreferencesRequest $request): RedirectResponse
}
```

#### SubscriptionController

```php
class SubscriptionController extends Controller
{
    private SubscriptionService $subscriptionService;
    
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->middleware('auth');
        $this->subscriptionService = $subscriptionService;
    }
    
    // Toggle subscription status
    public function toggle(): JsonResponse
}
```

### Service Classes

#### AddressService

```php
class AddressService
{
    // Create new address for user
    public function createAddress(User $user, array $data): Address
    
    // Update existing address
    public function updateAddress(Address $address, array $data): Address
    
    // Delete address
    public function deleteAddress(Address $address): bool
    
    // Get all addresses for user
    public function getUserAddresses(User $user): Collection
    
    // Check if user has reached address limit
    public function hasReachedAddressLimit(User $user): bool
    
    // Validate address ownership
    public function userOwnsAddress(User $user, Address $address): bool
}
```

#### PasswordService

```php
class PasswordService
{
    // Verify current password matches stored hash
    public function verifyCurrentPassword(User $user, string $currentPassword): bool
    
    // Update user password with new hash
    public function updatePassword(User $user, string $newPassword): bool
    
    // Send password change confirmation email
    public function sendPasswordChangedNotification(User $user): void
    
    // Validate password meets security requirements
    public function validatePasswordStrength(string $password): bool
}
```

#### PreferenceService

```php
class PreferenceService
{
    // Update user communication preferences
    public function updatePreferences(User $user, array $preferences): bool
    
    // Get current preferences for user
    public function getPreferences(User $user): array
    
    // Send preferences updated confirmation email
    public function sendPreferencesUpdatedNotification(User $user, array $preferences): void
}
```

#### SubscriptionService

```php
class SubscriptionService
{
    // Toggle subscription status
    public function toggleSubscription(User $user): bool
    
    // Get current subscription status
    public function getSubscriptionStatus(User $user): bool
    
    // Unsubscribe user
    public function unsubscribe(User $user): bool
    
    // Subscribe user
    public function subscribe(User $user): bool
}
```

### Form Request Validation Classes

#### StoreAddressRequest

```php
class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Check user has not reached 3 address limit
        return auth()->user()->addresses()->count() < 3;
    }
    
    public function rules(): array
    {
        return [
            'recipient_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ];
    }
    
    public function messages(): array
    {
        // Custom error messages
    }
}
```

#### UpdateAddressRequest

```php
class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Check user owns the address being updated
        return $this->route('address')->user_id === auth()->id();
    }
    
    public function rules(): array
    {
        return [
            'recipient_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ];
    }
}
```

#### ChangePasswordRequest

```php
class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Already authenticated via middleware
    }
    
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'new_password_confirmation' => 'required|string',
        ];
    }
    
    public function messages(): array
    {
        return [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}
```

#### UpdatePreferencesRequest

```php
class UpdatePreferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Already authenticated via middleware
    }
    
    public function rules(): array
    {
        return [
            'marketing_emails' => 'boolean',
            'order_updates' => 'boolean',
            'newsletter' => 'boolean',
            'product_recommendations' => 'boolean',
        ];
    }
}
```

## Data Models

### Address Model

```php
class Address extends Model
{
    protected $table = 'shipping_addresses';
    
    protected $fillable = [
        'user_id',
        'recipient_name',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Relationship: Address belongs to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // Format address as single string
    public function getFullAddressAttribute(): string
    {
        return "{$this->street_address}, {$this->city}, {$this->state} {$this->postal_code}, {$this->country}";
    }
}
```

### User Model Extensions

```php
class User extends Authenticatable
{
    // Add to existing fillable array
    protected $fillable = [
        // ... existing fields
        'email_subscribed',
        'marketing_emails',
        'order_updates',
        'newsletter',
        'product_recommendations',
    ];
    
    // Add to existing casts array
    protected $casts = [
        // ... existing casts
        'email_subscribed' => 'boolean',
        'marketing_emails' => 'boolean',
        'order_updates' => 'boolean',
        'newsletter' => 'boolean',
        'product_recommendations' => 'boolean',
    ];
    
    // Relationship: User has many Addresses
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
    
    // Check if user can add more addresses
    public function canAddAddress(): bool
    {
        return $this->addresses()->count() < 3;
    }
}
```

### Database Migrations

#### Create Shipping Addresses Table

```php
Schema::create('shipping_addresses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('recipient_name');
    $table->string('street_address', 500);
    $table->string('city');
    $table->string('state');
    $table->string('postal_code', 20);
    $table->string('country');
    $table->timestamps();
    
    $table->index('user_id');
});
```

#### Add Communication Preferences to Users Table

```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('email_subscribed')->default(true);
    $table->boolean('marketing_emails')->default(true);
    $table->boolean('order_updates')->default(true);
    $table->boolean('newsletter')->default(false);
    $table->boolean('product_recommendations')->default(true);
});
```

### Email Notifications

#### PasswordChangedMail

```php
class PasswordChangedMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public User $user;
    public Carbon $changedAt;
    
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->changedAt = now();
    }
    
    public function build(): self
    {
        return $this->subject('Password Changed Successfully')
                    ->markdown('emails.password-changed')
                    ->with([
                        'userName' => $this->user->name,
                        'changedAt' => $this->changedAt->format('F j, Y g:i A'),
                    ]);
    }
}
```

#### PreferencesUpdatedMail

```php
class PreferencesUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public User $user;
    public array $preferences;
    
    public function __construct(User $user, array $preferences)
    {
        $this->user = $user;
        $this->preferences = $preferences;
    }
    
    public function build(): self
    {
        return $this->subject('Communication Preferences Updated')
                    ->markdown('emails.preferences-updated')
                    ->with([
                        'userName' => $this->user->name,
                        'preferences' => $this->preferences,
                    ]);
    }
}
```

### Routes

```php
// web.php
Route::middleware(['auth'])->group(function () {
    // Address Management
    Route::resource('addresses', AddressController::class)
         ->except(['show']);
    
    // Password Management
    Route::get('password/change', [PasswordController::class, 'edit'])
         ->name('password.edit');
    Route::put('password/change', [PasswordController::class, 'update'])
         ->name('password.update');
    
    // Communication Preferences
    Route::get('preferences', [PreferenceController::class, 'edit'])
         ->name('preferences.edit');
    Route::put('preferences', [PreferenceController::class, 'update'])
         ->name('preferences.update');
    
    // Subscription Management
    Route::post('subscription/toggle', [SubscriptionController::class, 'toggle'])
         ->name('subscription.toggle');
});
```

### View Layer (Blade Templates)

#### Search Bar Fix

The search bar email auto-population issue is typically caused by browser autocomplete or a JavaScript issue that populates the field with user data. The fix involves:

```blade
{{-- In the search bar component --}}
<input 
    type="search" 
    name="search" 
    id="search-bar"
    autocomplete="off"
    placeholder="Search products..."
    value=""
    class="search-input"
>
```

Key attributes:
- `type="search"` instead of `type="text"` to indicate search intent
- `autocomplete="off"` to prevent browser auto-fill
- `value=""` to ensure empty initial state
- Remove any JavaScript that might be setting the value from user session data

#### Address List View

```blade
{{-- resources/views/addresses/index.blade.php --}}
@if($addresses->isEmpty())
    <p class="empty-state">You currently don't have any saved addresses</p>
    <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Your First Address</a>
@else
    <div class="address-list">
        @foreach($addresses as $address)
            <div class="address-card">
                <h3>{{ $address->recipient_name }}</h3>
                <p>{{ $address->street_address }}</p>
                <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                <p>{{ $address->country }}</p>
                
                <div class="address-actions">
                    <a href="{{ route('addresses.edit', $address) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('addresses.destroy', $address) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($addresses->count() < 3)
        <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Another Address</a>
    @else
        <p class="info-message">You have reached the maximum of 3 saved addresses</p>
    @endif
@endif
```



## Correctness Properties

A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.

### Search Bar Properties

**Property 1: Search bar email exclusion**
*For any* user session and any page navigation within the Customer Portal, the search bar value should never contain the user's email address unless explicitly entered by the user.
**Validates: Requirements 1.2, 1.3**

### Address Management Properties

**Property 2: Address display completeness**
*For any* set of saved addresses, when rendered in the address list, all addresses should display all required fields (recipient name, street address, city, state, postal code, country).
**Validates: Requirements 2.2**

**Property 3: Address creation round-trip**
*For any* valid address data submitted by a user with fewer than 3 addresses, creating the address should result in the address being persisted to the database and appearing in the user's address list with all fields intact.
**Validates: Requirements 2.4**

**Property 4: Invalid address rejection**
*For any* address data missing required fields or containing improperly formatted data, the validation service should reject the submission and return specific error messages identifying each invalid field.
**Validates: Requirements 2.5**

**Property 5: Address update persistence**
*For any* existing address and any valid changes to its fields, updating the address should result in the changes being persisted to the database and reflected in the address list display.
**Validates: Requirements 2.6**

**Property 6: Address deletion completeness**
*For any* address owned by a user, deleting the address should remove it from both the database and the address list display, and the address should not be retrievable afterward.
**Validates: Requirements 2.7**

### Password Management Properties

**Property 7: Current password verification**
*For any* password change request, the system should verify the provided current password matches the stored password hash before allowing the change to proceed.
**Validates: Requirements 3.1**

**Property 8: Incorrect password rejection**
*For any* password change request with an incorrect current password, the system should reject the request and return an error message without updating the password.
**Validates: Requirements 3.2**

**Property 9: Password validation with error messages**
*For any* new password submission, the validation service should verify it meets security requirements (minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character), and if validation fails, should return specific error messages describing the requirements.
**Validates: Requirements 3.3, 3.4**

**Property 10: Secure password storage**
*For any* valid password change, the new password should be hashed using Laravel's secure hashing mechanism before storage, and the plain text password should never be stored in the database.
**Validates: Requirements 3.5, 6.3**

**Property 11: Password change notification**
*For any* successful password change, a confirmation email should be sent to the user's registered email address containing the timestamp of the change and security recommendations.
**Validates: Requirements 3.6, 3.7**

### Communication Preferences Properties

**Property 12: Preference display completeness**
*For any* user viewing their communication preferences, all available preference options (marketing emails, order updates, newsletter, product recommendations) should be displayed with their current states.
**Validates: Requirements 4.1**

**Property 13: Preference update round-trip**
*For any* valid preference changes submitted by a user, the changes should be persisted to the database, and querying the user's preferences afterward should return the updated values.
**Validates: Requirements 4.2**

**Property 14: Preference update notification**
*For any* successful preference update, a confirmation email should be sent to the user containing a summary of the updated preferences.
**Validates: Requirements 4.3, 4.4**

**Property 15: Invalid preference rejection**
*For any* preference submission containing invalid data types or values, the validation service should reject the submission and return appropriate error messages.
**Validates: Requirements 4.5**

### Subscription Management Properties

**Property 16: Subscription toggle persistence**
*For any* user toggling their subscription status (subscribe or unsubscribe), the change should be persisted immediately to the database, and the user's subscription status should reflect the new state.
**Validates: Requirements 5.1, 5.2, 5.3**

**Property 17: Unsubscribed user email exclusion**
*For any* marketing email send operation, users with subscription status set to unsubscribed should be excluded from the recipient list.
**Validates: Requirements 5.4**

**Property 18: Subscribed user email inclusion**
*For any* marketing email send operation, users with subscription status set to subscribed should be included in the recipient list.
**Validates: Requirements 5.5**

**Property 19: Subscription validation**
*For any* subscription toggle request, the system should validate that the user's email address exists in the system before processing the change.
**Validates: Requirements 5.6**

**Property 20: Subscription UI synchronization**
*For any* subscription status change, the Customer Portal UI should update the subscription button state to reflect the current subscription status (showing "Unsubscribe" when subscribed, "Subscribe" when unsubscribed).
**Validates: Requirements 5.7**

### Data Validation and Security Properties

**Property 21: Address field validation**
*For any* address submission, the validation service should verify all required fields (recipient name, street address, city, state, postal code, country) are present and properly formatted before processing.
**Validates: Requirements 6.2**

**Property 22: Safe error messages**
*For any* validation failure, the system should return error messages that are specific enough to guide the user but do not expose sensitive system information such as database structure, file paths, or internal implementation details.
**Validates: Requirements 6.5**

**Property 23: Cascade deletion**
*For any* user deletion, all associated addresses should be automatically deleted from the database through cascade deletion constraints.
**Validates: Requirements 7.5**

### Email Service Properties

**Property 24: Email timing compliance**
*For any* event that triggers an email notification (password change or preference update), the email should be queued and sent within 60 seconds of the triggering event.
**Validates: Requirements 8.1, 8.2**

**Property 25: Correct email recipient**
*For any* email sent by the system, the recipient address should be the user's registered email address from the database.
**Validates: Requirements 8.3**

**Property 26: Email failure resilience**
*For any* email that fails to send, the system should log the error with relevant details and continue processing the user's request without throwing an exception that would interrupt the user's workflow.
**Validates: Requirements 8.4**

## Error Handling

### Validation Errors

**Address Validation:**
- Missing required fields: Return 422 Unprocessable Entity with field-specific error messages
- Invalid format (e.g., postal code): Return 422 with format requirements
- Address limit exceeded: Return 403 Forbidden with message "Maximum of 3 addresses reached"
- Unauthorized access: Return 403 Forbidden when user attempts to modify another user's address

**Password Validation:**
- Incorrect current password: Return 422 with message "Current password is incorrect"
- Weak new password: Return 422 with specific requirements not met
- Password confirmation mismatch: Return 422 with message "Password confirmation does not match"

**Preference Validation:**
- Invalid boolean values: Return 422 with message "Preference values must be true or false"
- Unknown preference keys: Return 422 with message "Unknown preference option"

**Subscription Validation:**
- User not found: Return 404 Not Found
- Invalid subscription state: Return 422 with message "Invalid subscription status"

### Database Errors

**Connection Failures:**
- Catch database connection exceptions
- Log error with timestamp and connection details
- Return 503 Service Unavailable to user
- Display user-friendly message: "Service temporarily unavailable, please try again"

**Constraint Violations:**
- Foreign key violations: Log error and return 422 with message "Invalid reference"
- Unique constraint violations: Return 422 with message "Duplicate entry"

**Transaction Failures:**
- Wrap multi-step operations in database transactions
- Rollback on any failure to maintain data consistency
- Log transaction failures with full context
- Return appropriate error response to user

### Email Errors

**Send Failures:**
- Catch mail exceptions (connection timeout, invalid recipient, etc.)
- Log error with email type, recipient, and failure reason
- Continue processing user request (don't block on email failure)
- Queue retry for failed emails (up to 3 attempts with exponential backoff)

**Template Errors:**
- Catch view rendering exceptions
- Log error with template name and data
- Fall back to plain text email if HTML template fails
- Alert development team for template fixes

### Authorization Errors

**Ownership Validation:**
- Verify user owns address before edit/delete operations
- Return 403 Forbidden if ownership check fails
- Log unauthorized access attempts for security monitoring

**Authentication Errors:**
- Redirect unauthenticated users to login page
- Preserve intended destination for post-login redirect
- Display message: "Please log in to access this feature"

### Rate Limiting

**API Endpoints:**
- Limit password change attempts to 5 per hour per user
- Limit address operations to 20 per hour per user
- Return 429 Too Many Requests when limit exceeded
- Include Retry-After header with seconds until limit resets

## Testing Strategy

### Dual Testing Approach

This feature requires both unit tests and property-based tests to ensure comprehensive coverage:

**Unit Tests** focus on:
- Specific examples demonstrating correct behavior
- Edge cases (empty address list, 3-address limit, empty password)
- Integration points between controllers and services
- Error conditions and exception handling
- Specific validation rules

**Property-Based Tests** focus on:
- Universal properties that hold for all inputs
- Comprehensive input coverage through randomization
- Invariants that must be maintained across operations
- Round-trip properties (create then read, update then read)
- Security properties (password hashing, SQL injection prevention)

Both testing approaches are complementary and necessary. Unit tests catch concrete bugs in specific scenarios, while property-based tests verify general correctness across a wide range of inputs.

### Property-Based Testing Configuration

**Framework:** Use [Pest PHP](https://pestphp.com/) with the [pest-plugin-faker](https://github.com/pestphp/pest-plugin-faker) for property-based testing in Laravel.

**Configuration:**
- Minimum 100 iterations per property test (due to randomization)
- Each property test must reference its design document property
- Tag format: `// Feature: customer-portal-fixes, Property {number}: {property_text}`

**Example Property Test Structure:**

```php
// Feature: customer-portal-fixes, Property 3: Address creation round-trip
test('address creation persists all fields correctly', function () {
    // Run 100 iterations with random data
    expect(true)->toBeTrue()->repeat(100, function () {
        $user = User::factory()->create();
        $addressData = [
            'recipient_name' => fake()->name(),
            'street_address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
        ];
        
        $address = $user->addresses()->create($addressData);
        $retrieved = Address::find($address->id);
        
        expect($retrieved->recipient_name)->toBe($addressData['recipient_name']);
        expect($retrieved->street_address)->toBe($addressData['street_address']);
        expect($retrieved->city)->toBe($addressData['city']);
        expect($retrieved->state)->toBe($addressData['state']);
        expect($retrieved->postal_code)->toBe($addressData['postal_code']);
        expect($retrieved->country)->toBe($addressData['country']);
    });
});
```

### Unit Testing Strategy

**Controller Tests:**
- Test each controller action with valid inputs
- Test authorization (user can only access own addresses)
- Test validation error responses
- Test redirect responses and flash messages

**Service Tests:**
- Test business logic in isolation
- Mock external dependencies (email service, database)
- Test edge cases (address limit, empty states)
- Test error handling and exception cases

**Model Tests:**
- Test relationships (User hasMany Address)
- Test model methods (canAddAddress, getFullAddressAttribute)
- Test cascade deletion
- Test attribute casting

**Validation Tests:**
- Test each validation rule independently
- Test custom validation messages
- Test authorization logic in Form Requests
- Test edge cases (boundary values, special characters)

**Integration Tests:**
- Test complete user flows (login → add address → view addresses)
- Test email sending (using Mail::fake())
- Test database transactions and rollbacks
- Test session handling and flash messages

### Test Coverage Goals

- Minimum 80% code coverage for all service classes
- 100% coverage for validation logic
- 100% coverage for security-critical code (password hashing, authorization)
- All 26 correctness properties implemented as property-based tests
- Edge cases explicitly tested with unit tests

### Testing Edge Cases

**Address Management:**
- Empty address list display
- Exactly 3 addresses (at limit)
- Attempting to add 4th address
- Deleting last address (return to empty state)
- Special characters in address fields
- Very long address strings (boundary testing)

**Password Management:**
- Minimum length password (8 characters)
- Password with all required character types
- Password missing each character type
- Very long passwords (1000+ characters)
- Passwords with unicode characters
- Current password that doesn't match

**Preferences:**
- All preferences enabled
- All preferences disabled
- Mixed preference states
- Invalid boolean values
- Missing preference keys

**Subscription:**
- Toggling from subscribed to unsubscribed
- Toggling from unsubscribed to subscribed
- Multiple rapid toggles
- Subscription state persistence across sessions

### Continuous Integration

- Run all tests on every commit
- Run property-based tests with 100 iterations in CI
- Fail build if any test fails
- Generate coverage reports
- Alert team if coverage drops below thresholds
