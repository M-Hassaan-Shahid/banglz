@extends('components.layouts.admin-default')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
    #page-setting-table tbody tr td:nth-child(3){
        max-width: 100px;
    }
    #page-setting-table tbody tr td:nth-child(4){
        max-width: 100px;
    }
</style>

@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">

    <div class="container-fluid py-3">
        <div class="heading-top d-flex justify-content-between align-items-center">
            <h1 class="mb-0">All Pages Setting</h1>
            <a href="{{ route('admin.page-settings.create') }}" class="btn text-white " style="background-color: #6cc2b6; border-color: #6cc2b6;">+ Add New Setting</a>
        </div>
    </div>
    <div class="client-table pt-2">
        <div class="row g-2 align-items-center mb-3">
            <div class="col-1">
                <label for="searchInput" class="col-form-label">Search:</label>
            </div>
            <div class="col-11">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search Categories...">
            </div>
        </div>
        <table id="page-setting-table" style="width: 100%">
            <thead>
                <tr>
                    <th class="table-heading">Image</th>
                    <th class="table-heading">Heading</th>
                    {{-- <th class="table-heading">Sub Heading</th> --}}
                    <th class="table-heading">Description</th>
                    <th class="table-heading">Page Name</th>
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
    var table = $('#page-setting-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('admin.get-page-setting-list') }}",
        type: 'GET',
        data: function(d) {
            d.search_custom = $('#searchInput').val(); // custom search
            if (d.order && d.order.length > 0) {
                let columnIndex = d.order[0].column;
                d.sort_by = d.columns[columnIndex].data;
                d.sort_dir = d.order[0].dir;
            } else {
                d.sort_by = 'id';
                d.sort_dir = 'desc';
            }
        }
    },
    columns: [
        { data: 'image', name: 'image', orderable: false },
        { data: 'heading', name: 'heading', orderable: true },
        // { data: 'sub_heading', name: 'sub_heading', orderable: true },
        { data: 'description', name: 'description', orderable: false },
        { data: 'page_name', name: 'page_name', orderable: true },
        { data: 'action', name: 'action', orderable: false }
    ],
    dom: 't<"row justify-content-end"<"col-sm-12 col-md-5"p>>',
    pageLength: 10,
    lengthChange: false,
    searching: false, // disable built-in search
    ordering: true,
    order: [],
    info: false,
    autoWidth: false,
    responsive: true,
    language: {
        processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
        emptyTable: "No Page found",
        zeroRecords: "No Page found"
    }
});

// 🔍 trigger reload when typing in custom search
var searchTimer;
$('#searchInput').on('keyup', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() {
        table.ajax.reload();
    }, 500);
});


    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This Page Setting will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Use route URL
                const url = "{{ route('admin.page-settings.delete', ':id') }}".replace(':id', id);

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
                                'Category has been deleted.',
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
    $('.sidenav  li:nth-of-type(9)').addClass('active');
</script>
@endsection
