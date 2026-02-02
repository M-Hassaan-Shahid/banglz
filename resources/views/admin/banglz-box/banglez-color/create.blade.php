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
            <h2>{{ isset($bangleBoxColor) ? 'Edit Bangle Color' : 'Add New Bangle Color' }}</h2>
            <a href="{{ route('admin.bangle-box-colors') }}" class="btn text-white" style="background-color: #6cc2b6; border-color: #6cc2b6;">← Back</a>
        </div>

        <form id="bangleBoxColorForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $bangleBoxColor->id ?? '' }}">

            <!-- Color Name -->
            <div class="mb-3">
                <label for="color_name" class="form-label">Color Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="color_name"
                    name="color_name"
                    value="{{ old('color_name', $bangleBoxColor->color_name ?? '') }}"
                    required>
            </div>

            <!-- Size Dropdown -->
            <div class="mb-3">
                <label for="size_id" class="form-label">Select Size</label>
                <select class="form-select" id="size_id" name="size_id" required>
                    <option value="">-- Select Size --</option>
                    @foreach($sizes as $size)
                        <option
                            value="{{ $size->id }}"
                            {{ isset($bangleBoxColor) && $bangleBoxColor->bangle_box_size_id == $size->id ? 'selected' : '' }}>
                            {{ $size->size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <div
                    class="border border-2 rounded p-3 text-center"
                    id="image-upload-box"
                    style="background-color:#f9f9f9; cursor:pointer;">
                    <input type="file" id="color_image" name="color_image" accept="image/*" hidden>

                    <div id="image-preview">
                        @if(isset($bangleBoxColor) && $bangleBoxColor->image)
                            <img src="{{$bangleBoxColor->image}}"
                                alt="Uploaded Image"
                                class="img-fluid rounded"
                                style="max-height: 150px;">
                        @else
                            <i class="bi bi-cloud-upload fs-1 text-secondary"></i>
                            <p class="mt-2 text-muted">Click or drag image here to upload</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" id="submitBtn" class="btn" style="background-color:#6cc2b6;color:white;">
                {{ isset($bangleBoxColor) ? 'Update Bangle Color' : 'Save Bangle Color' }}
            </button>
        </form>
    </div>
</main>
@endsection

@section('admininsertjavascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // === Image Preview ===
    const uploadBox = document.getElementById('image-upload-box');
    const fileInput = document.getElementById('color_image');
    const preview = document.getElementById('image-preview');

    uploadBox.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = event => {
                preview.innerHTML = `<img src="${event.target.result}" class="img-fluid rounded" style="max-height: 150px;">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // === AJAX Form Submission ===
    $(document).ready(function() {
        $('#bangleBoxColorForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this); // Important: include file input

            $('#submitBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.bangle-color.store') }}", 
                method: "POST",
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                success: function(response) {
                    $('#submitBtn').prop('disabled', false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Bangle Color saved successfully!',
                    }).then(() => {
                        window.location.href = response.redirect_route;
                    });
                },
                error: function(xhr) {
                    $('#submitBtn').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Something went wrong, please try again.',
                    });
                }
            });
        });
    });
</script>
@endsection
