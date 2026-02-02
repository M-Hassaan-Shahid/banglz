<x-layouts.user-default>
  <x-slot name="insertstyle">
    <style>
      :root {
        --gap: 18px;
        --muted: #f6f6f7;
        --line: #e6e6e9;
        --accent: #8b6252;
      }

      .builder {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: var(--gap);
        align-items: start;
        margin-bottom: 20px;
      }

      .panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 16px;
        height: 100%;
      }

      .box-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
      }

      .slot {
        position: relative;
        border: 1px dashed var(--line);
        border-radius: 10px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }

      .slot img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 10px;
      }

      .slot .empty-label {
        color: #888;
        font-size: 13px;
      }

      .slot .remove {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        border: 0;
      }

      .pill-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
      }

      .pill {
        padding: 8px 12px;
        border-radius: 999px;
        border: 1px solid var(--line);
        background: #fff;
        cursor: pointer;
      }

      .pill.is-active {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
      }

      .swatch-bar {
        /* position: sticky; */
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 1px solid var(--line);
        padding: 12px;
        max-height: 350px;
        overflow-y: auto;
        z-index: 50;
        margin-top: 20px;
      }

      .swatch-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
      }

      .swatch-wrap {
        text-align: center;
      }

      .swatch {
        width: 100%;
        height: 100px;
        border-radius: 10px;
        border: 2px solid transparent;
        background-position: center;
        background-size: cover;
        cursor: pointer;
      }

      .swatch:hover {
        border-color: var(--accent);
      }

      .swatch-label {
        font-size: 12px;
        margin-top: 4px;
        color: #333;
      }

      .actions {
        display: flex;
        gap: 10px;
        margin-top: 12px;
      }

      .btn {
        padding: 10px 14px;
        border-radius: 8px;
        border: 0;
        cursor: pointer;
        background: var(--accent);
        color: #fff;
      }

      .btn.ghost {
        background: #fff;
        color: var(--accent);
        border: 1px solid var(--line);
      }

      @media (max-width:900px) {
        .builder {
          grid-template-columns: 1fr;
        }
      }

      .emptybox-inner-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
      }
    </style>
  </x-slot>

  <x-slot name="content">
    <div class="banglz-box-main-section">
      <h2>Build Your Bangle Box</h2>

      <form id="bangleForm" action="#">
        @csrf
        <input type="hidden" name="size" id="inputSize">
        <input type="hidden" name="box" id="inputBox">
        <div id="imageHiddenInputs"></div>

        <!-- progress -->
        <div class="progress-steps">
          <div class="progress-step is-active" data-step="1">
            <div class="progress-circle">1</div>
            <h1>Choose Size & Box</h1>
            <p>Most items are eligible for bundling — simply add your first piece to begin.</p>
          </div>
          <div class="progress-step" data-step="2">
            <div class="progress-circle">2</div>
            <h1>Select Your Bangles</h1>
            <p>Once you add your first eligible item, a “Bundle + Save” side window will open.</p>
          </div>
        </div>

        <div class="builder">
          <!-- LEFT -->
          <div class="panel box-section-empty">
            <div class="emptybox-inner-section">
              <strong>Your Selected Box</strong>
              <button type="button" id="clearAll" class="btn ghost">Clear All</button>
            </div>
            <div id="boxGrid" class="box-grid"></div>
          </div>

          <!-- RIGHT -->
          <aside class="panel">
            <div>
              <div class="small-heading">Select bangle size</div>
              <div id="sizeRow" class="pill-row mt-2">
                @foreach($sizes as $size)
                <button type="button"
                  class="pill"
                  data-id="{{ $size->id }}"
                  data-size="{{ $size->size }}">
                  {{ $size->size }}
                </button>
                @endforeach
              </div>

              <!-- <div id="sizeRow" class="pill-row mt-2">
                <button type="button" class="pill" data-size="2.4">2.4</button>
                <button type="button" class="pill" data-size="2.6">2.6</button>
                <button type="button" class="pill" data-size="2.8">2.8</button>
                <button type="button" class="pill" data-size="2.10">2.10</button>
              </div> -->
            </div>
            <div>
              <div class="small-heading">Box size</div>
              <!-- <div id="boxRow" class="pill-row">
                <button type="button" class="pill" data-box="6">6 Bangles - <small>$ 29.95 CAD</small></button>
                <button type="button" class="pill" data-box="9">9 Bangles <small>$39.95 CAD</small></button>
              </div> -->
              <div id="boxRow" class="pill-row mt-2">
                @foreach($boxSize as $box)
                <button type="button"
                  class="pill"
                  data-box="{{ $box->size }}"
                  data-id="{{ $box->id }}">
                  {{ $box->size }} Bangles -
                  <small>${{ number_format($box->price, 2) }} CAD</small>
                </button>
                @endforeach
              </div>
            </div>

            <div class="actions">
              <button type="submit" class="btn">Add to Bag</button>
            </div>
          </aside>
        </div>

        <!-- ✅ Swatch bar full width and sticky -->
        <div class="swatch-bar panel" id="swatchBar">
          <div><strong>Colors</strong></div>
          <div id="imageStrip" class="swatch-grid">
          </div>
        </div>
      </form>
    </div>
  </x-slot>

  <x-slot name="insertjavascript">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      //
      const state = {
        size: null,
        box: 6,
        slots: []
      };
      const IMAGES = [];
      const IMAGE_NAMES = [];
      // const IMAGES = [
      //   "{{ asset('assets/images/bangls/matte-peach.avif') }}",
      //   "{{ asset('assets/images/bangls/matte-dark-peach.avif') }}",
      //   "{{ asset('assets/images/bangls/Peach with Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Peach Pink with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Peach with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Light Pink.avif') }}",
      //   "{{ asset('assets/images/bangls/Light Pink with Silver Glitter.webp') }}",
      //   "{{ asset('assets/images/bangls/Pink with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Pink.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Bright Pink.avif') }}",
      //   "{{ asset('assets/images/bangls/Metallic Velvet Rose.webp') }}",
      //   "{{ asset('assets/images/bangls/Rose with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Wine with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Hot Pink with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Coral Matte.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Fuschia.avif') }}",
      //   "{{ asset('assets/images/bangls/Metallic Velvet Fuschia.webp') }}",
      //   "{{ asset('assets/images/bangls/Matte Fuchsia with Sparkles.avif') }}",
      //   "{{ asset('assets/images/bangls/Fuchsia with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Dark Purple with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Metallic Velvet Purple.webp') }}",
      //   "{{ asset('assets/images/bangls/Velvet Purple.webp') }}",
      //   "{{ asset('assets/images/bangls/Purple with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Lavender.avif') }}",
      //   "{{ asset('assets/images/bangls/Velvet Lavender.webp') }}",
      //   "{{ asset('assets/images/bangls/Light Purple with Silver Glitter.webp') }}",
      //   "{{ asset('assets/images/bangls/Matte Lilac.avif') }}",
      //   "{{ asset('assets/images/bangls/Metallic Velvet Lilac.webp') }}",
      //   "{{ asset('assets/images/bangls/Lilac with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Grape with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Grape.avif') }}",
      //   "{{ asset('assets/images/bangls/Navy Blue with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Blue.avif') }}",
      //   "{{ asset('assets/images/bangls/Blue with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Cobalt Blue.avif') }}",
      //   "{{ asset('assets/images/bangls/Cobalt Blue with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Matte Light Blue.avif') }}",
      //   "{{ asset('assets/images/bangls/Light Blue with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Teal with Gold Glitter.avif') }}",
      //   "{{ asset('assets/images/bangls/Dark Green with Gold Glitter.avif') }}"
      // ];

      // const IMAGE_NAMES = [
      //   "Matte Peach", "Matte Dark Peach", "Peach with Glitter", "Peach Pink with Gold Glitter",
      //   "Peach with Gold Glitter", "Matte Light Pink", "Light Pink with Silver Glitter", "Pink with Gold Glitter",
      //   "Matte Pink", "Matte Bright Pink", "Metallic Velvet Rose", "Rose with Gold Glitter", "Wine with Gold Glitter",
      //   "Hot Pink with Gold Glitter", "Coral Matte", "Matte Fuschia", "Metallic Velvet Fuschia",
      //   "Matte Fuchsia with Sparkles", "Fuchsia with Gold Glitter", "Dark Purple with Gold Glitter",
      //   "Metallic Velvet Purple", "Velvet Purple", "Purple with Gold Glitter", "Matte Lavender", "Velvet Lavender",
      //   "Light Purple with Silver Glitter", "Matte Lilac", "Metallic Velvet Lilac", "Lilac with Gold Glitter",
      //   "Grape with Gold Glitter", "Matte Grape", "Navy Blue with Gold Glitter", "Matte Blue", "Blue with Gold Glitter",
      //   "Matte Cobalt Blue", "Cobalt Blue with Gold Glitter", "Matte Light Blue", "Light Blue with Gold Glitter",
      //   "Teal with Gold Glitter", "Dark Green with Gold Glitter"
      // ];

      const $ = (s, r = document) => r.querySelector(s);
      const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

      function updateProgress() {
        const steps = $$(".progress-step");
        steps.forEach(s => {
          s.classList.remove("is-active", "is-completed");
        });

        if (state.size && state.box) {
          steps[0].classList.add("is-completed");
          steps[1].classList.add("is-active");
        } else {
          steps[0].classList.add("is-active");
        }
      }

      function renderBox() {
        const grid = $("#boxGrid");
        grid.innerHTML = "";
        state.slots.forEach((val, i) => {
          const el = document.createElement('div');
          el.className = 'slot';
          el.dataset.index = i;

          if (val) {
            const img = document.createElement('img');
            img.src = val;
            el.appendChild(img);
          } else {
            const lbl = document.createElement('div');
            lbl.className = 'empty-label';
            lbl.textContent = 'Empty';
            el.appendChild(lbl);
          }

          const rem = document.createElement('button');
          rem.className = 'remove';
          rem.type = 'button';
          rem.innerHTML = '&times;';
          rem.addEventListener('click', ev => {
            ev.stopPropagation();
            state.slots[i] = null;
            renderBox();
            updateProgress();
          });
          el.appendChild(rem);

          grid.appendChild(el);
        });
        updateProgress();
      }

      function renderSwatches() {
        const wrap = $("#imageStrip");
        wrap.innerHTML = "";
        IMAGES.forEach((src, i) => {
          const swatchWrap = document.createElement('div');
          swatchWrap.className = "swatch-wrap";

          const b = document.createElement('button');
          b.type = 'button';
          b.className = 'swatch';
          b.style.backgroundImage = `url("${src}")`;

          b.addEventListener('click', () => {
            const emptyIndex = state.slots.findIndex(v => v === null);
            if (emptyIndex !== -1) {
              state.slots[emptyIndex] = src;
              renderBox();
              updateProgress();
            } else {
              // alert("All slots are filled! Remove one or clear all.");
              Swal.fire({
                icon: 'warning',
                title: 'All slots are filled',
                text: 'Remove one or clear all to add another image.',
                confirmButtonText: 'OK'
              });
            }
          });

          const lbl = document.createElement('div');
          lbl.className = "swatch-label";
          lbl.textContent = IMAGE_NAMES[i] || "Image " + (i + 1);

          swatchWrap.appendChild(b);
          swatchWrap.appendChild(lbl);

          wrap.appendChild(swatchWrap);
        });
      }

      // controls
      $$("#sizeRow .pill").forEach(btn => {
        btn.addEventListener('click', () => {
          $$("#sizeRow .pill").forEach(b => b.classList.remove('is-active'));
          btn.classList.add('is-active');
          state.size = btn.dataset.size;
          $("#inputSize").value = state.size;
          updateProgress();
        });
      });

      $$("#boxRow .pill").forEach(btn => {
        btn.addEventListener('click', () => {
          $$("#boxRow .pill").forEach(b => b.classList.remove('is-active'));
          btn.classList.add('is-active');
          state.box = +btn.dataset.box;
          $("#inputBox").value = state.box;

          // 🔥 Resize slots, keep images
          if (state.slots.length > state.box) {
            state.slots = state.slots.slice(0, state.box);
          } else if (state.slots.length < state.box) {
            const diff = state.box - state.slots.length;
            state.slots = [...state.slots, ...Array.from({
              length: diff
            }, () => null)];
          }

          renderBox();
          updateProgress();
        });
      });

      $("#clearAll").addEventListener('click', () => {
        if (state.box) {
          state.slots = Array.from({
            length: state.box
          }, () => null);
          renderBox();
          updateProgress();
        }
      });

      // $("#bangleForm").addEventListener('submit', ev=>{
      //   ev.preventDefault();
      //   const cont=$("#imageHiddenInputs"); cont.innerHTML="";
      //   state.slots.forEach((val,i)=>{
      //     const inp=document.createElement('input');
      //     inp.type='hidden';
      //     inp.name=`images[${i}]`;
      //     inp.value=val||'';
      //     cont.appendChild(inp);
      //   });
      // });
      let selectedBoxId = null;
      let selectedBoxSize = null;

      // handle box selection
      document.querySelectorAll('#boxRow .pill').forEach(btn => {
        btn.addEventListener('click', () => {
          // remove active class from all
          document.querySelectorAll('#boxRow .pill').forEach(b => b.classList.remove('is-active'));
          // add active to selected
          btn.classList.add('is-active');
          // store values
          selectedBoxId = btn.dataset.id;
          selectedBoxSize = btn.dataset.box;
        });
      });


      // === FORM SUBMIT HANDLER ===
      // $("#bangleForm").addEventListener('submit', ev => {
      //   ev.preventDefault();

      //   // === check size selection ===
      //   const selectedSizeBtn = document.querySelector('#sizeRow .pill.is-active');
      //   if (!selectedSizeBtn) {
      //     Swal.fire({
      //       icon: 'warning',
      //       title: 'Please select a size',
      //       text: 'Select a size.',
      //       confirmButtonText: 'OK'
      //     });
      //     return;
      //   }

      //   // === check for empty image slots ===
      //   const emptyIndexes = state.slots
      //     .map((v, i) => (v === null || v === '' ? i : -1))
      //     .filter(i => i !== -1);

      //   if (emptyIndexes.length > 0) {
      //     Swal.fire({
      //       icon: 'warning',
      //       title: 'Please fill all image slots',
      //       html: `You have <strong>${emptyIndexes.length}</strong> empty image slot(s). Please add images to all slots before submitting.`,
      //       confirmButtonText: 'OK'
      //     });
      //     return;
      //   }

      //   // === Original hidden inputs ===
      //   const cont = $("#imageHiddenInputs");
      //   cont.innerHTML = "";
      //   state.slots.forEach((val, i) => {
      //     const inp = document.createElement('input');
      //     inp.type = 'hidden';
      //     inp.name = `images[${i}]`;
      //     inp.value = val || '';
      //     cont.appendChild(inp);
      //   });

      //   // === NEW: selected size + colors ===
      //   const selectedSizeId = selectedSizeBtn.getAttribute('data-id') || null;
      //   const selectedColors = state.slots
      //     .filter(val => val !== null && val !== '')
      //     .map(url => COLOR_LOOKUP[url] || null)
      //     .filter(id => id !== null);

      //   // === 🔥 NEW: selected box ===
      //   const selectedBoxBtn = document.querySelector('#boxRow .pill.is-active');
      //   const selectedBoxIdFinal = selectedBoxBtn ? selectedBoxBtn.getAttribute('data-id') : null;
      //   const selectedBoxSizeFinal = selectedBoxBtn ? selectedBoxBtn.getAttribute('data-box') : null;

      //   console.log('✅ Selected Size ID:', selectedSizeId);
      //   console.log('🎨 Selected Color IDs:', selectedColors);
      //   console.log('📦 Selected Box ID:', selectedBoxIdFinal);
      //   console.log('📏 Selected Box Size:', selectedBoxSizeFinal);
      //   // === 🔥 AJAX call to backend ===
      //   try {
      //     const response = await fetch(`{{ route('bangle-box.add-to-cart') }}`, {
      //       method: 'POST',
      //       headers: {
      //         'Content-Type': 'application/json',
      //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      //       },
      //       body: JSON.stringify({
      //         size_id: selectedSizeId,
      //         color_ids: selectedColors,
      //         box_id: selectedBoxIdFinal,
      //         box_size: selectedBoxSizeFinal
      //       })
      //     });

      //     const data = await response.json();

      //     if (response.ok) {
      //       Swal.fire({
      //         icon: 'success',
      //         title: 'Added to Cart',
      //         text: data.message || 'Bangle box added successfully!'
      //       });
      //     } else {
      //       Swal.fire({
      //         icon: 'error',
      //         title: 'Error',
      //         text: data.message || 'Something went wrong!'
      //       });
      //     }

      //   } catch (err) {
      //     console.error(err);
      //     Swal.fire({
      //       icon: 'error',
      //       title: 'Request Failed',
      //       text: 'Unable to add to cart. Please try again.'
      //     });
      //   }
      // });
      $("#bangleForm").addEventListener('submit', async ev => {
        ev.preventDefault();

        // === check size selection ===
        const selectedSizeBtn = document.querySelector('#sizeRow .pill.is-active');
        if (!selectedSizeBtn) {
          Swal.fire({
            icon: 'warning',
            title: 'Please select a size',
            text: 'Select a size.',
            confirmButtonText: 'OK'
          });
          return;
        }

        // === check for empty image slots ===
        const emptyIndexes = state.slots
          .map((v, i) => (v === null || v === '' ? i : -1))
          .filter(i => i !== -1);

        if (emptyIndexes.length > 0) {
          Swal.fire({
            icon: 'warning',
            title: 'Please fill all image slots',
            html: `You have <strong>${emptyIndexes.length}</strong> empty image slot(s). Please add images to all slots before submitting.`,
            confirmButtonText: 'OK'
          });
          return;
        }

        // === Hidden inputs (original logic) ===
        const cont = $("#imageHiddenInputs");
        cont.innerHTML = "";
        state.slots.forEach((val, i) => {
          const inp = document.createElement('input');
          inp.type = 'hidden';
          inp.name = `images[${i}]`;
          inp.value = val || '';
          cont.appendChild(inp);
        });

        // === Gather selected info ===
        const selectedSizeId = selectedSizeBtn.getAttribute('data-id') || null;
        const selectedColors = state.slots
          .filter(val => val !== null && val !== '')
          .map(url => COLOR_LOOKUP[url] || null)
          .filter(id => id !== null);

        const selectedBoxBtn = document.querySelector('#boxRow .pill.is-active');
        const selectedBoxIdFinal = selectedBoxBtn ? selectedBoxBtn.getAttribute('data-id') : null;
        const selectedBoxSizeFinal = selectedBoxBtn ? selectedBoxBtn.getAttribute('data-box') : null;

        console.log('✅ Selected Size ID:', selectedSizeId);
        console.log('🎨 Selected Color IDs:', selectedColors);
        console.log('📦 Selected Box ID:', selectedBoxIdFinal);
        console.log('📏 Selected Box Size:', selectedBoxSizeFinal);

        // === 🔥 AJAX call to backend ===
        try {
          const response = await fetch(`{{ route('bangle-box.add-to-cart') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
              size_id: selectedSizeId,
              color_ids: selectedColors,
              box_id: selectedBoxIdFinal,
              box_size: selectedBoxSizeFinal
            })
          });

          const data = await response.json();

          if (response.ok) {
            // Swal.fire({
            //   icon: 'success',
            //   title: 'Added to Cart',
            //   text: data.message || 'Bangle box added successfully!'
            // });
              Toast.fire({
        icon: 'success',
        title: data.message || 'Item added to cart.'
      });
      // ✅ Call global cart update
      loadCartBadge();
            if (state.box) {
        state.slots = Array.from({ length: state.box }, () => null);
        renderBox();
        updateProgress();
      }
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'Something went wrong!'
            });
          }

        } catch (err) {
          console.error(err);
          Swal.fire({
            icon: 'error',
            title: 'Request Failed',
            text: 'Unable to add to cart. Please try again.'
          });
        }
      });



      // $("#bangleForm").addEventListener('submit', ev => {
      //   ev.preventDefault();

      //   // === check for empty image slots (existing behavior) ===
      //   const emptyIndexes = state.slots
      //     .map((v, i) => (v === null || v === '' ? i : -1))
      //     .filter(i => i !== -1);

      //   if (emptyIndexes.length > 0) {
      //     Swal.fire({
      //       icon: 'warning',
      //       title: 'Please fill all image slots',
      //       html: `You have <strong>${emptyIndexes.length}</strong> empty image slot(s). Please add images to all slots before submitting.`,
      //       confirmButtonText: 'OK'
      //     });
      //     return; // do not proceed
      //   }

      //   // === check size selection: selected button will have class "is-active" ===
      //   const selectedSizeBtn = document.querySelector('#sizeRow .pill.is-active');
      //   if (!selectedSizeBtn) {
      //     Swal.fire({
      //       icon: 'warning',
      //       title: 'Please select a size',
      //       text: 'Select a size before submitting.',
      //       confirmButtonText: 'OK'
      //     });
      //     return; // do not proceed
      //   }

      //   // === Original code (unchanged) ===
      //   const cont = $("#imageHiddenInputs");
      //   cont.innerHTML = "";
      //   state.slots.forEach((val, i) => {
      //     const inp = document.createElement('input');
      //     inp.type = 'hidden';
      //     inp.name = `images[${i}]`;
      //     inp.value = val || '';
      //     cont.appendChild(inp);
      //   });

      // });



      // --- initialize defaults ---
      document.addEventListener("DOMContentLoaded", () => {
        const defaultBoxBtn = document.querySelector('#boxRow .pill[data-box="6"]');
        if (defaultBoxBtn) defaultBoxBtn.classList.add("is-active");
        state.slots = Array.from({
          length: 6
        }, () => null);
        renderBox();
        renderSwatches();
        updateProgress();
      });
    </script>
    <script>
      const SIZE_TO_ID = @json($sizes -> pluck('id', 'size'));
      const COLORS_BASE_URL = "{{ url('bangle-color') }}";
      const COLOR_LOOKUP = {}; // { "image_url": id }

      const BANGLE_BOX_ASSET_BASE = "{{ asset('assets/images/bangle-box') }}";

      (function() {
        document.querySelectorAll('#sizeRow .pill').forEach(btn => {
          btn.addEventListener('click', async () => {
            const sizeVal = btn.dataset.size;
            const id = (SIZE_TO_ID && SIZE_TO_ID[sizeVal]) ? SIZE_TO_ID[sizeVal] : (btn.dataset.id || null);

            const gallery = document.getElementById('colorGallery') || null;

            if (!id) {
              // no id found — clear gallery and swatches to avoid stale content
              if (gallery) gallery.innerHTML = '<div class="p-3 text-muted">This size is not available</div>';
              IMAGES.length = 0;
              IMAGE_NAMES.length = 0;
              if (typeof renderSwatches === 'function') renderSwatches();
              return;
            }

            if (gallery) gallery.innerHTML = '<div class="p-3">Loading colors…</div>';

            try {
              const res = await fetch(`${COLORS_BASE_URL}/${id}`);

              if (!res.ok) {
                // read error message if available
                const err = await res.json().catch(() => ({
                  error: 'This size is not available'
                }));
                const msg = err.error || err.message || 'This size is not available';

                // Clear existing swatches and gallery to avoid showing stale products
                IMAGES.length = 0;
                IMAGE_NAMES.length = 0;
                if (typeof renderSwatches === 'function') renderSwatches();

                if (gallery) gallery.innerHTML = `<div class="p-3 text-danger">${msg}</div>`;
                return;
              }

              const colors = await res.json();

              if (!Array.isArray(colors) || colors.length === 0) {
                // Clear existing swatches and show the "not available" message
                IMAGES.length = 0;
                IMAGE_NAMES.length = 0;
                if (typeof renderSwatches === 'function') renderSwatches();

                if (gallery) gallery.innerHTML = '<div class="p-3 text-muted">This size is not available</div>';
                return;
              }

              // populate arrays (mutate in-place so your code keeps working)
              IMAGES.length = 0;
              IMAGE_NAMES.length = 0;

              colors.forEach(c => {
                if (!c.image) return;
                const fullUrl = `${BANGLE_BOX_ASSET_BASE}/${c.image}`;
                IMAGES.push(fullUrl);
                IMAGE_NAMES.push(c.color_name || ('Image ' + (c.id || '')));
                COLOR_LOOKUP[fullUrl] = c.id; // store mapping
              });


              // refresh swatches
              if (typeof renderSwatches === 'function') renderSwatches();

              // update small gallery (non-destructive)
              if (gallery) {
                gallery.innerHTML = colors.map(c => {
                  const imageUrl = c.image ? `${BANGLE_BOX_ASSET_BASE}/${c.image}` : '{{ asset("assets/images/no-image.png") }}';
                  const name = c.color_name || '';
                  return `
              <div class="text-center" style="width:120px;">
                <a href="${imageUrl}" target="_blank">
                  <img src="${imageUrl}" alt="${name}" class="img-fluid rounded mb-1" style="width:100px;height:100px;object-fit:cover;">
                </a>
                <div style="font-size:13px;">${name}</div>
              </div>
            `;
                }).join('');
              }

            } catch (err) {
              console.error('Error loading bangle colors:', err);

              // cleanup stale swatches
              IMAGES.length = 0;
              IMAGE_NAMES.length = 0;
              if (typeof renderSwatches === 'function') renderSwatches();

              if (gallery) gallery.innerHTML = '<div class="text-danger p-3">This size is not available</div>';
            }
          });
        });
      })();
    </script>

    <script>
      document.querySelectorAll('#sizeRow .pill').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          // Check if any slots are filled
          const hasSelectedSlots = typeof state !== 'undefined' && state.slots && state.slots.some(v => v !== null && v !== '');

          if (hasSelectedSlots) {
            e.preventDefault(); // stop button default logic
            e.stopImmediatePropagation(); // 🚫 stop other click listeners (like AJAX fetch)

            const result = await Swal.fire({
              title: "Your bangle box will reset",
              text: "Changing size will clear your selected bangles. Continue?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, continue",
              cancelButtonText: "No, keep current",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
            });

            if (!result.isConfirmed) {
              // User canceled → do nothing and keep current active size
              return;
            }

            // User confirmed → clear slots and allow new size selection
            if (typeof state !== 'undefined' && state.box) {
              state.slots = Array.from({
                length: state.box
              }, () => null);
              renderBox();
              updateProgress();
            }

            // ✅ manually activate the clicked button now
            document.querySelectorAll('#sizeRow .pill').forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');

            // ✅ manually trigger your AJAX/fetch logic (since we stopped it above)
            btn.click();
          }
        }, true); // useCapture ensures this runs before the AJAX listener
      });
    </script>



  </x-slot>
</x-layouts.user-default>