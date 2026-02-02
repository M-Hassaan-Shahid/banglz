@extends('components.layouts.admin-default')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($bangleBoxSize) ? 'Edit Bangle Size' : 'Add New Bangle Size' }}</h2>
            <a href="{{ route('admin.banglez-size') }}" class="btn text-white" style="background-color: #6cc2b6; border-color: #6cc2b6;">← Back</a>
        </div>

        <form id="bangleBoxSizeForm" >
@csrf
   <input type="hidden" name="id" value="{{ $bangleBoxSize->id ?? '' }}">

    <!-- Name -->
   <div class="mb-3">
    <label for="size" class="form-label">Size</label>
    <input type="number" step="0.01" class="form-control" id="size" name="size"
           value="{{ old('size', $bangleBoxSize->size ?? '') }}" required>
</div>


    <!-- Submit -->
    <button type="submit" class="btn" style="background-color:#6cc2b6;color:white;">
        {{ isset($bangleBoxSize) ? 'Update Bangle Size' : 'Save Bangle Size' }}
    </button>
</form>

    </div>
</main>
@endsection

@section('admininsertjavascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    $('#bangleBoxSizeForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: "{{ route('admin.bangle-size.store') }}", // single route
            method: "POST",
            data: formData,
             success: function(response) {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Bangle Size added successfully!',
                }).then(() => {
                    window.location.href = response.redirect_route || productsIndexRoute;
                });
            },
            error: function(xhr) {
                Swal.close();
                let title = 'System Error!';
                let message = 'Something went wrong! Please try again.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.details) {
                    title = 'Validation Error!';
                    message = JSON.stringify(xhr.responseJSON.details, null, 2);
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: title, text: message, confirmButtonColor: '#d33' });
                submitButton.prop('disabled', false);
            }
        });
    });
});
</script>

@endsection