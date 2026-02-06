<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Collection;

class AddressService
{
    /**
     * Create a new address for the user.
     *
     * @param User $user
     * @param array $data
     * @return Address
     */
    public function createAddress(User $user, array $data): Address
    {
        return $user->addresses()->create($data);
    }

    /**
     * Update an existing address.
     *
     * @param Address $address
     * @param array $data
     * @return Address
     */
    public function updateAddress(Address $address, array $data): Address
    {
        $address->update($data);
        return $address->fresh();
    }

    /**
     * Delete an address.
     *
     * @param Address $address
     * @return bool
     */
    public function deleteAddress(Address $address): bool
    {
        return $address->delete();
    }

    /**
     * Get all addresses for a user.
     *
     * @param User $user
     * @return Collection
     */
    public function getUserAddresses(User $user): Collection
    {
        return $user->addresses()->get();
    }

    /**
     * Check if user has reached the address limit (3 addresses).
     *
     * @param User $user
     * @return bool
     */
    public function hasReachedAddressLimit(User $user): bool
    {
        return $user->addresses()->count() >= 3;
    }

    /**
     * Validate if user owns the address.
     *
     * @param User $user
     * @param Address $address
     * @return bool
     */
    public function userOwnsAddress(User $user, Address $address): bool
    {
        return $address->user_id === $user->id;
    }
}
