<x-layouts.user-default>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Shipping Addresses</h2>

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

                @if($addresses->isEmpty())
                    <div class="not-data-card text-center py-5">
                        <div class="no-data-body mb-4">
                            <img src="{{ asset('assets/images/address.png') }}" alt="No addresses" style="max-width: 200px;" />
                        </div>
                        <div class="no-data-footer mb-4">
                            <p class="text-muted">You currently don't have any saved addresses</p>
                        </div>
                        <div class="no-data-action-sec">
                            <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Your First Address</a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach($addresses as $address)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $address->recipient_name }}</h5>
                                        <p class="card-text">
                                            {{ $address->street_address }}<br>
                                            {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                                            {{ $address->country }}
                                        </p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('addresses.edit', $address) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($addresses->count() < 3)
                        <div class="text-center mt-4">
                            <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Another Address</a>
                        </div>
                    @else
                        <div class="alert alert-info text-center mt-4">
                            You have reached the maximum of 3 saved addresses.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layouts.user-default>
