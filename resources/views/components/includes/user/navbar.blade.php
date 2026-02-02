<div class="navbar-main">
    <div class="top-first-nav">
        <div class="top-list">
            <ul>
                <li data-target="about">
                    <a href="{{ url('about-us') }}?tab=About-Us">
                        About Us
                    </a>
                </li>
                <li data-target="contact">
                    <a href="{{ url('contact-us') }}">
                        Contact Us
                    </a>
                </li>
                <li data-target="resource">
                    <a href="{{ url('resource') }}">
                        Resource
                    </a>
                </li>
 <li id="redeemGiftCardBtn" style="cursor: pointer;">
    <span href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#giftCardModal">
        Redeem Gift Card
</span>
</li>


<!-- Gift Card Modal -->


            </ul>
        </div>
        <div class="discount-section">
            <a class="login-trigger" href="{{ url('login') }}">Become a Member: Rewards, Free Shipping, and Special Offers Await.</a>
        </div>



        <div class="nav-icons-section">
     
          <!-- <div class="nav-icon-div" style="top: 4px !important;">
 <a href="{{ route('gift-card.show') }}" title="Gift Cards">
            <i class="fas fa-gift" style="font-size: 20px; color: #333;"></i>
        </a>
</div> -->
            <div class="nav-icons">
                <div class="nav-icon-div" id="userDropdown">
                    <img src="{{ asset('assets/images/user.png') }}" alt="user icon" width="32">
                    {{-- <div class="user-detail-sect">
                        <div class="user-detail-sec-head">
                            <h1> User Name</h1>
                        </div>
                    </div> --}}
                    <div class="user-dropdown-menu" id="userdropdownMenu">
                        @guest
                        <!-- 👤 If user is NOT signed in -->
                        <a class="signin-btn" href="{{ route('user.login') }}">Sign In or Join</a>
                        @endguest

                        <a href="{{ url('personal-account') }}">Account</a>
                        <a href="{{ url('personal-account') }}">Purchase History</a>
                        <a href="{{ url('personal-account') }}">Points & Rewards</a>
                        <a href="{{ url('personal-account') }}">Wishlist / Saved Items</a>
                        <a href="{{ url('personal-account') }}">Manage Account</a>
                        @auth

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>

                        <form id="logout-form" action="{{ route('user.logout') }}" method="post" style="display: none;">
                            @csrf
                        </form>

                        @endauth
                    </div>
                </div>
             <div class="nav-icon-div wishlist">
        <img src="{{ asset('assets/images/heart.png') }}" alt="Wishlist" class="bundle-icone">
        <span class="wishlist-count-badge hidden">0</span>
</div>

                <div class="nav-icon-div cart">
                    <a href="{{ route('cart') }}">
                        <img src="{{ asset('assets/images/bag.png') }}" alt="Cart" class="bundle-icone">
                        <span class="bundle-count-badge hidden">0</span>
                    </a>
                </div>




                <div class="nav-icon-div" id="openSidebarBtn">
                    <img class="bundle-icone" src="{{ asset('assets/images/bundle.png') }}" alt="missing icon">
                </div>
            </div>
        </div>

    </div>
    <div class="top-nav-list-hover" id="hoverSection">
        <div class="nav-hover-box" id="about">
            <ul>
                <li>
                    <a href="{{ url('about-us') }}?tab=Size-Guide">Size Guide</a>
                </li>
                <li>
                    <a href="{{ url('about-us') }}?tab=blogs">Blogs</a>
                </li>
            </ul>
        </div>
        <div class="nav-hover-box" id="contact">
            <ul>
                <li>
                    <a href="{{ url('contact-us') }}">
                        Contact Form
                    </a>
                </li>
                <li>
                    <a href="{{ url('contact-us') }}">
                        FAQS
                    </a>
                </li>
            </ul>
        </div>
        <div class="nav-hover-box" id="resource">
            <ul>
                <li>
                    <a href="{{ url('resource') }}?tab=policy">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=terms">
                        Terms of Use
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=cookies">
                        Cookie Policy
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=accessibility">
                        Accessibility
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=feedback">
                        Feedback
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=shipping">
                        Shipping
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=returns">
                        Returns
                    </a>
                </li>
                <li>
                    <a href="{{ url('resource') }}?tab=jewelry-care">
                        Jewelry Care
                    </a>
                </li>

            </ul>
        </div>
        
    </div>
    <div class="top-navbar">
        <div class="nav-logo-main">
            <div class="menu-icon">
                <img src="{{ asset('assets/images/menu.png') }}" alt="missing icon" />
            </div>
            <div class="nav-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo-image">
                </a>
            </div>
        </div>

        {{-- Main Menu --}}
        <div class="nav-list">
            <ul>

                {{-- Loop all main categories dynamically --}}
                @foreach ($categories as $category)
                <li class="" data-target="{{ strtolower($category->slug) }}">
                    <a>{{ strtoupper($category->name) }}</a>
                </li>
                @endforeach
                <li data-target="static-trending">
                    <a>TRENDING</a>
                </li>
                <li data-target="appointment">
                    <a href="{{ url('/appointment') }}">APPOINTMENT</a>
                </li>
            </ul>
        </div>

        {{-- Icons --}}
        <div class="nav-icons-section">

            <form action="{{ route('search') }}" method="GET" class="search-container">
                <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                    <img class="search-icon" src="{{ asset('assets/images/search.png') }}" alt="icon missing" />
                </button>
                <input type="text" name="q" class="search-input" placeholder="Search..." required>
            </form>

        </div>
    </div>

    {{-- Hover Section --}}
    <div class="nav-hover">
        @if(count($categories) > 0)
        <div class="hover-content" id="shop-all">
            <div class="row">
                @php
                $allSubcategories = $categories->flatMap(function ($category) {
                return $category->subcategories;
                });
                @endphp

                @forelse ($allSubcategories as $sub)
                <div class="col-4 mb-3">
                    <a href="{{ url('category/' . $sub->slug) }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                @php
                                $img = $sub->images[0] ?? 'default.jpg';
                                @endphp
                                <img src="{{ asset('assets/images/categories/' . $img) }}" alt="{{ $sub->name }}">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>{{ $sub->name }}</h1>
                                <p>{{ $sub->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                @empty
                <div class="col-12">
                    <p>No subcategories found.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endif
        @foreach ($categories as $category)
        <div class="hover-content" id="{{ strtolower($category->slug) }}">
            <div class="row">
                @forelse ($category->subcategories as $sub)
                <div class="col-4 mb-3">
                    <a href="{{ route('shop-all', ['slug' => $category->slug, 'subcategory' => $sub->slug]) }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                @php
                                $img = $sub->images[0] ?? 'default.jpg';
                                @endphp
                                <img src="{{ asset('assets/images/categories/' . $img) }}" alt="{{ $sub->name }}">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>{{ $sub->name }}</h1>
                                <p>{{ $sub->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <p>No subcategories found.</p>
                </div>
                @endforelse

                {{-- ✅ Extra col at the end for Shop All --}}
                @if ($category->subcategories && $category->subcategories->count() > 0)
                <div class="col-4 mb-3">
                    <a class="shop-all-main" href="{{ route('shop-all', ['slug' => $category->slug]) }}">
                        <button class="get-started-btn">Shop All</button>
                    </a>
                </div>
                @endif
            </div>

        </div>
        @endforeach
      <div class="hover-content" id="static-trending">
            <div class="row">
                <div class="col-4 mb-3">
                    <a href="{{ route('gift-card.show') }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                <img src="{{ asset('assets/images/gift-box.png') }}" alt="Gift Card">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>GIFT SET</h1>
                                <p>Virtual Gift Cards</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="hover-content" id="appointment">
            <div class="row">
                @php
                    $appointmentsPage = \App\Models\PageSetting::where('page_type', 'appointments')->first();
                    $appointmentsList = [];
                    if ($appointmentsPage && isset($appointmentsPage->meta_data['appointments'])) {
                        $appointmentsList = $appointmentsPage->meta_data['appointments'];
                        // Filter out empty appointments
                        $appointmentsList = array_filter($appointmentsList, function($apt) {
                            return !empty($apt['title']) && !empty($apt['description']);
                        });
                    }
                @endphp
                
                @forelse($appointmentsList as $appointment)
                <div class="col-4 mb-3">
                    <a href="{{ $appointment['link'] ?? url('/appointment') }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                <img src="{{ asset('assets/images/' . ($appointment['image'] ?? 'ear.jpg')) }}" alt="{{ $appointment['title'] ?? 'Appointment' }}">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>{{ strtoupper($appointment['title'] ?? '') }}</h1>
                                <p>{{ $appointment['description'] ?? '' }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                {{-- Fallback if no appointments --}}
                <div class="col-4 mb-3">
                    <a href="{{ url('/appointment') }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                <img src="{{ asset('assets/images/ear.jpg') }}" alt="Virtual Appointment">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>VIRTUAL APPOINTMENT</h1>
                                <p>Book a virtual styling session from home</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{ url('/appointment') }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                <img src="{{ asset('assets/images/ear.jpg') }}" alt="In-Person Appointment">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>IN-PERSON APPOINTMENT</h1>
                                <p>Visit our store for personalized consultation</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{ url('/appointment') }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                <img src="{{ asset('assets/images/ear.jpg') }}" alt="Custom Design">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>CUSTOM DESIGN</h1>
                                <p>Create your unique jewelry piece</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{ url('/appointment') }}">
                        <div class="nav-hover-list">
                            <div class="nav-hover-img">
                                <img src="{{ asset('assets/images/ear.jpg') }}" alt="Bridal Consultation">
                            </div>
                            <div class="nav-hover-detail">
                                <h1>BRIDAL CONSULTATION</h1>
                                <p>Special styling for your big day</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Side Menu --}}
    <div class="side-menu">
        <div class="nav-list side-nav-list">


            <ul id="categories-list">
                @foreach ($categories as $category)
                <li class="category-item {{ $loop->first ? 'active-list' : '' }}" data-category-id="{{ $category->id }}">
                    <a href="javascript:void(0);">{{ strtoupper($category->name) }}</a>

                    @if (!empty($category->subcategories) && count($category->subcategories) > 0)
                    <ul class="subcategories" style="{{ $loop->first ? '' : 'display:none;' }}">
                        @foreach ($category->subcategories as $subcategory)
                        <li>{{ strtoupper($subcategory->name) }}</li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
                <li class="category-item" data-category-id="static-appointment">
                    <a href="javascript:void(0);">APPOINTMENT</a>
                    <ul class="subcategories" style="display:none;">
                        <li>NEW APPOINTMENT</li>
                        <li>UPCOMING APPOINTMENTS</li>
                        <li>PAST APPOINTMENTS</li>
                    </ul>
                </li>
                <li class="category-item" data-category-id="about-appointment">
                    <a href="{{ url('about-us') }}?tab=About-Us">About Us</a>
                </li>
                <li class="category-item" data-category-id="contact-appointment">
                    <a href="{{ url('contact-us') }}">Contact Us</a>
                </li>
                <li class="category-item" data-category-id="resource-appointment">
                    <a href="{{ url('resource') }}">Resource</a>
                </li>
            </ul>





        </div>
    </div>




    {{-- right bar --}}
    <div id="rightSidebar" class="right-side-bar">
        <div class="right-side-head">
            <h1>Bundle + Save</h1>
            <img id="closeSidebar" src="{{ asset('assets/images/cros.png') }}" alt="" />
        </div>
        <div class="progressbar-section">
            <h1>Bundle progress <span>0/3</span></h1>
            <progress id="progress-bar-1" value="0" max="100">0 %</progress>
        </div>

        <div class="cart-item-main">
            <h1>Items In Your Cart</h1>
            <div class="cart-item-slider">
            </div>
        </div>


        {{-- complete your look --}}

        <div class="complete-your-look-section">
            <h2>Complete your Look</h2>
            <p></p>

            <div class="item-box"></div>
            <div class="item-box"></div>
            <div class="item-box"></div>
        </div>


        {{-- rewad --}}
        <div class="complete-your-look-main">
            <h1 class="complete-look-title">Complete Your Look to Unlock Rewards</h1>
            <!-- <p>Get 5 points for every $1 you spend!</p> -->
            <div class="complete-look-slider" style="display: none;">
                <div class="product-card reward-option" data-reward="points">
                    <div class="product-card-img complete-look-img">
                        <img src="{{ asset('assets/images/benifit-1.svg') }}" alt="">
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">Claim <span class="points-value">0</span> points</h3>
                        <p class="product-desc">100 points = $1</p>
                    </div>
                </div>
                <div class="product-card reward-option" data-reward="shipping" style="display: none !important;">
                    <div class="product-card-img complete-look-img">
                        <img src="{{ asset('assets/images/benifit-3.svg') }}" alt="">
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">Free Shipping</h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="sub-total-section">
            <h1>Subtotal <span>$0.00</span></h1>
            <button id="add-to-cart" class="add-to-cart-btn right-side-add btn-add-to-cart" data-type="bundle" data-type-id="">
                Add to cart
            </button>
        </div>



    </div>









<div class="modal fade" id="giftCardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="giftCardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="giftCardModalLabel">Redeem Gift Card</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="giftCodeInput" class="form-label">Gift Card Code</label>
                    <input type="text" id="giftCodeInput" class="form-control" placeholder="Enter your gift card code">
                </div>
                <div id="giftCardResult" class="mt-3 text-center"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="checkGiftCodeBtn">Check</button>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Login to collect rewards</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please login or sign up to start collecting rewards.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('user.login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="staticBackdropWhishlist" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropWhishlistLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropWhishlistLabel">Login to add to wishlist</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please login or sign up to add items to your wishlist.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('user.login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>

    </div>
<div class="modal fade" id="notifyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="notifyModalLabel">Add Email for Notification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="notifyForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Enter your email</label>
                        <input type="email"
                               class="form-control"
                               id="email"
                               name="email"
                               value="@auth {{ auth()->user()->email }} @endauth"
                               placeholder="example@email.com"
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="notifyForm" class="btn btn-primary">Subscribe</button>
            </div>
        </div>
    </div>
</div>

</div>
<script>
    document.getElementById("userDropdown").addEventListener("click", function(event) {
        document.getElementById("userdropdownMenu").classList.toggle("show");
        event.stopPropagation();
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function() {
        document.getElementById("userdropdownMenu").classList.remove("show");
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Set <a> width to 100%
        document.querySelectorAll('#categories-list .category-item > a').forEach(link => {
            link.style.display = 'block';
            link.style.width = '100%';
        });

        // Handle click to toggle active-list and subcategories
        document.querySelectorAll('#categories-list .category-item > a').forEach(link => {
            link.addEventListener('click', function() {
                const li = this.parentElement;
                const subList = li.querySelector('.subcategories');

                // Remove active-list from all category items and hide all subcategories
                document.querySelectorAll('#categories-list .category-item').forEach(item => {
                    item.classList.remove('active-list');
                    const sub = item.querySelector('.subcategories');
                    if (sub) sub.style.display = 'none';
                });

                // Add active-list to clicked category and show subcategories
                li.classList.add('active-list');
                if (subList) {
                    subList.style.display = 'block';
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.category-slider').slick({
            slidesToShow: 4, // show 4 cards at once
            slidesToScroll: 1, // scroll one card per click
            infinite: true, // loop
            arrows: true, // show next/prev arrows
            dots: false, // no dots
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
<!-- <script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById('giftCardModal');
    const openBtn = document.getElementById('redeemGiftCardBtn');
    const closeBtn = modal.querySelector('.close-modal');
    const checkBtn = document.getElementById('checkGiftCodeBtn');
    const resultDiv = document.getElementById('giftCardResult');

    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        resultDiv.innerHTML = '';
        document.getElementById('giftCodeInput').value = '';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });

    checkBtn.addEventListener('click', async () => {
        const code = document.getElementById('giftCodeInput').value.trim();
        if (!code) {
            resultDiv.innerHTML = `<p style="color:red;">Please enter a gift card code.</p>`;
            return;
        }

        resultDiv.innerHTML = `<p>Checking...</p>`;
        try {
            const response = await fetch(`{{ route('giftcards.check') }}?code=${encodeURIComponent(code)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });
            const data = await response.json();

            if (!data.valid) {
                resultDiv.innerHTML = `<p style="color:red;">${data.message}</p>`;
            } else {
                resultDiv.innerHTML = `
                    <div style="text-align:left; margin-top:10px;">
                        <p><strong>Code:</strong> ${data.code}</p>
                        <p><strong>Total Amount:</strong> $${data.total_amount}</p>
                        <p><strong>Remaining:</strong> $${data.remaining_amount}</p>
                    </div>
                `;
            }
        } catch (err) {
            console.error(err);
            resultDiv.innerHTML = `<p style="color:red;">Something went wrong. Try again later.</p>`;
        }
    });
});
</script> -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const checkBtn = document.getElementById('checkGiftCodeBtn');
    const resultDiv = document.getElementById('giftCardResult');
    const modal = document.getElementById('giftCardModal');
    const input = document.getElementById('giftCodeInput');

    checkBtn.addEventListener('click', async () => {
        const code = input.value.trim();
        if (!code) {
            resultDiv.innerHTML = `<p class="text-danger">Please enter a gift card code.</p>`;
            return;
        }

        resultDiv.innerHTML = `<p>Checking...</p>`;
        try {
            const response = await fetch(`{{ route('giftcards.check') }}?code=${encodeURIComponent(code)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });
            const data = await response.json();

            if (!data.valid) {
                resultDiv.innerHTML = `<p class="text-danger">${data.message}</p>`;
            } else {
    const usedAmount = (data.total_amount - data.remaining_amount).toFixed(2);

    resultDiv.innerHTML = `
        <div class="text-start border rounded p-3 bg-light">
            <p><strong>Code:</strong> ${data.code}</p>
            <p><strong>Total Amount:</strong> $${data.total_amount}</p>
            <p><strong>Used:</strong> $${usedAmount}</p>
            <p><strong>Remaining:</strong> $${data.remaining_amount}</p>
        </div>
    `;
}

        } catch (err) {
            console.error(err);
            resultDiv.innerHTML = `<p class="text-danger">Something went wrong. Try again later.</p>`;
        }
    });

    // Optional: Clear result when modal closes
    modal.addEventListener('hidden.bs.modal', () => {
        resultDiv.innerHTML = '';
        input.value = '';
    });
});
</script>
