@extends('components.layouts.admin-default')

@section('content')
@include('components.includes.admin.navbar')

<style>
.collection-image-thumb { width: 90px; height:90px; object-fit:cover; margin:6px; border-radius:6px; border:2px solid transparent; position:relative; }
.collection-image-thumb.active { border-color:#6cc2b6; }
.collection-image-main { width:100%; max-height:360px; object-fit:contain; border-radius:6px; background:#fff; }
/* container now uses flex so existing + new previews stay inline */
#image-container { display:flex; flex-wrap:wrap; gap:8px; align-items:flex-start; }
.existing-image, .new-image-preview { position:relative; }
.remove-btn { position:absolute; top:4px; right:4px; z-index:2; }
#drop-area.dragging { background:#f8f9fa; border-color:#6cc2b6; }
</style>

<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($collection) ? 'Edit Collection' : 'Add New Collection' }}</h2>
            <a href="{{ route('admin.catelogs') }}" class="btn text-white" style="background-color: #6cc2b6;">← Back</a>
        </div>

        <form id="collectionForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $collection->id ?? '' }}">

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $collection->name ?? '') }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $collection->description ?? '') }}</textarea>
                </div>
            </div>

        <div class="row mb-3">
    <div class="col-md-12">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-control">
            <option value="1" {{ (string) old('status', isset($collection) ? (string)$collection->status : '1') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string) old('status', isset($collection) ? (string)$collection->status : '1') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
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
                        @if(isset($collection) && !empty($collection->images))
                            @foreach($collection->images as $img)
                                <div class="existing-image" data-filename="{{ $img }}">
                                    <img src="{{ asset('assets/images/collections/' . $img) }}" class="collection-image-thumb">
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
                Save Collection
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
    const form = document.getElementById('collectionForm');
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
    ['dragenter','dragover'].forEach(ev => dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.add('dragging'); }));
    ['dragleave','drop'].forEach(ev => dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.remove('dragging'); }));
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
    $('#collectionForm').on('submit', function(e) {
        e.preventDefault();
        const $btn = $('#saveBtn');
        $btn.prop('disabled', true);

        const formData = new FormData(this);

        // append droppedFiles as images[]
        droppedFiles.forEach(f => formData.append('images[]', f));

        // append removed existing as JSON
        formData.append('removed_existing_images', JSON.stringify(removedExisting));

        Swal.fire({ title: 'Processing...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: "{{ route('admin.catelog.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                Swal.close();
                if (res.status) {
                    Swal.fire('Success', res.message || 'Saved', 'success').then(() => {
                        window.location.href = (res.redirect_route || "{{ route('admin.catelogs') }}");
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
@endsection
