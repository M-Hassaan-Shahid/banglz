@extends('components.layouts.admin-default')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">User Details</h3>
            <a href="{{ route('admin.customers.list') }}" class="btn btn-secondary btn-sm">← Back to Users</a>
        </div>

        <!-- User Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="mb-1">{{ $customer->name }} {{ $customer->last_name }}</h4>
                <p class="mb-0 text-muted">{{ $customer->email }}</p>
                <span class="badge {{ $customer->is_guest ? 'bg-warning' : 'bg-success' }}">
                    {{ $customer->is_guest ? 'Guest' : 'Registered' }} User
                </span>

            </div>
        </div>

        <!-- User Information + Orders -->
        <div class="row align-items-stretch">
            <!-- Left Column -->
            <div class="col-lg-4 d-flex">
                <div class="card shadow-sm mb-4 w-100 h-100">
                    <div class="card-header bg-light fw-bold">Account Information</div>
                    <div class="card-body">
                        <p><strong>Customer ID:</strong> {{$customer->customer_id}}</p>
                        <p><strong>Email:</strong> {{$customer->email}}</p>
                        <p><strong>First Name: </strong> {{$customer->name}}</p>
                        <p><strong>Last Name: </strong> {{$customer->last_name}}</p>
                        <p><strong>Joined: </strong>{{ $customer->created_at->format('M d, Y') }}</p>
              @if(!$customer->is_guest)
<p class="d-flex align-items-center">
    <strong>Total Points: </strong>
    <span id="pointsDisplay" class="ms-2">{{ $customer->total_points }}</span>

    <input type="number" id="pointsInput" value="{{ $customer->total_points }}" 
           class="form-control form-control-sm d-none ms-2" 
           style="width:100px;" min="0" />

   <i class="bi bi-pencil-square text-primary ms-2 fs-4" id="editPoints" style="cursor:pointer;"></i>
<i class="bi bi-floppy text-success ms-2 fs-4 d-none" id="savePoints" style="cursor:pointer;"></i>

</p>
@endif

                        <p><strong>Total Orders: </strong>{{ $customer->orders_count }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-8 d-flex">
                <div class="card shadow-sm mb-4 w-100 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light fw-bold">
                        <span>
                            Orders
                        </span>
                        @if($customer->orders->count() > 5)
                        <a href="{{ route('admin.customer.orders', $customer->id) }}" class="btn btn-sm btn-primary">View All Orders</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($customer->orders->count() > 0)
                                @foreach($customer->orders->sortByDesc('created_at')->take(5) as $order)
                                <tr>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                        $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-dark',
                                        'on_the_way' => 'bg-primary',
                                        'delivered' => 'bg-success',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'returned' => 'bg-dark',
                                        'failed' => 'bg-secondary',
                                        ];

                                        $statusLabel = [
                                        'pending' => 'Pending',
                                        'processing' => 'Processing',
                                        'on_the_way' => 'On the Way',
                                        'delivered' => 'Delivered',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                        'returned' => 'Returned',
                                        'failed' => 'Failed',
                                        ];

                                        $class = $statusClasses[$order->status] ?? 'bg-secondary';
                                        $label = $statusLabel[$order->status] ?? ucfirst($order->status);
                                        @endphp

                                        <span class="badge {{ $class }}">{{ $label }}</span>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.orders.show', ['id' => $order->id]) }}" class="btn btn-primary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted fw-bold py-4">
                                        No orders found.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>
@endsection

@section('admininsertjavascript')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('body').addClass('bg-clr');
    $('.sidenav li:nth-of-type(10)').addClass('active');
</script>
<script>
    $(document).on('click', '#editPoints', function() {
    $('#pointsDisplay').addClass('d-none');
    $('#pointsInput').removeClass('d-none');
    $('#editPoints').addClass('d-none');
    $('#savePoints').removeClass('d-none');
});

$(document).on('click', '#editPoints', function() {
    $('#pointsDisplay').addClass('d-none');
    $('#pointsInput').removeClass('d-none').focus();
    $('#editPoints').addClass('d-none');
    $('#savePoints').removeClass('d-none');
});

$(document).on('click', '#savePoints', function() {
      let newPoints = $('#pointsInput').val();
let customerId = {{ $customer->id ?? 0 }};
    Swal.fire({
        title: 'Update Points?',
        text: "Are you sure you want to update the points?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('admin.customer.updatePoints') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    customer_id: customerId,
                    total_points: newPoints
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                },
                success: function(response) {
                    Swal.close();
                    if(response.success){
                        $('#pointsDisplay').text(newPoints).removeClass('d-none');
                        $('#pointsInput').addClass('d-none');
                        $('#editPoints').removeClass('d-none');
                        $('#savePoints').addClass('d-none');

                        Swal.fire('Updated!', 'Points updated successfully.', 'success');
                    } else {
                        Swal.fire('Error!', response.message || 'Something went wrong.', 'error');
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error!', 'Server error occurred.', 'error');
                }
            });
        }
    });
});


</script>
@endsection