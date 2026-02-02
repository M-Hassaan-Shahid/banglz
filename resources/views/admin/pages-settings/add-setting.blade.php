@extends('components.layouts.admin-default')

@section('content')
@include('components.includes.admin.navbar')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet" />
<style>
    .setting-image-thumb { width:120px; height:120px; object-fit:cover; border-radius:6px; border:2px solid #ddd; }
    .right-hero-section { display:flex; }
    .sub-right-hero-section { flex:1; position:relative; overflow:hidden; }
    .draggable-image { cursor:grab; user-select:none; max-width:100%; transition:transform 0.05s linear; }
    .editable-bg { position:relative; overflow:hidden; border-radius:6px; }
    .editable-bg img { width:100%; height:auto; cursor:grab; user-select:none; transition:transform 0.05s linear; }
</style>

<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ 'Page Settings' }}</h2>
            <a href="{{ route('admin.page-setting') }}" class="btn text-white" style="background-color:#6cc2b6;">← Back</a>
        </div>

        <form id="pageSettingForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $current->id ?? '' }}">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Page Name</label>
                    <select name="page_name" id="page_name" class="form-control" required>
                        <option value="">-- Select Page --</option>
                        <option value="home" @if(($current->page_name ?? '')==='home') selected @endif>Home</option>
                        <option value="contact_us" @if(($current->page_name ?? '')==='contact_us') selected @endif>Contact Us</option>
                        <option value="about_us" @if(($current->page_name ?? '')==='about_us') selected @endif>About Us</option>
                        <option value="resource" @if(($current->page_name ?? '')==='resource') selected @endif>Resource</option>
                        <option value="appointments" @if(($current->page_name ?? '')==='appointments') selected @endif>Appointments Section</option>
                    </select>
                </div>
            </div>

            @php
                $home = $pages->get('home') ?? null;
                $about = $pages->get('about_us') ?? null;
                $contact = $pages->get('contact_us') ?? null;
                $resource = $pages->get('resource') ?? null;
                $appointments = $pages->get('appointments') ?? null;

                $homeImagesRaw = $home ? $home->images : [];
                $homeImages = is_array($homeImagesRaw) ? $homeImagesRaw : (is_string($homeImagesRaw) ? json_decode($homeImagesRaw, true) : []);
                $homeImage1 = $homeImages[0]['src'] ?? 'Frame 92.png';
                $homeImage2 = $homeImages[1]['src'] ?? 'Frame 93.png';
                $homeImage1Transform = $homeImages[0]['transform'] ?? '';
                $homeImage2Transform = $homeImages[1]['transform'] ?? '';
                
                // Get appointments data
                $appointmentsMeta = optional($appointments)->meta_data ?? [];
                if (is_string($appointmentsMeta)) { $appointmentsMeta = json_decode($appointmentsMeta, true); }
                $appointmentsData = $appointmentsMeta['appointments'] ?? [];
            @endphp

            {{-- Appointments Section --}}
            <div id="appointments-section" class="appointments-section" style="display:none;">
                <h4 class="mb-4">Appointments Section</h4>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Section Heading</label>
                        <input type="text" name="appointments[heading]" class="form-control" 
                               value="{{ optional($appointments)->heading ?? 'Book Your Personal Appointment' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Section Description</label>
                        <input type="text" name="appointments[description]" class="form-control" 
                               value="{{ optional($appointments)->description ?? 'Book your personal appointment for styling and personalized consultation' }}">
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Appointment Cards (Maximum 4)</h5>
                <div id="appointments-cards-container">
                    @php
                        // Only show first 4 appointments
                        $displayAppointments = array_slice($appointmentsData, 0, 4);
                        // Pad with empty appointments if less than 4
                        while (count($displayAppointments) < 4) {
                            $displayAppointments[] = ['title' => '', 'description' => '', 'image' => 'ear.jpg', 'link' => '/appointment'];
                        }
                    @endphp
                    @foreach($displayAppointments as $index => $appointment)
                    <div class="card mb-3 appointment-card">
                        <div class="card-body">
                            <h6>Card {{ $index + 1 }}</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="appointments[{{ $index }}][title]" class="form-control" 
                                           value="{{ $appointment['title'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="text" name="appointments[{{ $index }}][link]" class="form-control" 
                                           value="{{ $appointment['link'] ?? '/appointment' }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="appointments[{{ $index }}][description]" class="form-control" rows="2">{{ $appointment['description'] ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="appointments[{{ $index }}][image]" class="form-control" accept="image/*">
                                <input type="hidden" name="appointments[{{ $index }}][existing_image]" value="{{ $appointment['image'] ?? 'ear.jpg' }}">
                                @if(!empty($appointment['image']) && $appointment['image'] !== 'ear.jpg')
                                <div class="mt-2">
                                    <img src="{{ asset('assets/images/' . $appointment['image']) }}" alt="Current Image" style="max-width: 150px; height: auto;">
                                    <p class="text-muted small">Current: {{ $appointment['image'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Home --}}
            <div class="hero-section pt-0 pb" style="display:none;">
                <div class="left-hero-section">
                    <div class="left-inner-hero-sec">
                        @php
                            $homeMeta = optional($home)->meta_data ?? [];
                            if (is_string($homeMeta)) { $homeMeta = json_decode($homeMeta, true); }
                            $homeHeroMeta = $homeMeta['sections']['hero'] ?? [];
                        @endphp
                        <h1 id="hero_heading">{{ $homeHeroMeta['heading'] ?? (optional($home)->heading ?? 'Create Bangle box for all Styles') }}</h1>
                        <p id="hero_description">{{ $homeHeroMeta['description'] ?? (optional($home)->description ?? 'Explore our diverse selection of bangles designed for every occasion.') }}</p>
                        <a id="hero_button" href="{{ url('banglz-box') }}">{{ ($homeMeta['button_label'] ?? 'Start building your bangle box') }}</a>
                        <button type="button" class="btn btn-sm btn-warning mt-3 editHeroBtn" data-section="home">Edit Hero Section</button>
                        <div class="selection-sec mt-3">
                            <div class="circle-section">1</div>
                            <p id="size_label_el">{{ $homeHeroMeta['size_label'] ?? 'Select Your Size' }}</p>
                            <div class="line-section"></div>
                            <div class="circle-section">2</div>
                            <p id="style_label_el">{{ $homeHeroMeta['style_label'] ?? 'Select Your Style' }}</p>
                        </div>
                    </div>
                </div>

                @php
                    $meta = optional($home)->meta_data ?? [];
                    if (is_string($meta)) { $meta = json_decode($meta, true); }
                    $hero = $meta['sections']['hero'] ?? [];
                    $heroImages = $hero['images'] ?? [];
                    if (empty($heroImages)) {
                        $heroImages = [
                            ['src' => $homeImage1, 'transform' => $homeImage1Transform],
                            ['src' => $homeImage2, 'transform' => $homeImage2Transform],
                        ];
                    }
                @endphp
                <div class="right-hero-section">
                    <div class="sub-right-hero-section" style="position:relative">
                        <img id="home_img_1" src="{{ asset('assets/images/pages/'.($heroImages[0]['src'] ?? $homeImage1)) }}"
                             class="draggable-image" data-transform="{{ $heroImages[0]['transform'] ?? $homeImage1Transform }}">
                        <input type="hidden" name="home[image1_transform]" id="home_img1_transform" value="{{ $heroImages[0]['transform'] ?? $homeImage1Transform }}">
                        <button type="button" class="btn btn-sm btn-secondary crop-img-btn" data-index="1" style="position:absolute; top:8px; right:8px;">Crop</button>
                    </div>
                    <div class="sub-right-hero-section" style="position:relative">
                        <img id="home_img_2" src="{{ asset('assets/images/pages/'.($heroImages[1]['src'] ?? $homeImage2)) }}"
                             class="draggable-image" data-transform="{{ $heroImages[1]['transform'] ?? $homeImage2Transform }}">
                        <input type="hidden" name="home[image2_transform]" id="home_img2_transform" value="{{ $heroImages[1]['transform'] ?? $homeImage2Transform }}">
                        <button type="button" class="btn btn-sm btn-secondary crop-img-btn" data-index="2" style="position:absolute; top:8px; right:8px;">Crop</button>
                    </div>
                </div>
            </div>

            {{-- About --}}
           <div class="about-hero-section editable-bg w-100 mb-3 p-5" style="background:none; display:none; position:relative; overflow:hidden;">
                    <img src="{{ optional($about)->image ? asset('assets/images/pages/'.optional($about)->image) : asset('assets/images/about-head.jpg') }}"
                        class="draggable-image bg-like"
                        data-transform="{{ optional($about)->transform }}"
                        style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                    <input type="hidden" name="about[image_transform]" id="about_img_transform" value="{{ optional($about)->transform }}">
                    <button type="button" class="btn btn-sm btn-secondary crop-img-btn-single" data-key="about" style="position:absolute; top:8px; right:8px; z-index:10;">Crop</button>

                <div class="content position-relative text-white" style="height: 60%">
                    <h1 id="about_hero_heading">{{ optional($about)->heading ?? 'About Us Heading' }}</h1>
                    <button type="button" class="btn btn-sm btn-warning editHeroBtn" data-section="about">Edit About Hero</button>
                </div>
            </div>


            {{-- Contact --}}
            <div class="contact-us-section editable-bg w-100 mb-3 p-5" style="background:none;display:none; position:relative; overflow:hidden;">
                    <img src="{{ optional($contact)->image ? asset('assets/images/pages/'.optional($contact)->image) : asset('assets/images/about-head.jpg') }}"
                        class="draggable-image bg-like"
                        data-transform="{{ optional($contact)->transform }}"
                        style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                    <input type="hidden" name="contact[image_transform]" id="contact_img_transform" value="{{ optional($contact)->transform }}">
                    <button type="button" class="btn btn-sm btn-secondary crop-img-btn-single" data-key="contact" style="position:absolute; top:8px; right:8px; z-index:10;">Crop</button>

                    <div class="content position-relative text-white">
                        <h1 id="contact_heading">{{ optional($contact)->heading ?? 'Welcome To Contact Us' }}</h1>
                        <button type="button" class="btn btn-sm btn-warning editHeroBtn" data-section="contact">Edit Contact Hero</button>
                    </div>
                </div>


            {{-- Resource --}}
           <div class="resource-section editable-bg w-100 mb-3 p-5" style="background:none;display:none; position:relative; overflow:hidden;">
                <img src="{{ optional($resource)->image ? asset('assets/images/pages/'.optional($resource)->image) : asset('assets/images/about-head.jpg') }}"
                    class="draggable-image bg-like"
                    data-transform="{{ optional($resource)->transform }}"
                    style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                <input type="hidden" name="resource[image_transform]" id="resource_img_transform" value="{{ optional($resource)->transform }}">
                <button type="button" class="btn btn-sm btn-secondary crop-img-btn-single" data-key="resource" style="position:absolute; top:8px; right:8px; z-index:10;">Crop</button>

                <div class="content position-relative text-white">
                    <h1 id="resource_heading">{{ optional($resource)->heading ?? 'Welcome To Resources' }}</h1>
                    <button type="button" class="btn btn-sm btn-warning editHeroBtn" data-section="resource">Edit Resource Hero</button>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="heroEditModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Hero Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="editing_section">

                            <div class="mb-3">
                                <label class="form-label">Heading</label>
                                <input type="text" id="hero_heading_input" class="form-control">
                            </div>

                            <div class="mb-3" id="descriptionRow">
                                <label class="form-label">Description</label>
                                <textarea id="hero_description_input" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3" id="buttonLabelRow">
                                <label class="form-label">Button Label</label>
                                <input type="text" id="hero_button_label_input" class="form-control">
                            </div>
                            <div class="row" id="labelsRow">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Size Label</label>
                                    <input type="text" id="hero_size_label_input" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Style Label</label>
                                    <input type="text" id="hero_style_label_input" class="form-control">
                                </div>
                            </div>

                            <div id="homeImagesRow" style="display:none;">
                                <div class="mb-3">
                                    <label>Image 1</label>
                                    <input type="file" id="hero_image_input1" accept="image/*" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Image 2</label>
                                    <input type="file" id="hero_image_input2" accept="image/*" class="form-control">
                                </div>
                            </div>

                            <div id="singleImageRow" style="display:none;">
                                <div class="mb-3">
                                    <label>Image</label>
                                    <input type="file" id="hero_image_input" accept="image/*" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="saveHeroBtn" type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imageCropModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Crop Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label class="form-label">Aspect Ratio</label>
                                <select id="cropAspectRatio" class="form-select">
                                    <option value="NaN">Free</option>
                                    <option value="1">1:1</option>
                                    <option value="16/9">16:9</option>
                                    <option value="4/3">4:3</option>
                                </select>
                            </div>
                            <div style="max-height:60vh; overflow:auto">
                                <img id="cropperImage" src="" style="max-width:100%" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="confirmCropBtn" type="button" class="btn btn-primary">Save Crop</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden inputs for headings/description --}}
            <input type="hidden" name="home[heading]" id="home_heading_input_hidden">
            <input type="hidden" name="home[description]" id="home_description_input_hidden">
            <input type="hidden" name="home[button_label]" id="home_button_label_input_hidden">
            <input type="hidden" name="home[size_label]" id="home_size_label_input_hidden">
            <input type="hidden" name="home[style_label]" id="home_style_label_input_hidden">
            <input type="hidden" name="about[heading]" id="about_heading_input_hidden">
            <input type="hidden" name="contact[heading]" id="contact_heading_input_hidden">
            <input type="hidden" name="resource[heading]" id="resource_heading_input_hidden">

            <div class="fields pl-2 mt-3">
                <button type="submit" id="saveBtn" class="btn" style="background-color:#6cc2b6;color:white;">Save Setting</button>
            </div>
        </form>
    </div>
</main>
@endsection

@section('admininsertjavascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const pageSelect = document.getElementById('page_name');
    const homeHero = document.querySelector('.hero-section');
    const aboutHero = document.querySelector('.about-hero-section');
    const contactHero = document.querySelector('.contact-us-section');
    const resourceHero = document.querySelector('.resource-section');
    const appointmentsSection = document.getElementById('appointments-section');

    function toggleHeroSections() {
        const val = pageSelect.value;
        if (homeHero) homeHero.style.display = val === 'home' ? 'flex' : 'none';
        if (aboutHero) aboutHero.style.display = val === 'about_us' ? 'block' : 'none';
        if (contactHero) contactHero.style.display = val === 'contact_us' ? 'block' : 'none';
        if (resourceHero) resourceHero.style.display = val === 'resource' ? 'block' : 'none';
        if (appointmentsSection) appointmentsSection.style.display = val === 'appointments' ? 'block' : 'none';
        const customizePreview = document.getElementById('customizePreview');
        if (customizePreview) customizePreview.style.display = val === 'home' ? 'block' : 'none';
        if (val === 'home') {
            const heroHeadingEl = document.getElementById('hero_heading');
            const heroDescEl = document.getElementById('hero_description');
            const heroButtonEl = document.getElementById('hero_button');
            const sizeLabelEl = document.getElementById('size_label_el');
            const styleLabelEl = document.getElementById('style_label_el');
            document.getElementById('home_heading_input_hidden').value = (heroHeadingEl?.textContent || '').trim();
            document.getElementById('home_description_input_hidden').value = (heroDescEl?.textContent || '').trim();
            document.getElementById('home_button_label_input_hidden').value = (heroButtonEl?.textContent || '').trim();
            document.getElementById('home_size_label_input_hidden').value = (sizeLabelEl?.textContent || '').trim();
            document.getElementById('home_style_label_input_hidden').value = (styleLabelEl?.textContent || '').trim();
        } else if (val === 'about_us') {
            const aboutHeadingEl = document.getElementById('about_hero_heading');
            document.getElementById('about_heading_input_hidden').value = (aboutHeadingEl?.textContent || '').trim();
        } else if (val === 'contact_us') {
            const contactHeadingEl = document.getElementById('contact_heading');
            document.getElementById('contact_heading_input_hidden').value = (contactHeadingEl?.textContent || '').trim();
        } else if (val === 'resource') {
            const resourceHeadingEl = document.getElementById('resource_heading');
            document.getElementById('resource_heading_input_hidden').value = (resourceHeadingEl?.textContent || '').trim();
        }
    }
    toggleHeroSections();
    pageSelect.addEventListener('change', toggleHeroSections);

    // Draggable + Zoomable images
    document.querySelectorAll('.draggable-image').forEach(img => {
        let scale = 1, posX = 0, posY = 0, isDragging = false, startX, startY;

        // Apply saved transform
        if (img.dataset.transform) {
            img.style.transform = img.dataset.transform;
            img.nextElementSibling.value = img.dataset.transform;
            const match = img.dataset.transform.match(/translate\((.*?)px,\s*(.*?)px\)\s*scale\((.*?)\)/);
            if (match) {
                posX = parseFloat(match[1]); posY = parseFloat(match[2]); scale = parseFloat(match[3]);
            }
        }

        img.addEventListener('mousedown', e => {
            isDragging = true;
            startX = e.clientX - posX;
            startY = e.clientY - posY;
            img.style.cursor = 'grabbing';
        });
        document.addEventListener('mousemove', e => {
            if (!isDragging) return;
            posX = e.clientX - startX;
            posY = e.clientY - startY;
            updateTransform(img);
        });
        document.addEventListener('mouseup', () => { isDragging = false; img.style.cursor = 'grab'; });

        img.addEventListener('wheel', e => {
            e.preventDefault();
            scale += e.deltaY * -0.001;
            scale = Math.min(Math.max(0.5, scale), 3);
            updateTransform(img);
        });

        function updateTransform(image) {
            const transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
            image.style.transform = transform;
            image.nextElementSibling.value = transform;
        }
    });

    // Modal edit (same as before but no cropper)
    const modalEl = document.getElementById('heroEditModal');
    const editButtons = document.querySelectorAll('.editHeroBtn');
    const saveHeroBtn = document.getElementById('saveHeroBtn');
    const editingSection = document.getElementById('editing_section');
    const headingInput = document.getElementById('hero_heading_input');
    const descInput = document.getElementById('hero_description_input');
    const buttonLabelInput = document.getElementById('hero_button_label_input');
    const sizeLabelInput = document.getElementById('hero_size_label_input');
    const styleLabelInput = document.getElementById('hero_style_label_input');
    const descriptionRow = document.getElementById('descriptionRow');
    const homeImagesRow = document.getElementById('homeImagesRow');
    const singleImageRow = document.getElementById('singleImageRow');
    const imageInput = document.getElementById('hero_image_input');
    const imageInput1 = document.getElementById('hero_image_input1');
    const imageInput2 = document.getElementById('hero_image_input2');
    const cropModalEl = document.getElementById('imageCropModal');
    const bsCropModal = new bootstrap.Modal(cropModalEl);
    const cropperImgEl = document.getElementById('cropperImage');
    const aspectSel = document.getElementById('cropAspectRatio');
    const confirmCropBtn = document.getElementById('confirmCropBtn');
    let cropper = null;
    let cropResolve = null;

    function openCropper(file) {
        return new Promise((resolve) => {
            cropResolve = resolve;
            const reader = new FileReader();
            reader.onload = function(e) {
                cropperImgEl.src = e.target.result;
                bsCropModal.show();
                setTimeout(()=>{
                    if (cropper) { cropper.destroy(); }
                    cropper = new Cropper(cropperImgEl, { viewMode: 1, aspectRatio: NaN });
                }, 150);
            };
            reader.readAsDataURL(file);
        });
    }
    function openCropperFromSrc(idx) {
        const imgEl = idx === 1 ? document.getElementById('home_img_1') : document.getElementById('home_img_2');
        cropperImgEl.src = imgEl.src;
        bsCropModal.show();
        setTimeout(()=>{
            if (cropper) { cropper.destroy(); }
            cropper = new Cropper(cropperImgEl, { viewMode: 1, aspectRatio: NaN });
        }, 150);
        cropResolve = function(cropped) {
            if (idx === 1) {
                let existing = document.getElementById('home_image1_input_hidden');
                if (!existing) {
                    existing = document.createElement('input');
                    existing.type = 'file';
                    existing.name = 'home[image1]';
                    existing.id = 'home_image1_input_hidden';
                    existing.style.display = 'none';
                    document.getElementById('pageSettingForm').appendChild(existing);
                }
                const dt = new DataTransfer();
                dt.items.add(cropped);
                existing.files = dt.files;
                document.getElementById('home_img_1').src = URL.createObjectURL(cropped);
            } else {
                let existing2 = document.getElementById('home_image2_input_hidden');
                if (!existing2) {
                    existing2 = document.createElement('input');
                    existing2.type = 'file';
                    existing2.name = 'home[image2]';
                    existing2.id = 'home_image2_input_hidden';
                    existing2.style.display = 'none';
                    document.getElementById('pageSettingForm').appendChild(existing2);
                }
                const dt2 = new DataTransfer();
                dt2.items.add(cropped);
                existing2.files = dt2.files;
                document.getElementById('home_img_2').src = URL.createObjectURL(cropped);
            }
        }
    }
    aspectSel.addEventListener('change', function(){
        const val = this.value === 'NaN' ? NaN : eval(this.value);
        if (cropper) cropper.setAspectRatio(val);
    });
    confirmCropBtn.addEventListener('click', function(){
        if (!cropper) return;
        cropper.getCroppedCanvas({}).toBlob(function(blob){
            const file = new File([blob], `crop_${Date.now()}.jpg`, { type: 'image/jpeg' });
            bsCropModal.hide();
            cropResolve(file);
            document.querySelectorAll('.modal-backdrop').forEach(b=>b.remove());
            document.body.classList.remove('modal-open');
        }, 'image/jpeg', 0.85);
    });

    document.querySelectorAll('.crop-img-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const idx = parseInt(this.dataset.index, 10);
            openCropperFromSrc(idx);
        });
    });

    document.querySelectorAll('.crop-img-btn-single').forEach(btn => {
        btn.addEventListener('click', function(){
            const key = this.dataset.key;
            const sectionMap = {
                about: { imgSelector: '.about-hero-section img.draggable-image', hiddenName: 'about[image]' },
                contact: { imgSelector: '.contact-us-section img.draggable-image', hiddenName: 'contact[image]' },
                resource: { imgSelector: '.resource-section img.draggable-image', hiddenName: 'resource[image]' },
            };
            const conf = sectionMap[key];
            if (!conf) return;
            const imgEl = document.querySelector(conf.imgSelector);
            if (!imgEl) return;
            cropperImgEl.src = imgEl.src;
            bsCropModal.show();
            setTimeout(()=>{
                if (cropper) { cropper.destroy(); }
                cropper = new Cropper(cropperImgEl, { viewMode: 1, aspectRatio: NaN });
            }, 150);
            cropResolve = function(cropped){
                let hidden = document.querySelector(`#pageSettingForm input[name="${conf.hiddenName}"]`);
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'file';
                    hidden.name = conf.hiddenName;
                    hidden.style.display = 'none';
                    document.getElementById('pageSettingForm').appendChild(hidden);
                }
                const dt = new DataTransfer();
                dt.items.add(cropped);
                hidden.files = dt.files;
                imgEl.src = URL.createObjectURL(cropped);
            }
        });
    });

    const heroHeadingEl = document.getElementById('hero_heading');
    const heroDescEl = document.getElementById('hero_description');
    const heroButtonEl = document.getElementById('hero_button');
    const sizeLabelEl = document.getElementById('size_label_el');
    const styleLabelEl = document.getElementById('style_label_el');
    const homeImg1 = document.getElementById('home_img_1');
    const homeImg2 = document.getElementById('home_img_2');
    const aboutHeadingEl = document.getElementById('about_hero_heading');
    const contactHeadingEl = document.getElementById('contact_heading');
    const resourceHeadingEl = document.getElementById('resource_heading');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const section = this.dataset.section;
            editingSection.value = section;
            if (section === 'home') {
                headingInput.value = heroHeadingEl.textContent.trim();
                descInput.value = heroDescEl.textContent.trim();
                buttonLabelInput.value = heroButtonEl.textContent.trim();
                sizeLabelInput.value = sizeLabelEl.textContent.trim();
                styleLabelInput.value = styleLabelEl.textContent.trim();
                descriptionRow.style.display = 'block';
                document.getElementById('buttonLabelRow').style.display = 'block';
                document.getElementById('labelsRow').style.display = 'flex';
                homeImagesRow.style.display = 'block';
                singleImageRow.style.display = 'none';
            } else if (section === 'about') {
                headingInput.value = aboutHeadingEl.textContent.trim();
                descInput.value = '';
                descriptionRow.style.display = 'none';
                document.getElementById('buttonLabelRow').style.display = 'none';
                document.getElementById('labelsRow').style.display = 'none';
                homeImagesRow.style.display = 'none';
                singleImageRow.style.display = 'block';
            } else if (section === 'contact') {
                headingInput.value = contactHeadingEl.textContent.trim();
                descInput.value = '';
                descriptionRow.style.display = 'none';
                document.getElementById('buttonLabelRow').style.display = 'none';
                document.getElementById('labelsRow').style.display = 'none';
                homeImagesRow.style.display = 'none';
                singleImageRow.style.display = 'block';
            } else if (section === 'resource') {
                headingInput.value = resourceHeadingEl.textContent.trim();
                descInput.value = '';
                descriptionRow.style.display = 'none';
                document.getElementById('buttonLabelRow').style.display = 'none';
                document.getElementById('labelsRow').style.display = 'none';
                homeImagesRow.style.display = 'none';
                singleImageRow.style.display = 'block';
            }
            imageInput.value = ''; imageInput1.value = ''; imageInput2.value = '';
            (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).show();
        });
    });

    imageInput1.addEventListener('change', function(){
        const f1 = this.files[0];
        if (!f1) return;
        openCropper(f1).then(cropped => {
            let existing = document.getElementById('home_image1_input_hidden');
            if (!existing) {
                existing = document.createElement('input');
                existing.type = 'file';
                existing.name = 'home[image1]';
                existing.id = 'home_image1_input_hidden';
                existing.style.display = 'none';
                document.getElementById('pageSettingForm').appendChild(existing);
            }
            const dt = new DataTransfer();
            dt.items.add(cropped);
            existing.files = dt.files;
            homeImg1.src = URL.createObjectURL(cropped);
        });
    });
    imageInput2.addEventListener('change', function(){
        const f2 = this.files[0];
        if (!f2) return;
        openCropper(f2).then(cropped2 => {
            let existing2 = document.getElementById('home_image2_input_hidden');
            if (!existing2) {
                existing2 = document.createElement('input');
                existing2.type = 'file';
                existing2.name = 'home[image2]';
                existing2.id = 'home_image2_input_hidden';
                existing2.style.display = 'none';
                document.getElementById('pageSettingForm').appendChild(existing2);
            }
            const dt2 = new DataTransfer();
            dt2.items.add(cropped2);
            existing2.files = dt2.files;
            homeImg2.src = URL.createObjectURL(cropped2);
        });
    });

    saveHeroBtn.addEventListener('click', function () {
    const section = editingSection.value;
    const heading = headingInput.value.trim();

    if (section === 'home') {
        heroHeadingEl.textContent = heading || '';
        document.getElementById('home_heading_input_hidden').value = heading || '';
        heroDescEl.textContent = descInput.value.trim();
        document.getElementById('home_description_input_hidden').value = descInput.value.trim();
        heroButtonEl.textContent = buttonLabelInput.value.trim() || 'Start building your bangle box';
        document.getElementById('home_button_label_input_hidden').value = buttonLabelInput.value.trim();
        sizeLabelEl.textContent = sizeLabelInput.value.trim() || 'Select Your Size';
        document.getElementById('home_size_label_input_hidden').value = sizeLabelInput.value.trim();
        styleLabelEl.textContent = styleLabelInput.value.trim() || 'Select Your Style';
        document.getElementById('home_style_label_input_hidden').value = styleLabelInput.value.trim();
    }

    if (section === 'about') {
    // Update heading + hidden input
    aboutHeadingEl.textContent = heading || '';
    document.getElementById('about_heading_input_hidden').value = heading || '';

    // Handle single image
    const f = imageInput.files[0];
    if (f) {
        openCropper(f).then(cropped => {
            let existing = document.getElementById('about_image_input_hidden');
            if (!existing) {
                existing = document.createElement('input');
                existing.type = 'file';
                existing.name = 'about[image]';
                existing.id = 'about_image_input_hidden';
                existing.style.display = 'none';
                document.getElementById('pageSettingForm').appendChild(existing);
            }
            const dt = new DataTransfer();
            dt.items.add(cropped);
            existing.files = dt.files;
            if (aboutHero && aboutHero.querySelector('img')) {
                aboutHero.querySelector('img').src = URL.createObjectURL(cropped);
            }
        });
    }
}

if (section === 'contact') {
    // Update heading + hidden input
    contactHeadingEl.textContent = heading || '';
    document.getElementById('contact_heading_input_hidden').value = heading || '';

    // Handle single image
    const f = imageInput.files[0];
    if (f) {
        openCropper(f).then(cropped => {
            let existing = document.getElementById('contact_image_input_hidden');
            if (!existing) {
                existing = document.createElement('input');
                existing.type = 'file';
                existing.name = 'contact[image]';
                existing.id = 'contact_image_input_hidden';
                existing.style.display = 'none';
                document.getElementById('pageSettingForm').appendChild(existing);
            }
            const dt = new DataTransfer();
            dt.items.add(cropped);
            existing.files = dt.files;
            if (contactHero && contactHero.querySelector('img')) {
                contactHero.querySelector('img').src = URL.createObjectURL(cropped);
            }
        });
    }
}

if (section === 'resource') {
    // Update heading + hidden input
    resourceHeadingEl.textContent = heading || '';
    document.getElementById('resource_heading_input_hidden').value = heading || '';

    // Handle single image
    const f = imageInput.files[0];
    if (f) {
        openCropper(f).then(cropped => {
            let existing = document.getElementById('resource_image_input_hidden');
            if (!existing) {
                existing = document.createElement('input');
                existing.type = 'file';
                existing.name = 'resource[image]';
                existing.id = 'resource_image_input_hidden';
                existing.style.display = 'none';
                document.getElementById('pageSettingForm').appendChild(existing);
            }
            const dt = new DataTransfer();
            dt.items.add(cropped);
            existing.files = dt.files;
            if (resourceHero && resourceHero.querySelector('img')) {
                resourceHero.querySelector('img').src = URL.createObjectURL(cropped);
            }
        });
    }
}

    (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).hide();
    document.querySelectorAll('.modal-backdrop').forEach(b=>b.remove());
    document.body.classList.remove('modal-open');
});
    // Save form
    $('#pageSettingForm').on('submit', function(e) {
        e.preventDefault();
        const $btn = $('#saveBtn');
        $btn.prop('disabled', true);
        const formData = new FormData(this);
        Swal.fire({ title: 'Processing...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        $.ajax({
            url: "{{ route('admin.page-settings.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                Swal.close();
                if (res.status) {
                    Swal.fire('Success', res.message || 'Saved', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', res.message || 'Failed', 'error');
                    $btn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                Swal.close();
                let msg = 'Something went wrong';
                if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                if (xhr.responseJSON?.errors) {
                    const keys = Object.keys(xhr.responseJSON.errors);
                    if (keys.length) msg = xhr.responseJSON.errors[keys[0]][0];
                }
                Swal.fire('Error', msg, 'error');
                $btn.prop('disabled', false);
            }
        });
    });
});
</script>
<!-- Removed customize modal logic to prevent null element errors -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const openCustomizeBtns = document.querySelectorAll('.editCustomizeBtn');
  const customizeModalEl = document.getElementById('customizeEditModal');
  if (!openCustomizeBtns.length || !customizeModalEl) return;
  const bsCustomizeModal = new bootstrap.Modal(customizeModalEl);

  // Elements to update/read
  const previewHeading1 = document.querySelector('.customize-title');
  const previewDesc1 = document.querySelector('.customize-desc');
  const previewHeading2 = document.querySelector('.bundle-section h3');
  const previewDesc2 = document.querySelector('.bundle-section p');

  // Card DOM nodes (preview)
  const cardPreviews = [
    document.querySelectorAll('.custom-card .custom-card-img')[0],
    document.querySelectorAll('.custom-card .custom-card-img')[1],
    document.querySelectorAll('.custom-card .custom-card-img')[2]
  ];
  const cardTitles = document.querySelectorAll('.custom-card .card-title');
  const cardSubs = document.querySelectorAll('.custom-card .card-sub');

  // Modal inputs
  const in_heading1 = document.getElementById('custom_heading1');
  const in_desc1 = document.getElementById('custom_desc1');
  const in_heading2 = document.getElementById('custom_heading2');
  const in_desc2 = document.getElementById('custom_desc2');

  const cardImageInputs = document.querySelectorAll('.card-image-input');
  const cardPreviewImgs = [
    document.getElementById('card_preview_0'),
    document.getElementById('card_preview_1'),
    document.getElementById('card_preview_2')
  ];
  const in_card_titles = [
    document.getElementById('card_title_0'),
    document.getElementById('card_title_1'),
    document.getElementById('card_title_2')
  ];
  const in_card_subs = [
    document.getElementById('card_sub_0'),
    document.getElementById('card_sub_1'),
    document.getElementById('card_sub_2')
  ];

  // open modal and populate current values
  openCustomizeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // fill headings/descriptions
      in_heading1.value = previewHeading1 ? previewHeading1.textContent.trim() : '';
      in_desc1.value = previewDesc1 ? previewDesc1.textContent.trim() : '';
      in_heading2.value = previewHeading2 ? previewHeading2.textContent.trim() : '';
      in_desc2.value = previewDesc2 ? previewDesc2.textContent.trim() : '';

      // populate cards: titles, subs, preview images (use src attr)
      for (let i=0;i<3;i++){
        in_card_titles[i].value = cardTitles[i] ? cardTitles[i].textContent.trim() : '';
        in_card_subs[i].value = cardSubs[i] ? cardSubs[i].textContent.trim() : '';
        // set preview img src from existing DOM preview if available
        if (cardPreviews[i] && cardPreviews[i].src) {
          cardPreviewImgs[i].src = cardPreviews[i].src;
        }
        // clear file inputs
        cardImageInputs[i].value = '';
      }

      bsCustomizeModal.show();
    });
  });

  cardImageInputs.forEach(inp=>{
    inp.addEventListener('change', function(e){
      const idx = parseInt(this.dataset.index, 10);
      const f = this.files[0];
      if (f) {
        openCropper(f).then(cropped => {
          cardPreviewImgs[idx].src = URL.createObjectURL(cropped);
          let existingFileInput = document.querySelector(`#pageSettingForm input[name="customize[images][${idx}]"]`);
          if (!existingFileInput) {
            existingFileInput = document.createElement('input');
            existingFileInput.type = 'file';
            existingFileInput.name = `customize[images][${idx}]`;
            existingFileInput.style.display = 'none';
            document.getElementById('pageSettingForm').appendChild(existingFileInput);
          }
          const dt = new DataTransfer();
          dt.items.add(cropped);
          existingFileInput.files = dt.files;
        });
      }
    });
  });

  // Save handler
  document.getElementById('saveCustomizeBtn').addEventListener('click', function(){
    // 1) update visible preview on page
    if (previewHeading1) previewHeading1.textContent = in_heading1.value || '';
    if (previewDesc1) previewDesc1.textContent = in_desc1.value || '';
    if (previewHeading2) previewHeading2.textContent = in_heading2.value || '';
    if (previewDesc2) previewDesc2.textContent = in_desc2.value || '';

    // cards: update heading, subs, and images (if selected)
    for (let i=0;i<3;i++){
      if (cardTitles[i]) cardTitles[i].textContent = in_card_titles[i].value || '';
      if (cardSubs[i]) cardSubs[i].textContent = in_card_subs[i].value || '';

      const f = cardImageInputs[i].files[0];
      if (f && cardPreviews[i]) {
        // update visible card image with local preview
        cardPreviews[i].src = URL.createObjectURL(f);

        // append hidden file input to form so it submits with formData
        let existingFileInput = document.querySelector(`#pageSettingForm input[name="customize[images][${i}]"]`);
        if (!existingFileInput) {
          existingFileInput = document.createElement('input');
          existingFileInput.type = 'file';
          existingFileInput.name = `customize[images][${i}]`;
          existingFileInput.style.display = 'none';
          document.getElementById('pageSettingForm').appendChild(existingFileInput);
        }
        // attach file via DataTransfer
        const dt = new DataTransfer();
        dt.items.add(f);
        existingFileInput.files = dt.files;
      }
      // always set hidden title/sub inputs
      let hiddenTitle = document.querySelector(`#pageSettingForm input[name="customize[titles][${i}]"]`);
      if (!hiddenTitle) {
        hiddenTitle = document.createElement('input');
        hiddenTitle.type = 'hidden';
        hiddenTitle.name = `customize[titles][${i}]`;
        document.getElementById('pageSettingForm').appendChild(hiddenTitle);
      }
      hiddenTitle.value = in_card_titles[i].value || '';

      let hiddenSub = document.querySelector(`#pageSettingForm input[name="customize[subs][${i}]"]`);
      if (!hiddenSub) {
        hiddenSub = document.createElement('input');
        hiddenSub.type = 'hidden';
        hiddenSub.name = `customize[subs][${i}]`;
        document.getElementById('pageSettingForm').appendChild(hiddenSub);
      }
      hiddenSub.value = in_card_subs[i].value || '';
    }

    // create/replace hidden inputs for headings & descriptions
    function setHidden(name, val) {
      let el = document.querySelector(`#pageSettingForm input[name="${name}"]`);
      if (!el) {
        el = document.createElement('input');
        el.type = 'hidden';
        el.name = name;
        document.getElementById('pageSettingForm').appendChild(el);
      }
      el.value = val || '';
    }
    setHidden('customize[heading1]', in_heading1.value);
    setHidden('customize[desc1]', in_desc1.value);
    setHidden('customize[heading2]', in_heading2.value);
    setHidden('customize[desc2]', in_desc2.value);

    bsCustomizeModal.hide();
  });

});

</script>
@endsection
