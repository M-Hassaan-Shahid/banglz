# Implementation Plan: Customer Portal Fixes

## Overview

This implementation plan breaks down the Customer Portal fixes into discrete, incremental coding tasks. The approach follows Laravel best practices with service classes for business logic, Form Request validation, Eloquent models, and email notifications. Tasks are organized to build foundational components first (migrations, models), then implement core functionality (services, controllers), and finally wire everything together with routes and views. Testing tasks are included as optional sub-tasks to allow for faster MVP delivery while maintaining the option for comprehensive test coverage.

## Tasks

- [x] 1. Set up database schema and models
  - [x] 1.1 Create shipping addresses migration and model
    - Create migration file for `shipping_addresses` table with fields: user_id (foreign key), recipient_name, street_address, city, state, postal_code, country, timestamps
    - Add index on user_id for query performance
    - Add foreign key constraint with cascade delete
    - Create Address Eloquent model with fillable fields, user relationship, and getFullAddressAttribute accessor
    - _Requirements: 7.1, 7.4, 7.5_
  
  - [x] 1.2 Add communication preferences fields to users table
    - Create migration to add boolean fields to users table: email_subscribed (default true), marketing_emails (default true), order_updates (default true), newsletter (default false), product_recommendations (default true)
    - Update User model to include new fields in fillable array and cast them as boolean
    - Add addresses() relationship method to User model (hasMany)
    - Add canAddAddress() helper method to User model
    - _Requirements: 7.2, 7.3_
  
  - [ ]* 1.3 Write property test for cascade deletion
    - **Property 23: Cascade deletion**
    - **Validates: Requirements 7.5**
    - Test that deleting a user automatically deletes all associated addresses
  
  - [x] 1.4 Run migrations and verify schema
    - Execute migrations in development environment
    - Verify tables and columns exist with correct types
    - Verify foreign key constraints are in place
    - _Requirements: 7.1, 7.2, 7.3, 7.4_

- [x] 2. Implement address management functionality
  - [x] 2.1 Create Form Request validation classes for addresses
    - Create StoreAddressRequest with authorization checking address limit (< 3)
    - Create UpdateAddressRequest with authorization checking address ownership
    - Define validation rules for all address fields (required, string, max lengths)
    - Add custom error messages for validation failures
    - _Requirements: 2.3, 2.5, 6.2_
  
  - [x] 2.2 Create AddressService for business logic
    - Implement createAddress(User, array): Address method
    - Implement updateAddress(Address, array): Address method
    - Implement deleteAddress(Address): bool method
    - Implement getUserAddresses(User): Collection method
    - Implement hasReachedAddressLimit(User): bool method
    - Implement userOwnsAddress(User, Address): bool method
    - _Requirements: 2.1, 2.2, 2.4, 2.6, 2.7_
  
  - [x] 2.3 Create AddressController with CRUD operations
    - Implement index() to display all user addresses
    - Implement create() to show address creation form
    - Implement store(StoreAddressRequest) to save new address
    - Implement edit(Address) to show edit form with authorization
    - Implement update(UpdateAddressRequest, Address) to save changes
    - Implement destroy(Address) to delete address with authorization
    - Add auth middleware to constructor
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8_
  
  - [ ]* 2.4 Write property test for address display completeness
    - **Property 2: Address display completeness**
    - **Validates: Requirements 2.2**
  
  - [ ]* 2.5 Write property test for address creation round-trip
    - **Property 3: Address creation round-trip**
    - **Validates: Requirements 2.4**
  
  - [ ]* 2.6 Write property test for invalid address rejection
    - **Property 4: Invalid address rejection**
    - **Validates: Requirements 2.5**
  
  - [ ]* 2.7 Write property test for address update persistence
    - **Property 5: Address update persistence**
    - **Validates: Requirements 2.6**
  
  - [ ]* 2.8 Write property test for address deletion completeness
    - **Property 6: Address deletion completeness**
    - **Validates: Requirements 2.7**
  
  - [ ]* 2.9 Write unit tests for address edge cases
    - Test empty address list display
    - Test 3-address limit enforcement
    - Test deletion returning to empty state
    - _Requirements: 2.1, 2.3, 2.8_

- [x] 3. Implement password change functionality
  - [x] 3.1 Create ChangePasswordRequest validation class
    - Define validation rules: current_password (required), new_password (required, min:8, confirmed, regex for complexity), new_password_confirmation (required)
    - Add custom error message for password complexity requirements
    - _Requirements: 3.1, 3.2, 3.3, 3.4_
  
  - [x] 3.2 Create PasswordService for business logic
    - Implement verifyCurrentPassword(User, string): bool using Hash::check()
    - Implement updatePassword(User, string): bool using Hash::make()
    - Implement validatePasswordStrength(string): bool method
    - Implement sendPasswordChangedNotification(User): void method
    - _Requirements: 3.1, 3.2, 3.3, 3.5, 3.6, 6.3_
  
  - [x] 3.3 Create PasswordChangedMail mailable class
    - Create mailable with user and timestamp properties
    - Create markdown email template with password change details and security recommendations
    - Include timestamp formatted as readable date/time
    - _Requirements: 3.6, 3.7_
  
  - [x] 3.4 Create PasswordController
    - Implement edit() to show password change form
    - Implement update(ChangePasswordRequest) to process password change
    - Verify current password using PasswordService
    - Update password using PasswordService
    - Send confirmation email using PasswordService
    - Return success message or validation errors
    - Add auth middleware to constructor
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7_
  
  - [ ]* 3.5 Write property test for current password verification
    - **Property 7: Current password verification**
    - **Validates: Requirements 3.1**
  
  - [ ]* 3.6 Write property test for incorrect password rejection
    - **Property 8: Incorrect password rejection**
    - **Validates: Requirements 3.2**
  
  - [ ]* 3.7 Write property test for password validation with error messages
    - **Property 9: Password validation with error messages**
    - **Validates: Requirements 3.3, 3.4**
  
  - [ ]* 3.8 Write property test for secure password storage
    - **Property 10: Secure password storage**
    - **Validates: Requirements 3.5, 6.3**
  
  - [ ]* 3.9 Write property test for password change notification
    - **Property 11: Password change notification**
    - **Validates: Requirements 3.6, 3.7**

- [ ] 4. Checkpoint - Ensure core functionality works
  - Ensure all tests pass, ask the user if questions arise.

- [x] 5. Implement communication preferences functionality
  - [x] 5.1 Create UpdatePreferencesRequest validation class
    - Define validation rules for preference fields (marketing_emails, order_updates, newsletter, product_recommendations) as boolean
    - Add custom error messages for invalid boolean values
    - _Requirements: 4.5_
  
  - [x] 5.2 Create PreferenceService for business logic
    - Implement updatePreferences(User, array): bool method
    - Implement getPreferences(User): array method
    - Implement sendPreferencesUpdatedNotification(User, array): void method
    - _Requirements: 4.1, 4.2, 4.3, 4.4_
  
  - [x] 5.3 Create PreferencesUpdatedMail mailable class
    - Create mailable with user and preferences properties
    - Create markdown email template with preference summary
    - Format preferences as readable list in email
    - _Requirements: 4.3, 4.4_
  
  - [x] 5.4 Create PreferenceController
    - Implement edit() to show preferences form with current values
    - Implement update(UpdatePreferencesRequest) to save preference changes
    - Update preferences using PreferenceService
    - Send confirmation email using PreferenceService
    - Return success message or validation errors
    - Add auth middleware to constructor
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5_
  
  - [ ]* 5.5 Write property test for preference display completeness
    - **Property 12: Preference display completeness**
    - **Validates: Requirements 4.1**
  
  - [ ]* 5.6 Write property test for preference update round-trip
    - **Property 13: Preference update round-trip**
    - **Validates: Requirements 4.2**
  
  - [ ]* 5.7 Write property test for preference update notification
    - **Property 14: Preference update notification**
    - **Validates: Requirements 4.3, 4.4**
  
  - [ ]* 5.8 Write property test for invalid preference rejection
    - **Property 15: Invalid preference rejection**
    - **Validates: Requirements 4.5**

- [x] 6. Implement subscription management functionality
  - [x] 6.1 Create SubscriptionService for business logic
    - Implement toggleSubscription(User): bool method
    - Implement getSubscriptionStatus(User): bool method
    - Implement unsubscribe(User): bool method
    - Implement subscribe(User): bool method
    - _Requirements: 5.1, 5.2, 5.3, 5.6_
  
  - [x] 6.2 Create SubscriptionController
    - Implement toggle() to handle subscription status changes
    - Validate user email exists using SubscriptionService
    - Toggle subscription status using SubscriptionService
    - Return JSON response with new subscription status
    - Add auth middleware to constructor
    - _Requirements: 5.1, 5.2, 5.3, 5.6, 5.7_
  
  - [ ]* 6.3 Write property test for subscription toggle persistence
    - **Property 16: Subscription toggle persistence**
    - **Validates: Requirements 5.1, 5.2, 5.3**
  
  - [ ]* 6.4 Write property test for unsubscribed user email exclusion
    - **Property 17: Unsubscribed user email exclusion**
    - **Validates: Requirements 5.4**
  
  - [ ]* 6.5 Write property test for subscribed user email inclusion
    - **Property 18: Subscribed user email inclusion**
    - **Validates: Requirements 5.5**
  
  - [ ]* 6.6 Write property test for subscription validation
    - **Property 19: Subscription validation**
    - **Validates: Requirements 5.6**
  
  - [ ]* 6.7 Write property test for subscription UI synchronization
    - **Property 20: Subscription UI synchronization**
    - **Validates: Requirements 5.7**

- [ ] 7. Implement validation and security properties
  - [ ] 7.1 Add rate limiting to sensitive endpoints
    - Add rate limiting middleware to password change route (5 attempts per hour)
    - Add rate limiting middleware to address routes (20 operations per hour)
    - Configure rate limit responses with Retry-After headers
    - _Requirements: 6.1_
  
  - [ ]* 7.2 Write property test for address field validation
    - **Property 21: Address field validation**
    - **Validates: Requirements 6.2**
  
  - [ ]* 7.3 Write property test for safe error messages
    - **Property 22: Safe error messages**
    - **Validates: Requirements 6.5**

- [ ] 8. Implement email service properties
  - [ ] 8.1 Configure email queue and retry logic
    - Configure queue driver in .env (Redis recommended)
    - Set up queue worker for email processing
    - Configure retry logic for failed emails (3 attempts with exponential backoff)
    - Add error logging for email failures
    - _Requirements: 8.1, 8.2, 8.4_
  
  - [ ]* 8.2 Write property test for email timing compliance
    - **Property 24: Email timing compliance**
    - **Validates: Requirements 8.1, 8.2**
  
  - [ ]* 8.3 Write property test for correct email recipient
    - **Property 25: Correct email recipient**
    - **Validates: Requirements 8.3**
  
  - [ ]* 8.4 Write property test for email failure resilience
    - **Property 26: Email failure resilience**
    - **Validates: Requirements 8.4**

- [x] 9. Create routes and wire controllers
  - [x] 9.1 Define routes in web.php
    - Add authenticated route group with auth middleware
    - Add resource routes for addresses (except show)
    - Add password change routes (GET edit, PUT update)
    - Add preference routes (GET edit, PUT update)
    - Add subscription toggle route (POST)
    - Name all routes appropriately for use in views
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 3.1, 4.1, 4.2, 5.1, 5.2_
  
  - [x] 9.2 Register service providers and bindings
    - Register service classes in AppServiceProvider if needed
    - Ensure dependency injection works for all controllers
    - _Requirements: All_

- [x] 10. Create and update Blade views
  - [x] 10.1 Fix search bar email auto-population
    - Update search bar component to use type="search"
    - Add autocomplete="off" attribute
    - Ensure value attribute is empty string
    - Remove any JavaScript that sets value from user session
    - _Requirements: 1.1, 1.2, 1.3_
  
  - [x] 10.2 Create address management views
    - Create addresses/index.blade.php with empty state message and address list
    - Create addresses/create.blade.php with address form
    - Create addresses/edit.blade.php with pre-filled address form
    - Add delete confirmation dialog
    - Display validation errors in forms
    - Show success/error flash messages
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8_
  
  - [x] 10.3 Create password change view
    - Create password/edit.blade.php with password change form
    - Include fields for current password, new password, and confirmation
    - Display validation errors
    - Show success message after password change
    - _Requirements: 3.1, 3.2, 3.3, 3.4_
  
  - [x] 10.4 Create communication preferences view
    - Create preferences/edit.blade.php with preference checkboxes
    - Display all preference options with current states
    - Show success message after preference update
    - _Requirements: 4.1, 4.2_
  
  - [x] 10.5 Add subscription toggle button to portal
    - Add subscription button to customer portal layout or dashboard
    - Implement JavaScript to handle toggle via AJAX
    - Update button text based on subscription status
    - Show success/error messages after toggle
    - _Requirements: 5.1, 5.2, 5.7_
  
  - [ ]* 10.6 Write property test for search bar email exclusion
    - **Property 1: Search bar email exclusion**
    - **Validates: Requirements 1.2, 1.3**

- [x] 11. Create email templates
  - [x] 11.1 Create password changed email template
    - Create resources/views/emails/password-changed.blade.php
    - Include user name, timestamp, and security recommendations
    - Use responsive HTML layout
    - _Requirements: 3.6, 3.7_
  
  - [x] 11.2 Create preferences updated email template
    - Create resources/views/emails/preferences-updated.blade.php
    - Include user name and preference summary
    - Use responsive HTML layout
    - _Requirements: 4.3, 4.4_

- [ ] 12. Final checkpoint and integration testing
  - [ ] 12.1 Test complete user flows
    - Test login → view addresses → add address → edit address → delete address
    - Test password change flow with email verification
    - Test preference update flow with email verification
    - Test subscription toggle flow
    - Verify search bar remains empty after login
    - _Requirements: All_
  
  - [ ] 12.2 Verify error handling
    - Test validation errors display correctly
    - Test authorization errors (accessing other user's addresses)
    - Test rate limiting works
    - Test email failure doesn't block user requests
    - _Requirements: 6.1, 6.5, 8.4_
  
  - [ ] 12.3 Ensure all tests pass
    - Run all unit tests
    - Run all property-based tests
    - Verify test coverage meets goals (80% for services, 100% for validation)
    - Fix any failing tests
  
  - [ ] 12.4 Final checkpoint
    - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP delivery
- Each task references specific requirements for traceability
- Property tests validate universal correctness properties across all inputs
- Unit tests validate specific examples, edge cases, and error conditions
- Checkpoints ensure incremental validation at key milestones
- All email notifications are queued for asynchronous processing
- Rate limiting protects sensitive endpoints from abuse
- Authorization checks ensure users can only access their own data
