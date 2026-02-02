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
            <h2>{{ isset($product) ? 'Edit Attribute' : 'Add New Attribute' }}</h2>
            <a href="{{ route('admin.attributes') }}" class="btn text-white" style="background-color: #6cc2b6; border-color: #6cc2b6;">← Back</a>
        </div>

        <form id="AttributeForm" >
@csrf
   <input type="hidden" name="id" value="{{ $attribute->id ?? '' }}">

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Attribute Name</label>
        <input type="text" class="form-control" id="name" name="name"
               value="{{ old('name', $attribute->name ?? '') }}" required>
    </div>
    <!-- Type -->
    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Select Type</option>
            <option value="style" {{ old('type', $attribute->type ?? '') == 'style' ? 'selected' : '' }}>Style</option>
            <option value="material" {{ old('type', $attribute->type ?? '') == 'material' ? 'selected' : '' }}>Material</option>
        </select>
    </div>

    <!-- Top Listed -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="top_listed" name="top_listed"
               value="1" {{ old('top_listed', $attribute->top_listed ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="top_listed">Show in Top List</label>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
            <option value="1" {{ old('status', $attribute->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $attribute->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $attribute->description ?? '') }}</textarea>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn" style="background-color:#6cc2b6;color:white;">
        {{ isset($attribute) ? 'Update Attribute' : 'Save Attribute' }}
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
    $('#AttributeForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: "{{ route('admin.attributes.store') }}", // single route
            method: "POST",
            data: formData,
             success: function(response) {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Attributes added successfully!',
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