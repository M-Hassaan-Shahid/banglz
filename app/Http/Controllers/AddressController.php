<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddressController extends Controller
{
    private AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->middleware('auth');
        $this->addressService = $addressService;
    }

    /**
     * Display all addresses for the authenticated user.
     */
    public function index(): View
    {
        $addresses = $this->addressService->getUserAddresses(auth()->user());
        
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create(): View
    {
        // Check if user has reached address limit
        if ($this->addressService->hasReachedAddressLimit(auth()->user())) {
            return redirect()->route('addresses.index')
                ->with('error', 'You have reached the maximum of 3 saved addresses.');
        }

        return view('addresses.create');
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(StoreAddressRequest $request): RedirectResponse
    {
        try {
            $this->addressService->createAddress(auth()->user(), $request->validated());
            
            return redirect()->route('addresses.index')
                ->with('success', 'Address added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add address. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(Address $address): View|RedirectResponse
    {
        // Check if user owns the address
        if (!$this->addressService->userOwnsAddress(auth()->user(), $address)) {
            return redirect()->route('addresses.index')
                ->with('error', 'You are not authorized to edit this address.');
        }

        return view('addresses.edit', compact('address'));
    }

    /**
     * Update the specified address in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address): RedirectResponse
    {
        try {
            $this->addressService->updateAddress($address, $request->validated());
            
            return redirect()->route('addresses.index')
                ->with('success', 'Address updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update address. Please try again.');
        }
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address): RedirectResponse
    {
        // Check if user owns the address
        if (!$this->addressService->userOwnsAddress(auth()->user(), $address)) {
            return redirect()->route('addresses.index')
                ->with('error', 'You are not authorized to delete this address.');
        }

        try {
            $this->addressService->deleteAddress($address);
            
            return redirect()->route('addresses.index')
                ->with('success', 'Address deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete address. Please try again.');
        }
    }
}
