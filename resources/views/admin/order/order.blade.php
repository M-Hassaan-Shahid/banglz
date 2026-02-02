@extends('components.layouts.admin-default')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">

    <div class="container-fluid py-3">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- <a href="{{ route('admin.customers.list') }}" class="btn btn-secondary btn-sm">← Back to Users</a> -->
        </div>

        <!-- Orders Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-light fw-bold">
                All Orders
            </div>
            <div class="card-body">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col-1">
                        <label for="searchInput" class="col-form-label">Search:</label>
                    </div>
                    <div class="col-11">
                        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search Orders...">
                    </div>
                </div>

                <table id="ordersTable" class="table table-striped table-bordered table-sm w-100">
                    <thead>
                        <tr>
                            <th class="table-heading">Order ID</th>
                            <th class="table-heading">Customer</th>
                            <th class="table-heading">Date</th>
                            <th class="table-heading">Total</th>
                            <th class="table-heading">Status</th>
                            <th class="table-heading">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- No static rows, DataTables will fill this -->
                    </tbody>
                </table>
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
    $('.sidenav li:nth-of-type(11)').addClass('active');

    $(document).ready(function() {
        var table = $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.get-orders-list') }}", 
                type: 'GET',
                data: function (d) {
                    d.search = $('#searchInput').val();
                    if (d.order && d.order.length > 0) {
                        d.sort_by = d.columns[d.order[0].column].name;
                        d.sort_dir = d.order[0].dir;
                    } else {
                        d.sort_by = 'id';
                        d.sort_dir = 'desc';
                    }
                }
            },
            columns: [
                { data: 'order_id', name: 'order_id', orderable: true },
                { data: 'customer_name', name: 'customer_name', orderable: false },
                { data: 'created_at', name: 'created_at', orderable: true },
                { data: 'total_amount', name: 'total_amount', orderable: true },
                { data: 'status', name: 'status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            dom: 't<"row justify-content-end"<"col-sm-12 col-md-5"p>>',
            pageLength: 10,
            lengthChange: false,
            searching: true,
            ordering: true,
            order: [],
            info: false,
            autoWidth: false,
            responsive: true,
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                emptyTable: "No orders found",
                zeroRecords: "No matching orders"
            }
        });

        // Custom search input
        var searchTimer;
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                table.ajax.reload();
            }, 500);
        });
    });
</script>
@endsection
