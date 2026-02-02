<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://kit.fontawesome.com/0f82b37480.js" crossorigin="anonymous"></script>
<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .custom-toast {
    /* z-index: 110000 !important; */
    margin-top: 110px !important;
  }
</style>


<footer class="footer">
  {{-- <div class="footer-container">
      <div class="footer-column">
        <h4>Helpful Links</h4>
        <ul>
          <li><a href="{{ route('about-us') }}">About Us</a></li>
  <li><a href="#">Contact Us</a></li>
  <li><a href="#">FAQs</a></li>
  <li><a href="#">Blog</a></li>
  </ul>
  </div>

  <div class="footer-column">
    <h4>Customer Service</h4>
    <ul>
      <li><a href="#">Shipping Info</a></li>
      <li><a href="#">Returns Policy</a></li>
      <li><a href="#">Gift Cards</a></li>
      <li><a href="#">Loyalty Program</a></li>
      <li><a href="#">Jewelry Care</a></li>
    </ul>
  </div>

  <div class="footer-column">
    <h4>Legal Information</h4>
    <ul>
      <li><a href="#">Privacy Policy</a></li>
      <li><a href="#">Terms of Use</a></li>
      <li><a href="#">Cookie Policy</a></li>
      <li><a href="#">Accessibility</a></li>
      <li><a href="#">Feedback</a></li>
    </ul>
  </div>

  <div class="footer-column">
    <h4>Connect With Us</h4>
    <div class="footer-img">
      <img src="{{ asset('assets/images/c-3.jpg') }}" alt="">
    </div>
  </div>
  </div> --}}

  <!-- BECOME A MEMBER SECTION -->
  <div class="join-container">
    <div class="join-text">
      <h2>Become a Member</h2>
      <p>Join bangles for free and discover exclusive to our biggest drops,<br> promotions, member only products and more</p>
    </div>
    <div class="join-button">
      <a href="#" class="btn">Join Now for Free</a>
    </div>
  </div>
</footer>

<!-- BOTTOM LEGAL SECTION -->
<footer class="bottom-footer">
  <div class="footer-bottom-container">
    <div class="footer-bottom-left">
      <p>© 2025 Bangles. All rights reserved.</p>
      <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Cookie Settings</a>
      </div>
    </div>
    <div class="footer-social-icons">
      <a href="#"><img src="{{ asset('assets/images/facebook.png') }}" alt=""></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-pinterest-p"></i></a>
      <a href="#"><i class="fab fa-x-twitter"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div>
  </div>
</footer>


<script>
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');

  signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
  });

  signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
  });
</script>


<script>
  const menuIcon = document.querySelector('.menu-icon');
  const sideMenu = document.querySelector('.side-menu');

  menuIcon.addEventListener('click', () => {
    sideMenu.classList.toggle('active');
  });
</script>





<script>
  document.addEventListener("DOMContentLoaded", function() {
    // ---------- Top First Nav (About, Contact, Resource) ----------
    const hoverSectionSmall = document.getElementById("hoverSection");
    const topNavItems = document.querySelectorAll(".top-first-nav .top-list ul li");
    const smallContents = hoverSectionSmall.querySelectorAll(".nav-hover-box");
    let smallTimeout;

    topNavItems.forEach((li) => {
      li.addEventListener("mouseenter", () => {
        if (li.id === "redeemGiftCardBtn") return;
        clearTimeout(smallTimeout);
        hoverSectionSmall.style.display = "block";

        // reset
        smallContents.forEach((sec) => sec.classList.remove("active"));

        const targetId = li.getAttribute("data-target");
        const targetSection = document.getElementById(targetId);
        if (targetSection) targetSection.classList.add("active");
      });
    });

    document.querySelector(".top-first-nav .top-list").addEventListener("mouseleave", () => {
      smallTimeout = setTimeout(() => {
        hoverSectionSmall.style.display = "none";
      }, 150);
    });

    hoverSectionSmall.addEventListener("mouseenter", () => {
      clearTimeout(smallTimeout);
    });
    hoverSectionSmall.addEventListener("mouseleave", () => {
      hoverSectionSmall.style.display = "none";
    });

    // ---------- Main Navbar (Categories + Appointment) ----------
    const navHover = document.querySelector(".nav-hover");
    const hoverSections = document.querySelectorAll(".hover-content");
    const mainNavItems = document.querySelectorAll(".top-navbar .nav-list ul li");
    let hideTimeout;

    mainNavItems.forEach((li) => {
      li.addEventListener("mouseenter", () => {
        clearTimeout(hideTimeout);
        navHover.style.display = "block";

        // reset
        hoverSections.forEach((sec) => sec.classList.remove("active"));

        const targetId = li.getAttribute("data-target");
        const targetSection = document.getElementById(targetId);
        if (targetSection) targetSection.classList.add("active");
      });
    });

    document.querySelector(".top-navbar .nav-list").addEventListener("mouseleave", () => {
      hideTimeout = setTimeout(() => {
        navHover.style.display = "none";
      }, 150);
    });

    navHover.addEventListener("mouseenter", () => {
      clearTimeout(hideTimeout);
    });
    navHover.addEventListener("mouseleave", () => {
      navHover.style.display = "none";
    });
  });
</script>


<script>
  const tabs = document.querySelectorAll('.tab');
  const wrappers = document.querySelectorAll('.carousel-wrapper');

  function initCarousel(wrapper) {
    const carousel = wrapper.querySelector('.carousel');
    const dotsContainer = wrapper.querySelector('.dots-container');

    if (!carousel || !dotsContainer) return;

    const scrollAmount = carousel.offsetWidth;
    const maxScrollLeft = carousel.scrollWidth - carousel.offsetWidth;
    const totalPages = Math.ceil(carousel.scrollWidth / scrollAmount);

    dotsContainer.innerHTML = '';

    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement('span');
      dot.classList.add('dot');
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => {
        carousel.scrollTo({
          left: i * scrollAmount,
          behavior: 'smooth'
        });
        setTimeout(() => updateActiveDot(i), 400);
      });
      dotsContainer.appendChild(dot);
    }

    const dots = dotsContainer.querySelectorAll('.dot');
    let lastKnownIndex = 0;

    function updateActiveDot(index) {
      dots.forEach(dot => dot.classList.remove('active'));
      if (dots[index]) dots[index].classList.add('active');
    }

    carousel.onscroll = () => {
      let index = Math.round(carousel.scrollLeft / scrollAmount + 0.1);
      index = Math.max(0, Math.min(index, totalPages - 1));
      if (index !== lastKnownIndex) {
        lastKnownIndex = index;
        updateActiveDot(index);
      }
    };

    wrapper.querySelector('.nav.prev').onclick = () => {
      const targetScroll = Math.max(0, carousel.scrollLeft - scrollAmount);
      carousel.scrollTo({
        left: targetScroll,
        behavior: 'smooth'
      });
    };
    wrapper.querySelector('.nav.next').onclick = () => {
      const targetScroll = Math.min(maxScrollLeft, carousel.scrollLeft + scrollAmount);
      carousel.scrollTo({
        left: targetScroll,
        behavior: 'smooth'
      });
    };

    wrapper.dataset.initialized = 'true';
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const selected = tab.dataset.category;
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      wrappers.forEach(wrapper => {
        const isActive = wrapper.dataset.category === selected;
        wrapper.classList.toggle('active', isActive);
        if (isActive && !wrapper.dataset.initialized) {
          initCarousel(wrapper);
        }
      });
    });
  });

  const firstActiveWrapper = document.querySelector('.carousel-wrapper.active');
  if (firstActiveWrapper && !firstActiveWrapper.dataset.initialized) {
    initCarousel(firstActiveWrapper);
  }

  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      const activeWrapper = document.querySelector('.carousel-wrapper.active');
      if (activeWrapper) {
        initCarousel(activeWrapper);
      }
    }, 200);
  });
</script>

<script>
  $(document).ready(function() {
    $('.center').slick({
      centerMode: true,
      centerPadding: '60px',
      slidesToShow: 2,
      slidesToScroll: 3,
      dots: true,
      arrows: false,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 600,
      responsive: [{
          breakpoint: 768,
          settings: {
            centerMode: false, // still center the slide
            centerPadding: '0px', // remove side gaps
            slidesToShow: 1 // only one big slide
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: false,
            centerPadding: '0px',
            slidesToShow: 1
          }
        }
      ]
    });
  });
</script>

<!-- <script>
  $(document).ready(function() {
    $('.complete-look-slider').slick({
      slidesToShow: 1.5,
      slidesToScroll: 1,
      infinite: false,
      arrows: true,
      dots: false,
      autoplay: false,
      prevArrow: '<button type="button" class="slick-prev"><</button>',
      nextArrow: '<button type="button" class="slick-next">></button>',
      responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 1.2 // smaller peek on mobile
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
  });
</script> -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("rightSidebar");
    const openBtn = document.getElementById("openSidebarBtn");
    const closeBtn = document.getElementById("closeSidebar");

    if (openBtn) {
      openBtn.addEventListener("click", function() {
        loadBundleSidebar();

        sidebar.style.right = "0";
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener("click", function() {
        sidebar.style.right = "-350px";
      });
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("rightSidebar");
    const openBtn = document.getElementById("openrRightbarBtn");
    const closeBtn = document.getElementById("closeSidebar");

    if (openBtn) {
      openBtn.addEventListener("click", function() {
        sidebar.style.right = "0";
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener("click", function() {
        sidebar.style.right = "-350px";
      });
    }
  });
</script>
<script>
  const pendingBundleUrl = "{{ route('bundle.pending') }}";
  const assetBaseUrl = "{{ asset('') }}";
  const isLoggedIn = @json(Auth::check());

  function updateRewards(subtotal) {
    const pointsValue = document.querySelector('.points-value');
    if (!pointsValue) return;

    // 10% of subtotal × 100
    const rewardPoints = Math.floor((subtotal * 0.10) * 100);
      const addToCartBtn = document.querySelector('#add-to-cart');

      if (addToCartBtn) {
    addToCartBtn.dataset.rewardPoints = rewardPoints; // raw number
  }
    pointsValue.textContent = rewardPoints.toLocaleString();
  }

  function initRewardSelection(isLoggedIn) {
    const rewardOptions = document.querySelectorAll('.reward-option');
const addToCartBtn = document.querySelector('#add-to-cart');
    rewardOptions.forEach(option => {
      option.onclick = () => {
        // alert(isLoggedIn);
        if (!isLoggedIn) {
          // 🔒 Not logged in → open modal
          const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
          modal.show();
          return;
        }

        // ✅ Logged in → reward logic
        rewardOptions.forEach(o => o.classList.remove('selected'));
        option.classList.add('selected');

        const selectedReward = option.dataset.reward;

        console.log("User selected reward:", selectedReward);
   if (addToCartBtn) {
        if (selectedReward == "points") {
          // set reward type and value
          addToCartBtn.dataset.rewardType = "points";
          addToCartBtn.dataset.rewardValue = addToCartBtn.dataset.rewardPoints || 0;
        } else if (selectedReward == "shipping") {
          addToCartBtn.dataset.rewardType = "shipping";
          addToCartBtn.dataset.rewardValue = 1; // shipping = 1
        }
      }
     };
    });
  }


  function loadBundleSidebar() {
    const isLoggedIn = @json(Auth::check());
    fetch(pendingBundleUrl)
      .then(res => res.json())
      .then(data => {
        const container = document.querySelector('.cart-item-slider');
        const progressText = document.querySelector('.progressbar-section h1 span');
        const progressBar = document.querySelector('#progress-bar-1');
        const completeMsg = document.querySelector('.complete-your-look-section p');

        const completeYourLook = document.querySelector('.complete-your-look-section');
        const rewards = document.querySelector('.complete-your-look-main');
        const rewardsOptions = document.querySelector('.complete-look-slider');
        const rewardstitle = document.querySelector('.complete-look-title');
        const subtotalSection = document.querySelector('.sub-total-section');
        const subtotalText = subtotalSection.querySelector('h1 span');
        const progressSection = document.querySelector('.progressbar-section');
        const addToCartBtn = document.querySelector('#add-to-cart');
        // NAV ICON & badge helper (paste here)
        const navIcon = document.getElementById('openSidebarBtn');
        rewardstitle.textContent = "Complete Your Look to Unlock Rewards";
        rewardsOptions.style.display = "none";

        function updateBundleBadge(n) {
          if (!navIcon) return;
          let badge = navIcon.querySelector('.bundle-count-badge');
          if (!badge) {
            badge = document.createElement('span');
            badge.className = 'bundle-count-badge';
            navIcon.appendChild(badge);
          }
          if (!n || n <= 0) {
            badge.classList.add('hidden');
            badge.textContent = '0';
          } else {
            badge.classList.remove('hidden');
            badge.textContent = String(n > 99 ? '99+' : n); // caps to 99+
          }
        }

        container.innerHTML = '';

        if (data.status == 'empty' || !data.bundle || data.bundle.bundle_products.length == 0) {
          container.innerHTML = '';
          let count = 0;
          let total = 3;
          progressText.textContent = `${count}/${total}`;
          progressBar.value = 0;
          completeMsg.textContent = `Select ${total} more eligible items to complete your bundle.`;

          completeYourLook.style.display = "block";
          rewards.style.display = "block";
          subtotalSection.style.display = "block";
          progressSection.style.display = "block";

          subtotalText.textContent = `$0.00`;

          // --- Add to cart ---
          if (addToCartBtn) {
            addToCartBtn.dataset.typeId = "";
            addToCartBtn.disabled = true;
            addToCartBtn.textContent = "Add to cart";
          }

          // --- Always show 3 look boxes ---
          const lookBoxes = completeYourLook.querySelectorAll('.item-box');
          lookBoxes.forEach((box, i) => {
            box.style.display = "flex";
            box.innerHTML = `<span class="plus">+</span> Add Item ${i + 1}`;
            box.onclick = () => window.location.href = "{{ route('home') }}";
          });

          updateBundleBadge(0);
          return;
        }


        let subtotal = 0;

        data.bundle.bundle_products.forEach(item => {
          let firstImage = (item.product.images && item.product.images.length > 0 && item.product.images[0]) ?
            `${assetBaseUrl}assets/images/products/${item.product.images[0]}` :
            `${assetBaseUrl}assets/images/c-1.jpg`;

          // --- Prices ---
          const variation = item.variation || null;

          const basePrice = variation ? variation.price : item.product.price;
          const comparePrice = variation ? variation.compare_price : item.product.compare_price;
          const memberPrice = variation ? variation.member_price : item.product.member_price;

          let effectivePrice = 0;
          let originalPrice = null;

          if (isLoggedIn) {
            if (memberPrice) {
              effectivePrice = memberPrice;
              originalPrice = basePrice || comparePrice || null;
            } else if (comparePrice) {
              effectivePrice = basePrice || comparePrice;
              originalPrice = comparePrice;
            } else if (basePrice) {
              effectivePrice = basePrice;
            }
          } else {
            if (comparePrice) {
              effectivePrice = comparePrice;
              originalPrice = basePrice || null;
            } else if (basePrice) {
              effectivePrice = basePrice;
            }
          }

          subtotal += parseFloat(effectivePrice || 0);

          container.innerHTML += `
          <div class="cart-item-card right-side-cart">
              <div class="cart-item-image">
                  <img src="${firstImage}" alt="${item.product.name}">
              </div>
              <div class="cart-item-detail">
                  <h1>${item.product.name}</h1>
                  <p>
                    $${effectivePrice}
                    ${originalPrice && originalPrice > effectivePrice
                      ? `<span style="text-decoration:line-through; color:#888; margin-left:5px;">$${originalPrice}</span>`
                      : ""}
                  </p>
              </div>
          </div>
        `;
        });


        // --- Progress ---
        let count = data.bundle.bundle_products.length;
        let total = 3;
        progressText.textContent = `${count}/${total}`;
        progressBar.value = (count / total) * 100;
        updateBundleBadge(count);
        if (completeMsg) {
          if (count < total) {
            let remaining = total - count;
            addToCartBtn.disabled = true;
            completeMsg.textContent = `Select ${remaining} more eligible item${remaining > 1 ? 's' : ''} to complete your bundle.`;
          } else {
            if (addToCartBtn) {
              addToCartBtn.dataset.typeId = data.bundle.id;
              addToCartBtn.disabled = false;
              addToCartBtn.textContent = "Add to cart";
            }
            rewardstitle.textContent = "Loyalty Rewards Program";
            rewardsOptions.style.display = "block";
            completeMsg.textContent = 'Your bundle is complete!';
          }
        }

        completeYourLook.style.display = "block";
        subtotalSection.style.display = "block";
        progressSection.style.display = "block";

        // --- Subtotal ---
        subtotalText.textContent = `$${subtotal.toFixed(2)}`;
        updateRewards(subtotal);
        initRewardSelection(isLoggedIn);
        let remaining = total - count;
        const lookBoxes = completeYourLook.querySelectorAll('.item-box');
        lookBoxes.forEach((box, i) => {
          if (i < remaining) {
            box.style.display = "flex";
            box.innerHTML = `<span class="plus">+</span> Add Item ${count + i + 1}`;
            box.onclick = () => window.location.href = "{{ route('home') }}";
          } else {
            box.style.display = "none";
          }
        });
      })
      .catch(err => console.error("Fetch error:", err));
  }
</script>
<script>
  $(document).ready(function() {
    $('.category-slider').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 1000,
      infinite: true,
      arrows: true,
      dots: false,
      prevArrow: '<button type="button" class="slick-prev"></button>',
      nextArrow: '<button type="button" class="slick-next"></button>',
      responsive: [{
          breakpoint: 991,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 557,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
  });
</script>
<script>
  // Refresh slider after tab fully visible
  $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
    $('.tab-pane.active .custom-slider').slick('setPosition');
  });
  $('.custom-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
</script>
<script>
  $(document).ready(function() {
    $('.appointment-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      infinite: true,
      arrows: true,
      dots: false,
      prevArrow: '<button type="button" class="slick-prev">‹</button>',
      nextArrow: '<button type="button" class="slick-next">›</button>',
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
  });
</script>
<script>
  $('.product-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true, // built-in prev/next arrows
    dots: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
</script>
<script>
  $('.apointment-carousel').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true, // built-in prev/next arrows
    dots: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
</script>
<script>
  const navItems = document.querySelectorAll('.top-list ul li');
  const hoverSection = document.getElementById('hoverSection');
  const contents = document.querySelectorAll('.nav-hover-box');

  navItems.forEach(item => {
    item.addEventListener('click', (e) => {
      const target = item.getAttribute('data-target');

      // show main section
      hoverSection.style.display = 'block';

      // hide all content first
      contents.forEach(c => c.classList.remove('active'));

      // show only related content
      const activeBox = document.getElementById(target);
      if (activeBox) {
        activeBox.classList.add('active');
      }
    });
  });

  // optional: hide section when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.top-first-nav') && !e.target.closest('#hoverSection')) {
      hoverSection.style.display = 'none';
      contents.forEach(c => c.classList.remove('active'));
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/chatbot.js') }}"></script>
<script>
  const bundleAddUrl = '{{ route("bundle.add") }}';

  // Reusable toast instance
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    customClass: {
      popup: 'custom-toast'
    },
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer);
      toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });

  document.addEventListener('click', function(e) {
    if (!e.target.matches('.btn-add-bundle-product')) return;

    const btn = e.target;
    const productId = btn.dataset.productId;
    const variationId = btn.dataset.variationId || ''; // 🔹 get variation_id if set

    btn.disabled = true;
    btn.textContent = 'Adding...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('product_id', productId);

    // 🔹 Only append if variationId is available
    if (variationId) {
      formData.append('variation_id', variationId);
    }

    fetch(bundleAddUrl, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: formData,
        credentials: 'same-origin'
      })
      .then(async res => {
        const data = await res.json().catch(() => ({}));
        btn.disabled = false;
        btn.textContent = 'Add to bundle';

        if (res.ok) {
          Toast.fire({
            icon: 'success',
            title: data.message || 'Product added to bundle.'
          });
          loadBundleSidebar();
        } else if (res.status === 422) {
          Toast.fire({
            icon: 'warning',
            title: data.message || 'This bundle is already complete.'
          });
        } else {
          Toast.fire({
            icon: 'error',
            title: data.message || 'Something went wrong.'
          });
        }
      })
      .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Add to bundle';
        Toast.fire({
          icon: 'error',
          title: 'Network error. Please try again.'
        });
      });
  });
</script>

<script>
  const cartAddUrl = '{{ route("cart.add") }}';
// const isLoggedIn = @json(Auth::check());
  document.addEventListener('click', function(e) {
    if (!e.target.matches('.btn-add-to-cart')) return;

    const btn = e.target;
    const type = btn.dataset.type; // "product" or "bundle"
    const typeId = btn.dataset.typeId;
    const qty = btn.dataset.qty || 1;
    const variationId = btn.dataset.variationId || null; // optional
const rewardType = btn.dataset.rewardType || null;   // "shipping" or "rewards"
  const rewardValue = btn.dataset.rewardValue || null;
  if (type == 'bundle'&& isLoggedIn && !rewardType) {
    Swal.fire({
      icon: 'warning',
      title: 'Please select a reward',
      text: 'Select a reward before submitting.',
      confirmButtonText: 'OK'
    });
    return;
  }
    btn.disabled = true;
    btn.textContent = 'Adding...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('type', type);
    formData.append('type_id', typeId);
    formData.append('qty', qty);
  if (type == 'bundle' && rewardType && isLoggedIn) {
    formData.append('reward_type', rewardType);
    formData.append('reward_value', rewardValue || 0);
  }
    // only append variation_id if it exists
    if (variationId) {
      formData.append('variation_id', variationId);
    }

    fetch(cartAddUrl, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: formData,
        credentials: 'same-origin'
      })
      .then(async res => {
        const data = await res.json().catch(() => ({}));
        btn.disabled = false;
        btn.textContent = 'Add to Cart';

        if (res.ok) {
          Toast.fire({
            icon: 'success',
            title: data.message || 'Item added to cart.'
          });
          loadCartBadge();
          if (type == 'bundle') {
            loadBundleSidebar();
          }
        } else if (res.status === 422) {
          Toast.fire({
            icon: 'warning',
            title: data.message || 'Invalid request.'
          });
        } else {
          Toast.fire({
            icon: 'error',
            title: data.message || 'Something went wrong.'
          });
        }
      })
      .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Add to Cart';
        Toast.fire({
          icon: 'error',
          title: 'Network error. Please try again.'
        });
      });
  });

  loadBundleSidebar();
function updateWishlistBadge(count) {
  const wishlistIcon = document.querySelector('.nav-icon-div.wishlist');
  if (!wishlistIcon) return;

  let badge = wishlistIcon.querySelector('.wishlist-count-badge');
  if (!badge) {
    badge = document.createElement('span');
    badge.className = 'wishlist-count-badge';
    wishlistIcon.appendChild(badge);
  }

  if (count > 0) {
    badge.textContent = count;
    badge.classList.remove('hidden');
  } else {
    badge.classList.add('hidden');
  }
}
  function updateCartBadge(count) {
    const cartIcon = document.querySelector('.nav-icon-div.cart');
    if (!cartIcon) return;

    let badge = cartIcon.querySelector('.bundle-count-badge');
    if (!badge) {
      badge = document.createElement('span');
      badge.className = 'bundle-count-badge';
      cartIcon.appendChild(badge);
    }

    if (count > 0) {
      badge.textContent = count;
      badge.classList.remove('hidden');
    } else {
      badge.classList.add('hidden');
    }
  }

  function loadCartBadge() {
    fetch("{{ route('cart.count') }}")
      .then(res => res.json())
      .then(data => {
        updateCartBadge(data.count || 0);
      })
      .catch(err => {
        console.error('Error loading cart count:', err);
      });
  }


  loadCartBadge();



function toggleWishlist(productId, $btn, variationId = null) {
    // Prevent double clicks
    if ($btn.data('loading')) return;
    $btn.data('loading', true);

    $.ajax({
    url: "{{ route('wishlist.toggle') }}",
    type: "POST",
    data: {
        product_id: productId,
        variation_id: variationId, // send variation id (or null)
        _token: "{{ csrf_token() }}",
    },
    success: function (res) {
        loadWishlistBadge();

        // ✅ Find the heart button
        const $btn = $(`.api-wishlist-button[data-product-id="${productId}"]`);

        // ✅ Update icon based on status
        if (res.status === "added") {
            $btn.attr("src", "{{ asset('assets/images/heart-filled.png') }}");
            Toast.fire({
                icon: 'success',
                title: res.message || "Added to wishlist."
            });
        } else if (res.status === "removed") {
            $btn.attr("src", "{{ asset('assets/images/heart.png') }}");
            Toast.fire({
                icon: 'info',
                title: res.message || "Removed from wishlist."
            });
        }
    },
    error: function () {
        Toast.fire({
            icon: 'error',
            title: "Something went wrong."
        });
    },
    complete: function () {
        $btn.data('loading', false);
    }
});

}

// Bind click event once
$(document).on("click", ".api-wishlist-button", function (e) {
    e.preventDefault();
    if (!isLoggedIn) {

          // 🔒 Not logged in → open modal
          const modal = new bootstrap.Modal(document.getElementById('staticBackdropWhishlist'));
          modal.show();
          return;
        }
    const $btn = $(this);
    const productId = $btn.data("product-id");

    // Try to get variation id from nearest product-options selected size
    let variationId = null;
    const $root = $btn.closest('.product-options');
    if ($root && $root.length) {
        const $sel = $root.find('.size-option.selected');
        if ($sel && $sel.length) {
            variationId = $sel.data('variation-id') || $sel.data('variationId') || $sel.data('variationid') || null;
        }
    }

    // Fallback: read from global addToCart button (you already update this on size select)
    if (!variationId) {
        variationId = $('#addToCartBtn').data('variation-id') || $('#addToCartBtn').data('variationId') || null;
    }

    // Call toggle with variationId (or null)
    toggleWishlist(productId, $btn, variationId);
});

// Load wishlist count and update nav badge
function updateWishlistBadge(count) {
  const wishlistIcon = document.querySelector('.nav-icon-div.wishlist');
  if (!wishlistIcon) return;

  let badge = wishlistIcon.querySelector('.wishlist-count-badge');
  if (!badge) {
    badge = document.createElement('span');
    badge.className = 'wishlist-count-badge';
    wishlistIcon.appendChild(badge);
  }

  if (count > 0) {
    badge.textContent = count;
    badge.classList.remove('hidden');
  } else {
    badge.classList.add('hidden');
  }
}
const productDetailBaseUrl = @json(route('product.detail', ':slug'));

function loadWishlistBadge() {
  if (!isLoggedIn) {
    updateWishlistBadge(0);
    document.getElementById('wishlist-items').innerHTML = "";
    document.querySelector('.no-wishlist-message').style.display = "block";
    return;
  }

  fetch("{{ route('wishlists.index') }}")
    .then(res => res.json())
    .then(data => {
      const count = parseInt(data.count || 0, 10);
      updateWishlistBadge(count);

      const container = document.getElementById('wishlist-items');
      const noWishlistMessage = document.querySelector('.no-wishlist-message');

      container.innerHTML = "";

      if (!data.wishlist || data.wishlist.length === 0) {
        noWishlistMessage.style.display = "block";
        return;
      } else {
        noWishlistMessage.style.display = "none";
      }

      data.wishlist.forEach(item => {
        const product = item.product;
        if (!product) return;

        // product detail url
        const productUrl = productDetailBaseUrl.replace(':slug', product.slug);

        // image (fallback if none)
        const imageUrl = product.images && product.images.length > 0
          ? `{{ asset('assets/images/products') }}/${product.images[0]}`
          : `{{ asset('assets/images/c-1.jpg') }}`;

        // ✅ Use first variation price if product has variations
        let basePrice, memberPrice, comparePrice;
        if (product.variations && product.variations.length > 0) {
          const firstVar = product.variations[0];
          basePrice = firstVar.price;
          memberPrice = firstVar.member_price;
          comparePrice = firstVar.compare_price;
        } else {
          basePrice = product.price;
          memberPrice = product.member_price;
          comparePrice = product.compare_price;
        }

        // build price HTML with same Blade logic
        let priceHtml = "";
        if (isLoggedIn) {
          if (memberPrice) {
            priceHtml = `
              <span class="text-muted text-decoration-line-through">
                $${parseFloat(basePrice).toFixed(2)}
              </span>
              <span class="fw-bold">
                $${parseFloat(memberPrice).toFixed(2)}
              </span>`;
          } else if (comparePrice) {
            priceHtml = `
              <span class="text-muted text-decoration-line-through">
                $${parseFloat(basePrice).toFixed(2)}
              </span>
              <span class="fw-bold">
                $${parseFloat(comparePrice).toFixed(2)}
              </span>`;
          } else if (basePrice) {
            priceHtml = `<span class="fw-bold">$${parseFloat(basePrice).toFixed(2)}</span>`;
          } else {
            priceHtml = `<span>N/A</span>`;
          }
        } else {
          if (comparePrice) {
            priceHtml = `
              <span class="text-muted text-decoration-line-through">
                $${parseFloat(basePrice).toFixed(2)}
              </span>
              <span class="fw-bold">
                $${parseFloat(comparePrice).toFixed(2)}
              </span>`;
          } else if (basePrice) {
            priceHtml = `<span class="fw-bold">$${parseFloat(basePrice).toFixed(2)}</span>`;
          } else {
            priceHtml = `<span>N/A</span>`;
          }
        }

        // button logic
        let buttonHtml = "";
        if (product.variations && product.variations.length > 0) {
          buttonHtml = `
            <button
              class="add-to-card"
              onclick="window.location.href='${productUrl}'">
              Add to Cart
            </button>`;
        } else {
          buttonHtml = `
            <button
              class="add-to-card btn-add-to-cart"
              data-type="product"
              data-type-id="${product.id}">
              Add to Cart
            </button>`;
        }

        // build card
        const card = document.createElement("div");
        card.classList.add("card");
        card.innerHTML = `
          <a href="${productUrl}">
            <img src="${imageUrl}" alt="${product.name}">
          </a>
          <div class="card-content">
            <h4>${product.name}</h4>
            ${priceHtml}
            ${buttonHtml}
          </div>
        `;
        container.appendChild(card);
      });
    })
    .catch(err => {
      console.error("Error loading wishlist:", err);
    });
}




// load on page ready
loadWishlistBadge();


// init on page load
  loadWishlistBadge();



</script>
