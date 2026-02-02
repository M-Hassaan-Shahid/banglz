@extends('components.layouts.admin-default')

@section('content')
@include('components.includes.admin.navbar')

<style>
    .collection-image-thumb {
        width: 90px;
        height: 90px;
        object-fit: cover;
        margin: 6px;
        border-radius: 6px;
        border: 2px solid transparent;
        position: relative;
    }

    .collection-image-thumb.active {
        border-color: #6cc2b6;
    }

    .collection-image-main {
        width: 100%;
        max-height: 360px;
        object-fit: contain;
        border-radius: 6px;
        background: #fff;
    }

    /* container now uses flex so existing + new previews stay inline */
    #image-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: flex-start;
    }

    .existing-image,
    .new-image-preview {
        position: relative;
    }

    .remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        z-index: 2;
    }

    #drop-area.dragging {
        background: #f8f9fa;
        border-color: #6cc2b6;
    }
</style>

<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($collection) ? 'Edit Category' : 'Add New Category' }}</h2>
            <a href="{{ route('admin.catelogs') }}" class="btn text-white" style="background-color: #6cc2b6;">← Back</a>
        </div>

        <form id="categoryForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $category->id ?? '' }}">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Select Parent Category</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- No Parent (Top Level) --</option>
                        @foreach($allCategories as $parentCategory)
                        @if(!isset($category) || $category->id !== $parentCategory->id)
                        <option value="{{ $parentCategory->id }}"
                            {{ old('parent_id', $category->parent_id ?? '') == $parentCategory->id ? 'selected' : '' }}>
                            {{ $parentCategory->name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1" {{ (string) old('status', isset($category) ? (string)$category->status : '1') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ (string) old('status', isset($category) ? (string)$category->status : '1') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" id="is_feature" name="is_featured" value="1" class="form-check-input"
                            {{ old('is_featured', isset($category) ? $category->is_featured : false) ? 'checked' : '' }}>
                        <label for="is_feature" class="form-check-label">Is Feature</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" id="top_listed" name="top_listed" value="1" class="form-check-input"
                            {{ old('top_listed', isset($category) ? $category->top_listed : false) ? 'checked' : '' }}>
                        <label for="top_listed" class="form-check-label">Top Listed</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" id="allow_size" name="allow_size" value="1" class="form-check-input"
                            {{ old('allow_size', isset($category) ? $category->allow_size : false) ? 'checked' : '' }}>
                        <label for="allow_size" class="form-check-label">Allow Size</label>
                    </div>
                </div>
            </div>
            <div>

            </div>
<!-- Extra Boxes Section -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="form-check mb-2">
    <input type="hidden" name="enable_boxes" value="0">
<input type="checkbox" name="enable_boxes" id="enableBoxes" value="1"
    class="form-check-input"
    @if(isset($category) && $category->boxes->count()) checked @endif>
<label for="enableBoxes" class="form-check-label">Enable Boxes</label>

        </div>

        <div id="boxesWrapper" class="{{ isset($category) && $category->boxes->count() ? '' : 'd-none' }}">
            <label class="form-label">Boxes</label>
            <div id="boxesContainer">
                {{-- Existing boxes (edit case) --}}
                @if(isset($category) && $category->boxes->count())
                    @foreach($category->boxes as $box)
                        <div class="input-group mb-2 box-item existing-box" data-id="{{ $box->id }}">
                            <input type="hidden" name="existing_boxes[{{ $box->id }}]" value="{{ $box->id }}">
                            <input type="text" name="existing_boxes_values[{{ $box->id }}]" 
                                   value="{{ $box->name }}" 
                                   class="form-control" placeholder="Enter box name">
                            <button type="button" class="btn btn-danger remove-box">✖</button>
                        </div>
                    @endforeach
                @endif

                {{-- At least one input for create case --}}
                @if(!isset($category) || !$category->boxes->count())
                    <div class="input-group mb-2 box-item">
                        <input type="text" name="boxes[]" class="form-control" placeholder="Enter box name">
                        <button type="button" class="btn btn-danger remove-box">✖</button>
                    </div>
                @endif
            </div>

            <button type="button" id="addBoxBtn" style="background-color:#6cc2b6;color:white;" class="btn">
                Add More
            </button>
        </div>
    </div>
</div>


            <!-- Images -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Images</label>

                    <div id="drop-area" class="border p-4 text-center rounded" style="cursor:pointer;">
                        <p>Drag & drop images here or click to select</p>
                        <small>Max file size: 4MB. Multiple allowed.</small>
                    </div>

                    <input type="file" id="images" name="images[]" accept="image/*" multiple class="d-none">

                    <!-- SINGLE container for both existing images and new previews -->
                    <div id="image-container" class="mt-3">
                        @if(isset($category) && !empty($category->images))
                        @foreach($category->images as $img)
                        <div class="existing-image" data-filename="{{ $img }}">
                            <img src="{{ asset('assets/images/categories/' . $img) }}" class="collection-image-thumb">
                            <button type="button" class="btn btn-sm btn-danger remove-existing remove-btn" title="Remove"><i class="fa fa-times"></i></button>
                            <input type="hidden" name="existing_images[]" value="{{ $img }}">
                        </div>
                        @endforeach
                        @endif
                        <!-- new previews will be appended here by JS -->
                    </div>

                </div>
            </div>

            <button type="submit" id="saveBtn" class="btn" style="background-color:#6cc2b6;color:white;">
                Save Category
            </button>
        </form>
    </div>
</main>
@endsection

@section('admininsertjavascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('images');
        const imageContainer = document.getElementById('image-container'); // single container
        const form = document.getElementById('categoryForm');
        let droppedFiles = []; // File objects user selected this session
        let removedExisting = []; // filenames removed from existing

        // click to open file dialog
        dropArea.addEventListener('click', () => fileInput.click());

        // handle file input
        fileInput.addEventListener('change', e => {
            const files = Array.from(e.target.files || []).filter(f => f.type && f.type.startsWith('image/'));
            files.forEach(f => {
                if (!droppedFiles.some(x => x.name === f.name && x.size === f.size)) {
                    droppedFiles.push(f);
                    addPreview(f);
                }
            });
            fileInput.value = '';
        });

        // drag events
        ['dragenter', 'dragover'].forEach(ev => dropArea.addEventListener(ev, e => {
            e.preventDefault();
            dropArea.classList.add('dragging');
        }));
        ['dragleave', 'drop'].forEach(ev => dropArea.addEventListener(ev, e => {
            e.preventDefault();
            dropArea.classList.remove('dragging');
        }));
        dropArea.addEventListener('drop', e => {
            const files = Array.from(e.dataTransfer.files || []).filter(f => f.type && f.type.startsWith('image/'));
            files.forEach(f => {
                if (!droppedFiles.some(x => x.name === f.name && x.size === f.size)) {
                    droppedFiles.push(f);
                    addPreview(f);
                }
            });
        });

        function addPreview(file) {
            const reader = new FileReader();
            reader.onload = ev => {
                const wrapper = document.createElement('div');
                wrapper.className = 'new-image-preview';
                // size/content managed by CSS .collection-image-thumb
                wrapper.style.position = 'relative';

                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'collection-image-thumb';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.innerHTML = '<i class="fa fa-times"></i>';
                btn.className = 'btn btn-sm btn-danger remove-new-image remove-btn';
                btn.addEventListener('click', () => {
                    const idx = droppedFiles.indexOf(file);
                    if (idx !== -1) droppedFiles.splice(idx, 1);
                    wrapper.remove();
                });

                wrapper.appendChild(img);
                wrapper.appendChild(btn);

                // append to the same container as existing images so it sits next to them
                imageContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        }

        // remove existing image buttons (listen on container)
        imageContainer && imageContainer.addEventListener('click', function(e) {
            const btnExisting = e.target.closest('.remove-existing');
            if (btnExisting) {
                const wrapper = btnExisting.closest('.existing-image');
                if (!wrapper) return;
                const filename = wrapper.getAttribute('data-filename');
                if (filename) removedExisting.push(filename);
                wrapper.remove();
                return;
            }

            // also handle remove-new-image clicks (in case they bubble)
            const btnNew = e.target.closest('.remove-new-image');
            if (btnNew) {
                const wrapper = btnNew.closest('.new-image-preview');
                if (!wrapper) return;
                // find corresponding file in droppedFiles by comparing data URL? we already remove via button listener,
                // but handle here for redundancy:
                wrapper.remove();
            }
        });

        // submit form via AJAX
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $('#saveBtn');
            $btn.prop('disabled', true);

            const formData = new FormData(this);

            // append droppedFiles as images[]
            droppedFiles.forEach(f => formData.append('images[]', f));

            // append removed existing as JSON
            formData.append('removed_existing_images', JSON.stringify(removedExisting));

            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "{{ route('admin.category.store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();
                    if (res.status) {
                        Swal.fire('Success', res.message || 'Saved', 'success').then(() => {
                            window.location.href = (res.redirect_route || "{{ route('admin.category') }}");
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Failed', 'error');
                        $btn.prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = 'Something went wrong';
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', msg, 'error');
                    $btn.prop('disabled', false);
                }
            });
        });
    });
</script>
<script>
 // === Boxes dynamic inputs ===
const enableBoxes = document.getElementById('enableBoxes');
const boxesWrapper = document.getElementById('boxesWrapper');
const boxesContainer = document.getElementById('boxesContainer');
const addBoxBtn = document.getElementById('addBoxBtn');
let removedExistingBoxes = []; // store deleted box IDs

// toggle boxes visibility
enableBoxes.addEventListener('change', function() {
    boxesWrapper.classList.toggle('d-none', !this.checked);
});

// add new box (removable)
addBoxBtn.addEventListener('click', function() {
    const div = document.createElement('div');
    div.className = "input-group mb-2 box-item";
    div.innerHTML = `
        <input type="text" name="boxes[]" class="form-control" placeholder="Enter box name">
        <button type="button" class="btn btn-danger remove-box">✖</button>
    `;
    boxesContainer.appendChild(div);
    updateBoxRemoveButtons();
});

// handle remove clicks (for both existing & new)
boxesContainer.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-box')) {
        const wrapper = e.target.closest('.box-item');

        if (wrapper.classList.contains('existing-box')) {
            // mark existing as removed
            const id = wrapper.getAttribute('data-id');
            if (id) removedExistingBoxes.push(id);
        }

        wrapper.remove();
        updateBoxRemoveButtons();
    }
});

// ensure last/only new input has no ❌
function updateBoxRemoveButtons() {
    const boxItems = boxesContainer.querySelectorAll('.box-item');
    if (boxItems.length === 1) {
        const btn = boxItems[0].querySelector('.remove-box');
        if (btn) btn.style.display = 'none';
    } else {
        boxItems.forEach(item => {
            const btn = item.querySelector('.remove-box');
            if (btn) btn.style.display = 'inline-block';
        });
    }
}

// init
updateBoxRemoveButtons();

// inject removed IDs into form before submit
$('#categoryForm').on('submit', function(e) {
    removedExistingBoxes.forEach(id => {
        $(this).append(`<input type="hidden" name="removed_existing_boxes[]" value="${id}">`);
    });
});


</script>
@endsection