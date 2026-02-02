@extends('components.layouts.admin-default')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

<!-- Small style: make color input visually match .form-control (full width, height, border) -->
<style>
    /* Make the native color input fill like a form-control */
    input[type="color"].form-control-color {
        width: 100%;
        /* match typical bootstrap form-control height + small buffer */
        height: calc(1.5em + .75rem + 6px);
        padding: .375rem .75rem;
        border: 1px solid #ced4da;
        border-radius: .375rem;
        box-sizing: border-box;
        cursor: pointer;
        -webkit-appearance: none;
        appearance: none;
        vertical-align: middle;
    }

    /* Some browsers show inner swatch — this makes sure the input area looks consistent */
    input[type="color"].form-control-color::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    input[type="color"].form-control-color::-webkit-color-swatch {
        border: none;
        border-radius: .25rem;
    }

    /* Fallback for Firefox: increase height so it looks consistent */
    @-moz-document url-prefix() {
        input[type="color"].form-control-color {
            padding: .375rem .75rem;
        }
    }
</style>

@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ isset($product) ? 'Edit Color' : 'Add New Color' }}</h2>
            <a href="{{ route('admin.colors') }}" class="btn text-white" style="background-color: #6cc2b6; border-color: #6cc2b6;">← Back</a>
        </div>

        <form id="ColorForm" >
            @csrf
            <input type="hidden" name="id" value="{{ $color->id ?? '' }}">

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Color Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $color->name ?? '') }}" >
            </div>

            <!-- Color -->
            <div class="mb-3">
                <label for="color" class="form-label">Color Display</label>
                <input type="color" class="form-control form-control-color" id="color" name="color"
                       value="{{ old('color', $color->hex_code ?? '#ffffff') }}">
            </div>

            <div class="mb-3">
                <label for="hex_code" class="form-label">Hex Code</label>
                <input type="text" class="form-control" id="hex_code" name="hex_code"
                       value="{{ old('hex_code', $color->hex_code ?? '') }}" required placeholder="#FFFFFF" readonly>
            </div>
            <!-- Submit -->
            <button type="submit" class="btn" style="background-color:#6cc2b6;color:white;">
                {{ isset($color) ? 'Update Color' : 'Save Color' }}
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
    // Initialize hex input from color input on load, and keep it readonly
    function normalizeHex(val) {
        if (!val && val !== '') return '';
        val = String(val).trim();
        if (val === '') return '';
        if (val[0] !== '#') val = '#' + val;
        return val.toUpperCase();
    }

    var $colorInput = $('#color');
    var $hexInput = $('#hex_code');

    // ensure hex is readonly (in case later HTML changes)
    $hexInput.prop('readonly', true);

    // init hex value from color input or fallback to existing hex_code value
    var initialColorVal = $colorInput.val() || $hexInput.val() || '#FFFFFF';
    $hexInput.val(normalizeHex(initialColorVal));
    // Also ensure color input reflects hex if hex contains a valid value
    try {
        if ($hexInput.val()) {
            $colorInput.val($hexInput.val());
        }
    } catch (e) {
        // ignore if browser rejects value
    }

    // update hex when color input changes
    $colorInput.on('input change', function() {
        var v = $(this).val();
        $hexInput.val(normalizeHex(v));
    });

    // Submit handler (unchanged apart from being inside ready)
    $('#ColorForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: "{{ route('admin.color.store') }}", // single route
            method: "POST",
            data: formData,
             success: function(response) {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Colors added successfully!',
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
                // don't reference undefined submitButton to avoid console errors
            }
        });
    });
});
</script>

@endsection
