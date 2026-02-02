<x-layouts.user-default>
    <x-slot name="insertstyle">
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper top-paddings-set">
            <div class="apoint-hero-section">
                <div class="appoint-hero-content">
                    <div class="apoint-left-sec">
                        <img src="{{ asset('assets/images/6.jpg') }}" alt="missing"/>
                    </div>
                    <div class="apoint-right-sec">
                        <h1>
                            BOOK YOUR COMPLEMENTARY STYLING APPOINTMENT
                        </h1>
                        <p>Whether you need some golden advice or a whole new look, our stylists are here to help you step up your stack.</p>
                    </div>
                </div>
            </div>


            <div class="apointment-servies">
                <div class="apointment-carousel">
                    <div class="appointment-card">
                        <img src="{{ asset('assets/images/6.jpg') }}" alt="Service promotional image">
                        <div class="appointment-content">
                        <h2>1:1 Service</h2>
                        <p>
                            This uninterrupted time is all about you. Whether shopping for yourself,
                            your big day, or someone special we’ll deep dive into your needs and wants
                            to nail down the perfect pieces for any Occasion.
                        </p>
                        </div>
                    </div>
                    <div class="appointment-card">
                        <img src="{{ asset('assets/images/6.jpg') }}" alt="Service promotional image">
                        <div class="appointment-content">
                        <h2>Personalized & Curated Styling</h2>
                        <p>
                           Explore our full collection and receive special tips on stacking all the styles you are eyeing with the 360 degree view. Plus we will show you how to care for your pieces properly, so they last.
                        </p>
                        </div>
                    </div>
                    <div class="appointment-card">
                        <img src="{{ asset('assets/images/6.jpg') }}" alt="Service promotional image">
                        <div class="appointment-content">
                        <h2>Complimentary</h2>
                        <p>
                            We have got you covered. There are no hidden cost or spending limits. All you have to do is show up ready to explore and ask questions, and we’ll take care of the rest.
                        </p>
                        </div>
                    </div>
                    <div class="appointment-card">
                        <img src="{{ asset('assets/images/6.jpg') }}" alt="Service promotional image">
                        <div class="appointment-content">
                        <h2>1:1 Service</h2>
                        <p>
                            This uninterrupted time is all about you. Whether shopping for yourself,
                            your big day, or someone special we’ll deep dive into your needs and wants
                            to nail down the perfect pieces for any Occasion.
                        </p>
                        </div>
                    </div>
                </div>

            </div>



            {{--  --}}
            <div class="book-appointment-main">
                <div class="appointment-container container">
                        <h1 class="page-title">Book an Appointment</h1>
                        <p class="section-text">
                        We offer virtual and in-store styling appointments at your convenience. <br>
                        Our styling appointments are currently only available at selected stores.
                        </p>

                        <!-- In-Store Styling -->
                        <h2 class="section-title">In-Store Styling</h2>
                        <p class="section-text">
                        Need help curating your perfect stack? Book a complimentary styling appointment for a personalized experience including product recommendations and advice on ways to layer them. Walk-ins are available based on availability.
                        </p>
                        <ul class="list">
                        <li>Approximately 30 minutes</li>
                        <li>Complimentary</li>
                        </ul>
                        <button class="add-to-cart-btn booking-btn">Book Appointment</button>

                        <!-- Virtual Styling -->
                        <h2 class="section-title">Virtual Styling</h2>
                        <p class="section-text">
                        Need help curating your perfect stack? Book a complimentary styling appointment for a personalized experience including product recommendations and advice on ways to layer them. Walk-ins are available based on availability.
                        </p>
                        <ul class="list">
                        <li>Approximately 30 minutes</li>
                        <li>Complimentary</li>
                        </ul>
                        <button class="add-to-cart-btn booking-btn">Book Appointment</button>

                        <!-- Virtual Styling Simplified -->
                        <div class="apointment-card" >
                            <h2 class="apointment-card-title">Virtual Styling, Simplified</h2>
                            <p class="apointment-card-subtitle">
                                Receive a fully curated jewelry look tailored to your event and outfit — no meeting, no pressure. Just styling delivered straight to you.
                            </p>

                            <div class="steps appoint-steps">
                                <div class="step appoint-step">
                                <div class="step-number">1</div>
                                <h3 class="step-title">Share your info</h3>
                                <p class="step-text">Let us know how to reach you — this ensures our stylists can follow up with personal advice or confirmations to tailor your look.</p>
                                </div>
                                <div class="step appoint-step">
                                <div class="step-number">2</div>
                                <h3 class="step-title">Tell us about your look</h3>
                                <p class="step-text">The more details you give us about your style and the occasion, the more accurate and creative your final look will be.</p>
                                </div>
                                <div class="step appoint-step">
                                <div class="step-number">3</div>
                                <h3 class="step-title">Upload your outfit</h3>
                                <p class="step-text">Snap your full outfit and share it so we can match complementary jewelry pieces that elevate your entire look.</p>
                                </div>
                                <div class="step appoint-step">
                                <div class="step-number">4</div>
                                <h3 class="step-title">Pick a delivery date</h3>
                                <p class="step-text">You’ll choose the day you want to receive your final curated style — we’ll handle the rest.</p>
                                </div>
                            </div>

                            <a href="#" class="cta-btn start-virtual">Start Your Virtual Styling Session</a>
                        </div>





                    <div class=" form-container hidden-form" >
                        <!-- Stepper -->
                        <div class="stepper">
                            <div class="form-step" id="stepper-1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Share Info</div>
                            </div>
                            <div class="form-step" id="stepper-2">
                            <div class="step-circle">2</div>
                            <div class="step-label">Your Look</div>
                            </div>
                            <div class="form-step" id="stepper-3">
                            <div class="step-circle">3</div>
                            <div class="step-label">Upload</div>
                            </div>
                            <div class="form-step" id="stepper-4">
                            <div class="step-circle">4</div>
                            <div class="step-label">Delivery</div>
                            </div>
                        </div>
                        <form id="multiStepForm">

                            <!-- Step 1 -->
                            <div class="step-content" id="content-1">
                            <p>Let’s start with the basics. Share how we can reach you to confirm your details or answer any quick questions.</p>

                            <label>Full Name *</label>
                            <input type="text" required />

                            <label>Email *</label>
                            <input type="email" required />

                            <label>Phone *</label>
                            <input type="tel" required />

                            <label>Contact Method</label>
                            <div class="tag-group">
                                <span class="tag" onclick="toggleTag(this)">WhatsApp <small>(Preferred)</small></span>
                                <span class="tag" onclick="toggleTag(this)">Instagram</span>
                            </div>

                            <div class="appointment-form-buttons">
                                <span></span>
                                <button type="button" onclick="nextStep()">Continue →</button>
                            </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="step-content" id="content-2">
                                <p>Help us understand your event and vision. This helps us build a look that’s tailored, thoughtful, and ready for the spotlight.</p>
                            <label>What is the Occassion or event?</label>
                            <input type="text" />

                            <label>What types of jewelry do you want styles?</label>
                            <div class="tag-group">
                                <span class="tag" onclick="toggleTag(this)">Bangles</span>
                                <span class="tag" onclick="toggleTag(this)">Earrings</span>
                                <span class="tag" onclick="toggleTag(this)">Necklace</span>
                                <span class="tag" onclick="toggleTag(this)">Tikka</span>
                                <span class="tag" onclick="toggleTag(this)">Nosering</span>
                                <span class="tag" onclick="toggleTag(this)">Ring</span>
                            </div>

                            <label>Type of styling you Prefer?</label>
                            <p>
                                <input type="checkbox" id="minimal_bold" name="radio-group" checked>
                                <label class="radio-label" for="minimal_bold">Minimal</label>
                            </p>
                            <p>
                                <input type="checkbox" id="bold" name="radio-group">
                                <label class="radio-label" for="bold">Bold</label>
                            </p>
                            <p>
                                <input type="checkbox" id="traditional" name="radio-group">
                                <label class="radio-label" for="traditional">Traditional</label>
                            </p>

                            <label class="optional-label">Any specific color theme or inspiration? <span>( Optional )</span></label>
                            <input type="text" />

                            <label class="optional-label">Do you have any additional notes or details you'd like us to consider?<span>( Optional )</span></label>
                            <textarea rows="3"></textarea>

                            <div class="appointment-form-buttons apointment-buttons-two">
                                {{-- <button type="button" onclick="prevStep()">← Back</button> --}}
                                <button type="button" onclick="nextStep()">Save and Continue →</button>
                            </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="step-content" id="content-3">
                                <p>Seeing your outfit helps us match tones and proportions perfectly — so your jewelry enhances, not competes.</p>
                            <p class="instructions-head mt-3"><strong>Instructions:</strong></p>
                            <ul style="margin: 10px 0 20px 20px; color: #555;">
                                <li>Upload up to 3 outfit photos</li>
                                <li>Ensure full outfit is visible</li>
                                <li>Include accessories if possible</li>
                            </ul>

                            <div class="upload-boxes">
                                <label class="upload-box">+ Upload photo<input type="file" accept="image/*" /></label>
                                <label class="upload-box">+ Upload photo<input type="file" accept="image/*" /></label>
                                <label class="upload-box">+ Upload photo<input type="file" accept="image/*" /></label>
                            </div>

                            <div class="appointment-form-buttons apointment-buttons-two">
                                {{-- <button type="button" onclick="prevStep()">← Back</button> --}}
                                <button type="button" onclick="nextStep()">Save and Continue →</button>
                            </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="step-content" id="content-4">
                            <p style="margin-bottom: 20px;">
                                You're one step away from receiving your curated look. Choose your delivery date:
                            </p>

                           <div class="calendar-main-section">
                              <div class="calendar-header">
                                <p><strong>Pick Date</strong></p>
                                <p><strong>Duration:</strong> 30 minutes</p>
                                <p class="calendar-timezone">Your time zone: United States, Eastern Time (GMT-5:00)</p>
                             </div>

                                <div class="calendar">
                                    <div class="calendar-nav">
                                        <button type="button" id="prevMonth">
                                            <img src="{{ asset('assets/images/slide-left.png') }}" alt="">
                                        </button>
                                        <h3 id="monthYear"></h3>
                                        <button type="button" id="nextMonth">
                                            <img src="{{ asset('assets/images/slide-right.png') }}" alt="">
                                        </button>
                                    </div>

                                    <div class="calendar-grid" id="calendarGrid">
                                        <!-- Days will be generated here -->
                                    </div>
                                </div>

                                    <!-- Hidden input for selected date -->
                                    <input type="hidden" name="selected_date" id="selectedDate">
                           </div>

                                <div class="appointment-form-buttons apointment-buttons-two">
                                    {{-- <button type="button" onclick="prevStep()">← Back</button> --}}
                                    <button type="submit">Submit →</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>


            <div class="container">
                 <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>Bundle your Look. Unlock Rewards</h1>
                        <p>Select pieces marked with the Complete Your Look tag to build your perfect set.
                            Add three eligible items and unlock exclusive perks, including free styling services and more.</p>
                    </div>
                </div>
            </div>

            <div class="customize-card-main video-servies">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3 mt-3">
                                <div class="customize-card">
                                    <img src="{{ asset('assets/images/browsing.png') }}" alt="">
                                    <h1>Start Browsing</h1>
                                    <p>Items marked with a “Excluded from Bundle + Save” tag will not count toward your reward.</p>
                                    {{-- <button class="customize-card-button">
                                        Shop Now
                                    </button> --}}
                                    <div class="video-section">
                                        <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                                <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mt-3">
                                <div class="customize-card">
                                    <img src="{{ asset('assets/images/bundle.png') }}" alt="">
                                    <h1>Start building your bundle</h1>
                                    <p>Once you add your first eligible item, a “Bundle + Save” side window will open to guide your progress.</p>

                                    <div class="video-section">
                                        <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                                <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mt-3">
                                <div class="customize-card">
                                    <img src="{{ asset('assets/images/look.png') }}" alt="">
                                    <h1>Complete your Look</h1>
                                    <p>Add two more eligible items (Item 2 + Item 3). The side window will update as you go.</p>
                                    <div class="video-section">
                                        <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                                <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mt-3">
                                <div class="customize-card">
                                    <img src="{{ asset('assets/images/reward.png') }}" alt="">
                                    <h1>Choose your Reward</h1>
                                    <p>Customize your bangle within your budget and preferences.</p>
                                   <div class="video-section">
                                        <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js" data-setup='{"autoplay":"any"}'>
                                                <source src="{{asset("assets/images/product-vid.mp4")}}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="complete-look-btn">
                             <button id="openrRightbarBtn">Complete Your Look</button>
                        </div>
            </div>

                 {{-- feedback-section --}}
        <div class="userfeed-back-section">
            <h1>What our Customers Say</h1>
            
            @if (config('services.yotpo.app_key'))
                <div class="yotpo yotpo-reviews-carousel"
                     data-background-color="transparent"
                     data-mode="top_rated"
                     data-type="site"
                     data-count="8"
                     data-show-bottomline="true"
                     data-autoplay-enabled="true">
                </div>
            @else
            <div class="slider center">
                <div class="first slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first1 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first2 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first3 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first4 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
                <div class="first5 slider-card">
                    <div class="slider-main-imager">
                        <img src="{{ asset('assets/images/quates.png') }}" alt="missing">
                    </div>
                    <div class="start-images">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                        <img src="{{ asset('assets/images/star.png') }}" alt="missing">
                    </div>
                    <h1>"The customization options are simply amazing!"</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                    <div class="user-info">
                        <div class="feed-user-image">
                            <img src="{{ asset('assets/images/fake-user.png') }}" alt="missing">
                        </div>
                        <h2>Name</h2>
                    </div>
                </div>
            </div>
            @endif
        </div>







        </div>
    </x-slot>
<x-slot name="insertjavascript">

    <script>
    const formData = {};

    function showVirtualStyling() {
      document.getElementById('bookingSection').classList.add('hidden');
      document.getElementById('virtualIntro').classList.remove('hidden');
    }

    function startSteps() {
      document.getElementById('virtualIntro').classList.add('hidden');
      document.getElementById('indicator').classList.remove('hidden');
      goToStep(1);
    }

    function goToStep(step) {
      ['stepOne', 'stepTwo', 'stepThree', 'stepFour', 'summary'].forEach((id, idx) => {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(`step${idx+1}`).classList.remove('active');
      });

      // Highlight correct indicator and show form
      document.getElementById(`step${step}`).classList.add('active');
      const labels = ['One', 'Two', 'Three', 'Four'];
      document.getElementById(`step${labels[step-1]}`).classList.remove('hidden');

      // Capture data from previous steps
      if (step > 1) {
        formData.name = document.getElementById('name').value;
        formData.email = document.getElementById('email').value;
        formData.phone = document.getElementById('phone').value;
        formData.contact = document.getElementById('contactMethod').value;
      }
      if (step > 2) {
        formData.event = document.getElementById('event').value;
        formData.jewelry = Array.from(document.querySelectorAll('.tag-btn.selected')).map(b => b.textContent);
        formData.stylePreference = document.getElementById('stylePreference').value;
        formData.colorTheme = document.getElementById('colorTheme').value;
        formData.notes = document.getElementById('notes').value;
      }
    }

    function toggleTag(el) {
      el.classList.toggle('selected');
    }

    function finish() {
      formData.deliveryDate = document.getElementById('deliveryDate').value;
      document.getElementById('stepFour').classList.add('hidden');
      document.getElementById('indicator').classList.add('hidden');
      document.getElementById('summary').classList.remove('hidden');
      document.getElementById('summaryData').textContent = JSON.stringify(formData, null, 2);
    }
  </script>
<script>
  let currentStep = 1;

  function updateStepDisplay() {
    // Show only current step content
    document.querySelectorAll('.step-content').forEach((el, i) => {
      el.classList.toggle('active', i + 1 === currentStep);
    });

    // Mark all steps up to the current step as active
    document.querySelectorAll('.form-step').forEach((stepEl, i) => {
      if (i + 1 <= currentStep) {
        stepEl.classList.add('active');
      } else {
        stepEl.classList.remove('active');
      }
    });
  }

  function nextStep() {
    if (currentStep < 4) {
      currentStep++;
      updateStepDisplay();
    }
  }

  function prevStep() {
    if (currentStep > 1) {
      currentStep--;
      updateStepDisplay();
    }
  }

  function toggleTag(el) {
    el.classList.toggle("selected");
  }

  document.getElementById("multiStepForm").addEventListener("submit", function(e) {
    e.preventDefault();
    alert("Form submitted!");
  });

  // ✅ Initialize the UI
  updateStepDisplay();
</script>
<script>
document.querySelectorAll('.upload-box input[type="file"]').forEach(input => {
  input.addEventListener('change', function () {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        // Remove old preview if exists
        const oldImg = this.parentElement.querySelector('img');
        if (oldImg) oldImg.remove();

        // Hide "+ Upload photo" text
        this.parentElement.childNodes[0].textContent = "";

        // Add new image
        const img = document.createElement('img');
        img.src = e.target.result;
        this.parentElement.appendChild(img);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
});
</script>
<script>
    const monthYear = document.getElementById('monthYear');
    const calendarGrid = document.getElementById('calendarGrid');
    const hiddenInput = document.getElementById('selectedDate');

    let currentDate = new Date();

    // Render Calendar
    function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();

      // Month Names
      const monthNames = [
        "January","February","March","April","May","June",
        "July","August","September","October","November","December"
      ];

      // Set Month-Year Header
      monthYear.textContent = `${monthNames[month]} ${year}`;

      // Get first day of the month
      const firstDay = new Date(year, month, 1).getDay();
      // Get number of days in month
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      // Clear previous days
      calendarGrid.innerHTML = "";

      // Add day names
      const dayNames = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
      dayNames.forEach(d => {
        const div = document.createElement('div');
        div.textContent = d;
        div.classList.add("day-name");
        calendarGrid.appendChild(div);
      });

      // Add empty spaces for days before first day
      for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement('div');
        calendarGrid.appendChild(empty);
      }

      // Add actual days
      for (let day = 1; day <= daysInMonth; day++) {
        const div = document.createElement('div');
        div.textContent = day;
        div.classList.add("day");

        div.addEventListener('click', () => {
          // Remove old selection
          document.querySelectorAll('.day').forEach(d => d.classList.remove('selected'));
          div.classList.add('selected');

          // Update hidden input in YYYY-MM-DD format
          const selectedDate = new Date(year, month, day);
          hiddenInput.value = selectedDate.toISOString().split('T')[0];
        });

        calendarGrid.appendChild(div);
      }
    }

    // Navigation buttons
    document.getElementById('prevMonth').addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });

    // Initialize Calendar
    renderCalendar();
  </script>
<script>
  const btn = document.querySelector(".start-virtual");
  const appointment = document.querySelector(".apointment-card");
  const form = document.querySelector(".form-container");

  btn.addEventListener("click", (e) => {
    e.preventDefault();
    debugger
    appointment.classList.add("hidden-form");
    form.classList.remove("hidden-form");
  });
</script>
</x-slot>
</x-layouts.user-default>
</html>
