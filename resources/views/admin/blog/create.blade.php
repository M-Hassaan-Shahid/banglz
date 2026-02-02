@extends('components.layouts.admin-default')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

<!-- Small styles for image preview & remove button -->
<style>
    /* preview container */
    .image-preview-wrapper {
        max-width: 150px;
        position: relative;
        display: inline-block;
        margin-top: 8px;
        border-radius: 6px;
    }

    .image-preview-wrapper img {
        display: block;
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* small red cross */
    .image-remove-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    .image-remove-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(108,194,182,0.2);
    }

    /* subtle styling for inputs to not break current logic but look nicer */
    .form-control, .form-select, textarea {
        border-radius: 6px;
    }

    /* keep submit button style consistent */
    #submitButton {
        border-radius: 6px;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>

@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($blog) ? 'Edit Blog' : 'Add New Blog' }}</h2>
            <a href="{{ route('admin.blog.index') }}" class="btn text-white" style="background-color: #6cc2b6; border-color: #6cc2b6;">← Back</a>
        </div>

        <form id="BlogForm" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $blog->id ?? '' }}">

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $blog->title ?? '') }}" required>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category"  name="category" >
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category', $blog->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Author -->
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author"
                    value="{{ old('author', $blog->author ?? '') }}" required>
            </div>

            <!-- Short Description -->
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea class="form-control" id="short_description" name="short_description" rows="3">{{ old('short_description', $blog->short_description ?? '') }}</textarea>
            </div>

            <!-- Content (CKEditor) -->
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea id="content" name="content">{{ old('content', $blog->content ?? '') }}</textarea>
                <small class="form-text text-muted">You can upload images from the editor (will POST to the configured upload route).</small>
            </div>

            <!-- Image upload with preview -->
            <div class="mb-3">
                <label class="form-label">Main Image</label>

                <div class="mb-2">
                    <input type="file" id="imageInput" name="image" accept="image/*" class="form-control">
                </div>

                <div id="imagePreviewWrapper"
                     class="image-preview-wrapper"
                     style="display: {{ isset($blog) && $blog->image ? 'inline-block' : 'none' }};">
                    <img id="imagePreview"
                         src="{{ isset($blog) && $blog->image 
            ? asset('assets/images/blogs/' . $blog->image) 
            : asset('assets/images/default.png') }}"
                         alt="Image Preview">

                    <!-- Small red cross button (top-right) -->
                    <button type="button"
                            id="removeImageBtn"
                            class="btn btn-danger image-remove-btn"
                            title="Remove image"
                            aria-label="Remove image">
                        ✕
                    </button>
                </div>

                <small class="form-text text-muted">
                    Choose a featured image. On edit it shows the current image; selecting a new file replaces the preview.
                </small>
            </div>

            <!-- Submit -->
            <button type="submit" id="submitButton" class="btn" style="background-color:#6cc2b6;color:white;">
                {{ isset($blog) ? 'Update Blog' : 'Save Blog' }}
            </button>
        </form>

    </div>
</main>
@endsection

@section('admininsertjavascript')
<!-- dependencies -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- CKEditor 5 Classic build (CDN) -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

<script>
let ckeditorInstance = null;

$(document).ready(function() {
 

    /* -------------------------
       CKEditor custom upload adapter
       ------------------------- */
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
            this.url = "{{ route('admin.blog.upload') }}"; // upload route
            this.controller = null;
        }

        // Starts the upload process.
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);

                    this.controller = new AbortController();
                    const signal = this.controller.signal;

                    fetch(this.url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            // DO NOT set Content-Type
                        },
                        body: data,
                        signal: signal
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                let msg = text || 'Upload failed';
                                throw new Error(msg);
                            });
                        }
                        return response.json();
                    })
                    .then(json => {
                        // Expecting { url: "https://.../assets/images/blogs/filename.jpg" }
                        if (json && (json.url || json.default)) {
                            resolve({ default: json.url ?? json.default });
                        } else {
                            reject(json && json.error ? (json.error.message || 'Upload error') : 'Upload failed');
                        }
                    })
                    .catch(err => {
                        if (err.name === 'AbortError') {
                            reject('Upload aborted');
                        } else {
                            reject(err.message || 'Upload failed');
                        }
                    });
                }));
        }

        // Aborts the upload process.
        abort() {
            if (this.controller) {
                this.controller.abort();
            }
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    // Initialize CKEditor with custom adapter plugin
    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            // you can customize toolbar here if needed
        })
        .then(editor => {
            ckeditorInstance = editor;
        })
        .catch(error => {
            console.error('CKEditor init error:', error);
        });

    /* -------------------------
       Image preview logic (single, consistent place)
       ------------------------- */
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewWrapper = document.getElementById('imagePreviewWrapper');
    const removeImageBtn = document.getElementById('removeImageBtn');

    function showPreview(src) {
        if (imagePreview) {
            imagePreview.src = src || '';
            imagePreview.style.display = src ? 'block' : 'none';
        }
        if (imagePreviewWrapper) {
            imagePreviewWrapper.style.display = src ? 'inline-block' : 'none';
        }
        // If we show a preview (either existing image or newly selected), make sure remove button is visible
        if (removeImageBtn) {
            removeImageBtn.style.display = src ? 'flex' : 'none';
        }
    }

    // If blade provided an existing image, it's already set via src attribute and wrapper display style
    // Ensure remove button visibility matches
    if (imagePreview && imagePreview.src && imagePreview.src.trim() !== '') {
        if (removeImageBtn) removeImageBtn.style.display = 'flex';
    } else {
        if (removeImageBtn) removeImageBtn.style.display = 'none';
    }

    // When user selects new file
    if (imageInput) {
        imageInput.addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    showPreview(evt.target.result);
                    // If user selects a new image, clear any remove_image hidden flag (server should treat accordingly)
                    const removeField = document.querySelector('input[name="remove_image"]');
                    if (removeField) {
                        removeField.value = '0';
                    }
                };
                reader.readAsDataURL(file);
            } else {
                // No file selected -> hide preview (but do not automatically add remove flag)
                showPreview('');
            }
        });
    }

    // Remove image button behavior (works for both edit existing and just-selected)
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function () {
            // Clear file input
            if (imageInput) {
                imageInput.value = '';
            }

            // Hide preview UI
            showPreview('');

            // Add a hidden field to tell server to remove image when editing (optional)
            let removeField = document.querySelector('input[name="remove_image"]');
            if (!removeField) {
                removeField = document.createElement('input');
                removeField.type = 'hidden';
                removeField.name = 'remove_image';
                removeField.value = '1';
                document.getElementById('BlogForm').appendChild(removeField);
            } else {
                removeField.value = '1';
            }
        });
    }

    /* -------------------------
       Form submit via AJAX
       ------------------------- */
    $('#BlogForm').on('submit', function(e) {
        e.preventDefault();

        const submitButton = $('#submitButton');
        submitButton.prop('disabled', true);

        const formData = new FormData();

        // Append CSRF token
        formData.append('_token', $('input[name="_token"]').val());

        // Append basic fields
        formData.append('id', $('input[name="id"]').val() || '');
        formData.append('title', $('#title').val() || '');
        formData.append('category_id', $('#category').val() || '');
        formData.append('author', $('#author').val() || '');
        formData.append('short_description', $('#short_description').val() || '');

        // CKEditor content
        if (ckeditorInstance) {
            formData.append('content', ckeditorInstance.getData());
        } else {
            formData.append('content', $('#content').val() || '');
        }

        // Image file (if selected)
        const fileInput = document.getElementById('imageInput');
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        } else {
            const removeField = $('input[name="remove_image"]').val();
            if (removeField) {
                formData.append('remove_image', '1');
            }
        }

        // AJAX request
        $.ajax({
            url: "{{ route('admin.blog.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || ( '{{ isset($blog) ? "Blog updated successfully!" : "Blog added successfully!" }}' ),
                }).then(() => {
                    window.location.href = response.redirect_route || '{{ route("admin.blog.index") }}';
                });
            },
            error: function(xhr) {
                Swal.close();
                let title = 'System Error!';
                let message = 'Something went wrong! Please try again.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    title = 'Validation Error!';
                    const errors = xhr.responseJSON.errors;
                    const messages = [];
                    Object.keys(errors).forEach(function (k) {
                        messages.push(errors[k].join(' '));
                    });
                    message = messages.join(' ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    message = xhr.responseText.substring(0, 500);
                }

                Swal.fire({
                    icon: 'error',
                    title: title,
                    text: message,
                    confirmButtonColor: '#d33'
                });
                submitButton.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection
