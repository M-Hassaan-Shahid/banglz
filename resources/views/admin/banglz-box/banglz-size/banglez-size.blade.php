@extends('components.layouts.admin-default')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">

    <div class="container-fluid py-3">
        <div class="heading-top d-flex justify-content-between align-items-center">
            <h1 class="mb-0">All Bangle Size</h1>
            <a href="{{ route('admin.bangle-size.create') }}" class="btn text-white " style="background-color: #6cc2b6; border-color: #6cc2b6;">+ Add Bangle Size</a>
        </div>
    </div>
    <div class="client-table pt-2">
        <div class="row g-2 align-items-center mb-3">
            <div class="col-1">
                <label for="searchInput" class="col-form-label">Search:</label>
            </div>
            <div class="col-11">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search Bangle Size...">
            </div>
        </div>
        <table id="bangle-size-table" style="width: 100%">
            <thead>
                <tr>
                    <th class="table-heading">Size</th>
                    <th class="table-heading">Action</th>
                </tr>
            </thead>
            <tbody>

                <tr>

                    <!-- <td><a href="#"><button type="button" class="btn btn-primary">View</button></a></td> -->
                </tr>

            </tbody>
        </table>
    </div>
    </div>

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</main>




@endsection
@section('admininsertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var table = $('#bangle-size-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.get-bangle-size-list') }}", // using same route
                type: 'GET',
                data: function(d) {
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
            columns: [{
                    data: 'size',
                    name: 'size',
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
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
                emptyTable: "No Bangle Size found",
                zeroRecords: "No Bangle Size found"
            }
        });
        var searchTimer;
        $('#searchInput').on('keyup', function() {

            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                table.ajax.reload();
            }, 500);
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This bangle size will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Use route URL
                const url = "{{ route('admin.bangle-size.delete', ':id') }}".replace(':id', id);

                // Optional: Use AJAX for deletion
                fetch(url, {
                        method: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire(
                                'Deleted!',
                                'Bangle Size has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); // Refresh page
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    });
            }
        });
    }
</script>



<script>
    $('.sidenav  li:nth-of-type(12)').addClass('active');
</script>
@endsection