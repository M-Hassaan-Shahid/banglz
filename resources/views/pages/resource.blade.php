<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>

.resource-table{
    overflow-x: auto;
}
 .resource-content .resource-table-main {
    width: 100%;
}

.resource-content .resource-table-main thead tr th{
    width: 50%;
    padding-left: 20px;
}
.resource-content .resource-table-main tbody tr{
    display: flex;
    flex-direction: row;
    width: 100%;
}


.resource-content .resource-table-main tbody tr th,td{
    height: 40px;
    display: flex;
    align-items: center;
    width: 50%;
    border-bottom: 1px solid rgb(162, 161, 161);
    border-right: 1px solid rgb(162, 161, 161);
    font-size: 14px;
    padding-left: 20px;
}
@media (max-width: 991px) {
  .resource-content table tbody tr th,td{
    height: 70px;
}
}
        </style>
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper">
          <div class="product-detail-main-wrapper">
    @php
        $meta = $pageData && $pageData->meta_data ? (is_array($pageData->meta_data) ? $pageData->meta_data : json_decode($pageData->meta_data, true)) : [];
        $hero = $meta['sections']['hero'] ?? [];
        $images = isset($hero['images']) ? (is_array($hero['images']) ? $hero['images'] : [])
                 : ($pageData && $pageData->images ? (is_array($pageData->images) ? $pageData->images : (is_string($pageData->images) ? json_decode($pageData->images, true) : [])) : []);
        $heroImage = $images[0]['src'] ?? ($pageData->image ?? 'about-head.jpg');
        $heroTransform = $images[0]['transform'] ?? '';
        $heroHeading = $hero['heading'] ?? ($pageData->heading ?? 'Welcome To Contact Us');
    @endphp

    <div class="contact-hero-section editable-bg position-relative" style="height: 400px; overflow:hidden;">
        {{-- Gradient overlay --}}
        <div style="position:absolute; inset:0; background: linear-gradient(to right, rgba(255,255,255,0.9) 20%, rgba(255,255,255,0) 60%); z-index:5;"></div>

        {{-- Draggable background image --}}
        <img src="{{ asset('assets/images/pages/'.$heroImage) }}"
             class="draggable-image w-100 h-100"
             style="object-fit: cover; transform: {{ $heroTransform }}; position:absolute; top:0; left:0;"
             data-transform="{{ $heroTransform }}">

        {{-- Heading --}}
        <h1 class="position-absolute"
            style="width:30%; top:50%; left:10%; font-size: 3.5rem; transform: translateY(-50%); z-index:10; color:#a47764; font-weight:600;">
            {{ $heroHeading }}
        </h1>
    </div>
</div>


            {{-- detail about us --}}
            <div class="detai-tabs-about">
                    <ul id="myTabs" class="custom-tabs">
                        <li class="active" data-tab="policy">Privacy Policy</li>
                        <li data-tab="terms">Terms of Use</li>
                        <li data-tab="cookies-policy">Cookie Policy</li>
                        <li data-tab="accessibility">Accessibility</li>
                        <li data-tab="feedback">Feedback</li>
                        <li data-tab="shipping">Shipping</li>
                        <li data-tab="returns">Returns</li>
                        <li data-tab="jewelry-care">Jewelry Care</li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-main tab-pane active" id="policy">
                            <h1>Privacy Policy</h1>
                            <p>Banglez Privacy Policy</p>
                            <p>This Privacy Policy describes how banglez.com (the “Site” or “we”) collects, uses, and discloses your Personal Information when you visit or make a purchase from the Site.</p>
                             <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="personal-information" class="active">Collecting Personal Information</li>
                                        <li data-target="minors">Minors</li>
                                        <li data-target="share-info">Sharing Personal Information</li>
                                        <li data-target="b-advertise">Behavioural Advertising</li>
                                        <li data-target="personal-info">Using Personal Information</li>
                                        <li data-target="retention">Retention</li>
                                        <li data-target="your-rights">Your rights</li>
                                        <li data-target="cookies">Cookies</li>
                                        <li data-target="Cookies-necessary">Cookies Necessary for the Functioning of the Store</li>
                                        <li data-target="repoting">Reporting and Analytics</li>
                                        <li data-target="track">Do Not Track</li>
                                        <li data-target="changes">Changes</li>
                                        <li data-target="contact-term">Contact</li>





                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="personal-information" >
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>When you visit the Site, we collect certain information about your device, your interaction with the Site, and information necessary to process your purchases. We may also collect additional information if you contact us for customer support. In this Privacy Policy, we refer to any information that can uniquely identify an individual (including the information below) as “Personal Information”. See the list below for more information about what Personal Information we collect and why.</p>
                                            <p class="mt-3"><u>Device information</u></p>
                                            <ul class="mt-3">
                                                <li>
                                                    <strong>Examples of Personal Information collected:</strong> version of web browser, IP address, time zone, cookie information, what sites or products you view, search terms, and how you interact with the Site.</li>
                                                <li>
                                                    <strong>Purpose of collection:</strong> to load the Site accurately for you, and to perform analytics on Site usage to optimize our Site.</li>
                                                <li>
                                                    <strong>Source of collection:</strong> Collected automatically when you access our Site using cookies, log files, web beacons, tags, or pixels&nbsp;</li>
                                                <li>
                                                    <strong>Disclosure for a business purpose:</strong> shared with our processor Shopify&nbsp;</li>
                                            </ul>
                                            <p><u>Order information</u></p>
                                            <ul class="mt-3">
                                                <li>
                                                <strong>Examples of Personal Information collected:</strong> name, billing address, shipping address, payment information (including credit card numbers), email address, and phone number.</li>
                                                <li>
                                                <strong>Purpose of collection:</strong> to provide products or services to you to fulfill our contract, to process your payment information, arrange for shipping, and provide you with invoices and/or order confirmations, communicate with you, screen our orders for potential risk or fraud, and when in line with the preferences you have shared with us, provide you with information or advertising relating to our products or services.</li>
                                                <li>
                                                <strong>Source of collection:</strong> collected from you.</li>
                                                <li>
                                                <strong>Disclosure for a business purpose:</strong> shared with our processor Shopify, Canada Post, UPS, Buster Fetcher and Klaviyo.</li>
                                            </ul>
                                            <p><u>Customer support information</u></p>
                                            <ul class="mt-3">
                                                <li>
                                                <strong>Examples of Personal Information collected:</strong>&nbsp;<i>see above</i>
                                                </li>
                                                <li>
                                                <strong>Purpose of collection:</strong> to provide customer support.</li>
                                                <li>
                                                <strong>Source of collection:</strong> collected from you.</li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="side-content-tabs" id="minors" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>The Site has no age restrictions. We do not intentionally collect Personal Information from children. If you are the parent or guardian and believe your child has provided us with Personal Information, please contact us at the address below to request deletion.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="share-info" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>We share your Personal Information with service providers to help us provide our services and fulfill our contracts with you, as described above. For example:</p>
                                            <ul class="mt-3">
                                                 <li>We use Shopify to power our online store. You can read more about how Shopify uses your Personal Information here: <a href="https://www.shopify.com/legal/privacy" target="_blank">https://www.shopify.com/legal/privacy</a>.</li>
                                                 <li>We may share your Personal Information to comply with applicable laws and regulations, to respond to a subpoena, search warrant or other lawful requests for information we receive, or to otherwise protect our rights.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="b-advertise" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>As described above, we use your Personal Information to provide you with targeted advertisements or marketing communications we believe may be of interest to you. For example:</p>
                                            <ul class="mt-3">
                                                <li>We use Google Analytics to help us understand how our customers use the Site. You can read more about how Google uses your Personal Information here: <a href="https://policies.google.com/privacy?hl=en" target="_blank">https://policies.google.com/privacy?hl=en</a>.You can also opt-out of Google Analytics here: <a href="https://tools.google.com/dlpage/gaoptout" target="_blank">https://tools.google.com/dlpage/gaoptout</a>.</li>
                                                <li>We share information about your use of the Site, your purchases, and your interaction with our ads on other websites with our advertising partners. We collect and share some of this information directly with our advertising partners, and in some cases through the use of cookies or other similar technologies (which you may consent to, depending on your location).</li>
                                            </ul>
                                            <p>For more information about how targeted advertising works, you can visit the Network Advertising Initiative’s (“NAI”) educational page at <a href="http://www.networkadvertising.org/understanding-online-advertising/how-does-it-work" target="_blank">http://www.networkadvertising.org/understanding-online-advertising/how-does-it-work</a>.</p>
                                            <p>You can opt-out of targeted advertising by:</p>
                                            <ul class="mt-3">
                                                <li>
                                                <i>FACEBOOK - </i> <a href="https://www.facebook.com/settings/?tab=ads" target="_blank">https://www.facebook.com/settings/?tab=ads</a>
                                                </li>
                                                <li>
                                                <i>GOOGLE - </i> <a href="https://www.google.com/settings/ads/anonymous" target="_blank">https://www.google.com/settings/ads/anonymous</a>
                                                </li>
                                            </ul>
                                            <p>Additionally, you can opt out of some of these services by visiting the Digital Advertising Alliance’s opt-out portal at: <a href="http://optout.aboutads.info/" target="_blank">http://optout.aboutads.info/</a>.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="personal-info" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>We use your personal Information to provide our services to you, which includes: offering products for sale, processing payments, shipping and fulfillment of your order, and keeping you up to date on new products, services, and offers.</p>
                                            <p><i></i>Lawful basis</p>
                                            <p>Pursuant to the General Data Protection Regulation (“GDPR”), if you are a resident of the European Economic Area (“EEA”), we process your personal information under the following lawful bases:</p>
                                            <ul class="mt-3">
                                                <li>Your consent;</li>
                                                <li>The performance of the contract between you and the Site;</li>
                                                <li>Compliance with our legal obligations;</li>
                                                <li>To protect your vital interests;</li>
                                                <li>To perform a task carried out in the public interest;</li>
                                                <li>For our legitimate interests, which do not override your fundamental rights and freedoms.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                 <div class="side-content-tabs" id="retention" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>When you place an order through the Site, we will retain your Personal Information for our records unless and until you ask us to erase this information. For more information on your right of erasure, please see the ‘Your rights’ section below.</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="your-rights" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p><i></i>CCPA</p>
                                            <p>If you are a resident of California, you have the right to access the Personal Information we hold about you (also known as the ‘Right to Know’), to port it to a new service, and to ask that your Personal Information be corrected, updated, or erased. If you would like to exercise these rights, please contact us through the contact information below.</p>
                                            <p>If you would like to designate an authorized agent to submit these requests on your behalf, please contact us at the address below.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="cookies" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>A cookie is a small amount of information that’s downloaded to your computer or device when you visit our Site. We use a number of different cookies, including functional, performance, advertising, and social media or content cookies. Cookies make your browsing experience better by allowing the website to remember your actions and preferences (such as login and region selection). This means you don’t have to re-enter this information each time you return to the site or browse from one page to another. Cookies also provide information on how people use the website, for instance whether it’s their first time visiting or if they are a frequent visitor.</p>
                                            <p>We use the following cookies to optimize your experience on our Site and to provide our services.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="Cookies-necessary" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                            <table class="resource-table-main">

                                                <tbody>
                                                     <tr>
                                                <th><strong>Name</strong></th>
                                                <th><strong>Function</strong></th>
                                                </tr>
                                                    <tr>
                                                    <td><i>_ab</i></td>
                                                    <td>Used in connection with access to admin.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>_secure_session_id</i></td>
                                                    <td>Used in connection with navigation through a storefront.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>cart</i></td>
                                                    <td>Used in connection with shopping cart.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>cart_sig</i></td>
                                                    <td>Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>cart_ts</i></td>
                                                    <td>Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>checkout_token</i></td>
                                                    <td>Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>secret</i></td>
                                                    <td>Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>secure_customer_sig</i></td>
                                                    <td>Used in connection with customer login.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>storefront_digest</i></td>
                                                    <td>Used in connection with customer login.</td>
                                                    </tr>
                                                    <tr>
                                                    <td><i>_shopify_u</i></td>
                                                    <td>Used to facilitate updating customer account information.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="repoting" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                            <table class="resource-table-main">
                                                <tbody>
                                                <tr>
                                                <th><strong>Name</strong></th>
                                                <th><strong>Function</strong></th>
                                                </tr>
                                                <tr>
                                                <td><i>_tracking_consent</i></td>
                                                <td>Tracking preferences.</td>
                                                </tr>
                                                <tr>
                                                <td><i>_landing_page</i></td>
                                                <td>Track landing pages</td>
                                                </tr>
                                                <tr>
                                                <td><i>_orig_referrer</i></td>
                                                <td>Track landing pages</td>
                                                </tr>
                                                <tr>
                                                <td><i>_s</i></td>
                                                <td>Shopify analytics.</td>
                                                </tr>
                                                <tr>
                                                <td><i>_shopify_s</i></td>
                                                <td>Shopify analytics.</td>
                                                </tr>
                                                <tr>
                                                <td><i>_shopify_sa_p</i></td>
                                                <td>Shopify analytics relating to marketing &amp; referrals.</td>
                                                </tr>
                                                <tr>
                                                <td><i>_shopify_sa_t</i></td>
                                                <td>Shopify analytics relating to marketing &amp; referrals.</td>
                                                </tr>
                                                <tr>
                                                <td><i>_shopify_y</i></td>
                                                <td>Shopify analytics.</td>
                                                </tr>
                                                <tr>
                                                <td><i>_y</i></td>
                                                <td>Shopify analytics.</td>
                                                </tr>
                                                </tbody>
                                                </table>

                                                <p>We also use Klaviyo analytics. The length of time that a cookie remains on your computer or mobile device depends on whether it is a “persistent” or “session” cookie. Session cookies last until you stop browsing and persistent cookies last until they expire or are deleted. Most of the cookies we use are persistent and will expire between 30 minutes and two years from the date they are downloaded to your device.</p>
                                                <p>You can control and manage cookies in various ways. Please keep in mind that removing or blocking cookies can negatively impact your user experience and parts of our website may no longer be fully accessible.</p>
                                                <p>Most browsers automatically accept cookies, but you can choose whether or not to accept cookies through your browser controls, often found in your browser’s “Tools” or “Preferences” menu. For more information on how to modify your browser settings or how to block, manage or filter cookies can be found in your browser’s help file or through such sites as <a href="www.allaboutcookies.org" target="_blank">www.allaboutcookies.org</a>.</p>
                                                <p>Additionally, please note that blocking cookies may not completely prevent how we share information with third parties such as our advertising partners. To exercise your rights or opt-out of certain uses of your information by these parties, please follow the instructions in the “Behavioural Advertising” section above.</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="track" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Please note that because there is no consistent industry understanding of how to respond to “Do Not Track” signals, we do not alter our data collection and usage practices when we detect such a signal from your browser.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="changes" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>We may update this Privacy Policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal, or regulatory reasons.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="contact-term" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>For more information about our privacy practices, if you have questions, or if you would like to make a complaint, please contact us by e-mail at&nbsp;<i>info@banglez.com</i> or by mail using the details provided below:</p>
                                            <p>Banglez Jewelry Inc, 358 Glenashton Drive, Oakville ON L6H 4V9, Canada</p>
                                            <i><i>Last updated: November 1st, 2021</i></i>
                                            <p>If you are not satisfied with our response to your complaint, you have the right to lodge your complaint with the relevant data protection authority. You can contact your local data protection authority, or our supervisory authority here:</p>
                                            <p><i></i><i>info@banglez.com</i></p>
                                            <p><i>(416) 834 -6717</i><br></p>
                                            <p><i><i>Banglez Compliance Officer</i></i></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-main tab-pane" id="terms">
                            <h1>Terms of service</h1>
                            <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="overview" class="active">OVERVIEW</li>
                                        <li data-target="online-store-term">SECTION 1 - ONLINE STORE TERMS</li>
                                        <li data-target="general-condition">SECTION 2 - GENERAL CONDITIONS</li>
                                        <li data-target="timeless-info">SECTION 3 - ACCURACY, COMPLETENESS AND TIMELINESS OF INFORMATION</li>
                                        <li data-target="service-price">SECTION 4 - MODIFICATIONS TO THE SERVICE AND PRICES</li>
                                        <li data-target="product-service">SECTION 5 - PRODUCTS OR SERVICES (if applicable)</li>
                                        <li data-target="account-info">SECTION 6 - ACCURACY OF BILLING AND ACCOUNT INFORMATION</li>
                                        <li data-target="optional-tool">SECTION 7 - OPTIONAL TOOLS</li>
                                        <li data-target="third-party">SECTION 8 - THIRD-PARTY LINKS</li>
                                        <li data-target="comment-feedback">SECTION 9 - USER COMMENTS, FEEDBACK AND OTHER SUBMISSIONS</li>
                                        <li data-target="sec-10-personal">SECTION 10 - PERSONAL INFORMATION</li>
                                        <li data-target="errors">SECTION 11 - ERRORS, INACCURACIES AND OMISSIONS</li>
                                        <li data-target="prohibited">SECTION 12 - PROHIBITED USES</li>
                                        <li data-target="waranties">SECTION 13 - DISCLAIMER OF WARRANTIES; LIMITATION OF LIABILITY</li>
                                        <li data-target="identification">SECTION 14 - INDEMNIFICATION</li>
                                        <li data-target="SEVERABILITY">SECTION 15 - SEVERABILITY</li>
                                        <li data-target="TERMINATION">SECTION 16 - TERMINATION</li>
                                        <li data-target="AGREEMENT">SECTION 17 - ENTIRE AGREEMENT</li>
                                        <li data-target="GOVERNING">SECTION 18 - GOVERNING LAW</li>
                                        <li data-target="changes-terms">SECTION 19 - CHANGES TO TERMS OF SERVICE</li>
                                        <li data-target="contact-information">SECTION 20 - CONTACT INFORMATION</li>






                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="overview" >
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Banglez operates this website. Throughout the site, the terms “we”, “us” and “our” refer to Banglez. Banglez offers this website, including all information, tools and services available from this site to you, the user, conditioned upon your acceptance of all terms, conditions, policies and notices stated here. </p>
                                            <br>
                                            <p> By visiting our site and/ or purchasing something from us, you engage in our “Service” and agree to be bound by the following terms and conditions (“Terms of Service”, “Terms”), including those additional terms and conditions and policies referenced herein and/or available by hyperlink. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/ or contributors of content. </p>
                                            <br>
                                            <p> Please read these Terms of Service carefully before accessing or using our website. By accessing or using any part of the site, you agree to be bound by these Terms of Service. If you do not agree to all the terms and conditions of this agreement, then you may not access the website or use any services. If these Terms of Service are considered an offer, acceptance is expressly limited to these Terms of Service. </p>
                                            <br>
                                            <p> Any new features or tools which are added to the current store shall also be subject to the Terms of Service. You can review the most current version of the Terms of Service at any time on this page. We reserve the right to update, change or replace any part of these Terms of Service by posting updates and/or changes to our website. It is your responsibility to check this page periodically for changes. Your continued use of or access to the website following the posting of any changes constitutes acceptance of those changes. </p>
                                            <br>
                                            <p> Our store is hosted on Shopify Inc. They provide us with an online e-commerce platform that allows us to sell our products and services to you. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="online-store-term" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> By agreeing to these Terms of Service, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site. </p>
                                            <br>
                                            <p> You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws). </p>
                                            <br>
                                            <p> You must not transmit any worms or viruses or any code of a destructive nature. </p>
                                            <br>
                                            <p> A breach or violation of any of the Terms will result in an immediate termination of your Services. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="general-condition" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> We reserve the right to refuse service to anyone for any reason at any time. </p>
                                            <br>
                                            <p> You understand that your content (not including credit card information), may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to the technical requirements of connecting networks or devices. Credit card information is always encrypted during transfer over networks. </p>
                                            <br>
                                            <p> You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service or any contact on the website through which the service is provided, without express written permission by us. </p>
                                            <br>
                                            <p> The headings used in this agreement are included for convenience only and will not limit or otherwise affect these Terms. </p>
                                            <br>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="timeless-info" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p> We are not responsible if information made available on this site is not accurate, complete or current. The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions without consulting primary, more accurate, more complete or more timely sources of information. Any reliance on the material on this site is at your own risk. </p>
                                           <br>
                                            <p> This site may contain certain historical information. Historical information, necessarily, is not current and is provided for your reference only. We reserve the right to modify the contents of this site at any time, but we have no obligation to update any information on our site. You agree that it is your responsibility to monitor changes to our site. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="service-price" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> Prices for our products are subject to change without notice. </p>
                                           <br>
                                            <p> We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time. </p>
                                           <br>
                                            <p> We shall not be liable to you or to any third party for any modification, price change, suspension or discontinuance of the Service. </p>

                                        </div>
                                    </div>
                                </div>

                                 <div class="side-content-tabs" id="product-service" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> Certain products or services may be available exclusively online through the website. These products or services may have limited quantities and are subject to return or exchange only according to our Return Policy. </p>
                                            <br>
                                            <p> We have made every effort to display the colours and images of our products that appear at the store as accurately as possible. But, unfortunately, we cannot guarantee that your computer monitor’s display of any colour will be accurate. </p>
                                            <br>
                                            <p> We reserve the right but are not obligated to limit the sales of our products or Services to any person, geographic region or jurisdiction. We may exercise this right on a case-by-case basis. We reserve the right to limit the quantities of any products or services that we offer. All descriptions of products or product pricing are subject to change at any time without notice, at the sole discretion of us. We reserve the right to discontinue any product at any time. Any offer for any product or service made on this site is void where prohibited. </p>
                                            <br>
                                            <p> We do not warrant that the quality of any products, services, information, or other material purchased or obtained by you will meet your expectations, or that any errors in the Service will be corrected. </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="account-info" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel quantities purchased per person, per household or per order. These restrictions may include orders placed by or under the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the email and/or billing address/phone number provided at the time the order was made. In addition, we reserve the right to limit or prohibit orders that, in our sole judgment, appear to be placed by dealers, resellers or distributors. </p>
                                            <br>
                                            <p> You agree to provide current, complete and accurate purchase and account information for all purchases made at our store. In addition, you agree to promptly update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as needed. </p>
                                            <br>
                                            <p> For more detail, please review our Returns Policy. </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="optional-tool" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> We may provide you with access to third-party tools over which we neither monitor nor have any control nor input. </p>
                                            <br>
                                            <p> You acknowledge and agree that we provide access to such tools” as is” and “as available” without any warranties, representations or conditions of any kind and without any endorsement. We shall have no liability whatsoever arising from or relating to your use of optional third-party tools. </p>
                                            <br>
                                            <p> Any use by you of optional tools offered through the site is entirely at your own risk and discretion and you should ensure that you are familiar with and approve of the terms on which tools are provided by the relevant third-party provider(s). </p>
                                            <br>
                                            <p> We may also, in the future, offer new services and/or features through the website (including, the release of new tools and resources). Such new features and/or services shall also be subject to these Terms of Service. </p>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="third-party" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                           <p> Certain content, products and services available via our Service may include materials from third parties. </p>
                                           <br>
                                           <p> Third-party links on this site may direct you to third-party websites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any liability or responsibility for any third-party materials or websites, or for any other materials, products, or services of third parties. </p>
                                           <br>
                                           <p> We are not liable for any harm or damages related to the purchase or use of goods, services, resources, content, or any other transactions made in connection with any third-party websites. Please review the third-party’s policies and practices carefully and make sure you understand them before you engage in any transaction. Complaints, claims, concerns, or questions regarding third-party products should be directed to the third party. </p>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="comment-feedback" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                            <p> If, at our request, you send certain specific submissions (for example contest entries) or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, whether online, by email, by postal mail, or otherwise (collectively, ‘comments’), you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use in any medium any comments that you forward to us. However, we are and shall be under no obligation (1) to maintain any comments in confidence; (2) to pay compensation for any comments; or (3) to respond to any comments. </p>
                                            <br>
                                            <p> We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms of Service. </p>
                                            <br>
                                            <p> You agree that your comments will not violate any right of any third party, including copyright, trademark, privacy, personality or other personal or proprietary rights. You further agree that your comments will not contain libelous or otherwise unlawful, abusive or obscene material, or contain any computer virus or other malware that could in any way affect the operation of the Service or any related website. You may not use a false email address, pretend to be someone other than yourself, or otherwise mislead us or third parties as to the origin of any comments. You are solely responsible for any comments you make and their accuracy. We take no responsibility and assume no liability for any comments posted by you or any third party. </p>

                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="sec-10-personal" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> Your submission of personal information through the store is governed by our Privacy Policy. To view our Privacy Policy. </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="errors" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> Occasionally there may be information on our site or in the Service that contains typographical errors, inaccuracies or omissions that may relate to product descriptions, pricing, promotions, offers, product shipping charges, transit times and availability. We reserve the right to correct any errors, inaccuracies or omissions, and to change or update information or cancel orders if any information in the Service or on any related website is inaccurate at any time without prior notice (including after you have submitted your order). </p>
                                            <br>
                                            <p> We undertake no obligation to update, amend or clarify information in the Service or on any related website, including without limitation, pricing information, except as required by law. No specified update or refresh date applied in the Service or on any related website, should be taken to indicate that all information in the Service or on any related website has been modified or updated. </p>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="prohibited" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to perform or participate in any unlawful acts; (c) to violate any international, federal, provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or violate our intellectual property rights or the intellectual property rights of others; (e) to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to submit false or misleading information; (g) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet; (h) to collect or track the personal information of others; (i) to spam, phish, pharm, pretext, spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet. We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="waranties" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> We do not guarantee, represent or warrant that your use of our service will be uninterrupted, timely, secure or error-free. </p>
                                            <br>
                                            <p> We do not warrant that the results that may be obtained from the use of the service will be accurate or reliable. </p>
                                            <br>
                                            <p> You agree that from time to time we may remove the service for indefinite periods of time or cancel the service at any time, without notice to you. </p>
                                            <br>
                                            <p> You expressly agree that your use of, or inability to use, the service is at your sole risk. The service and all products and services delivered to you through the service are (except as expressly stated by us) provided ‘as is’ and ‘as available’ for your use, without any representation, warranties or conditions of any kind, either express or implied, including all implied warranties or conditions of merchantability, merchantable quality, fitness for a particular purpose, durability, title, and non-infringement. </p>
                                            <br>
                                            <p> In no case shall Banglez, our directors, officers, employees, affiliates, agents, contractors, interns, suppliers, service providers or licensors be liable for any injury, loss, claim, or any direct, indirect, incidental, punitive, special, or consequential damages of any kind, including, without limitation lost profits, lost revenue, lost savings, loss of data, replacement costs, or any similar damages, whether based in contract, tort (including negligence), strict liability or otherwise, arising from your use of any of the service or any products procured using the service, or for any other claim related in any way to your use of the service or any product, including, but not limited to, any errors or omissions in any content, or any loss or damage of any kind incurred as a result of the use of the service or any content (or product) posted, transmitted, or otherwise made available via the service, even if advised of their possibility. Because some states or jurisdictions do not allow the exclusion or the limitation of liability for consequential or incidental damages, in such states or jurisdictions, our liability shall be limited to the maximum extent permitted by law. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="identification" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> You agree to indemnify, defend and hold harmless Banglez and our parent, subsidiaries, affiliates, partners, officers, directors, agents, contractors, licensors, service providers, subcontractors, suppliers, interns and employees, harmless from any claim or demand, including reasonable attorneys’ fees, made by any third party due to or arising out of your breach of these Terms of Service or the documents they incorporate by reference or your violation of any law or the rights of a third-party. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="SEVERABILITY" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> In the event that any provision of these Terms of Service is determined to be unlawful, void or unenforceable, such provision shall nonetheless be enforceable to the fullest extent permitted by applicable law, and the unenforceable portion shall be deemed to be severed from these Terms of Service, such determination shall not affect the validity and enforceability of any other remaining provisions. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="TERMINATION" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> The obligations and liabilities of the parties incurred prior to the termination date shall survive the termination of this agreement for all purposes. </p>
                                            <br>
                                            <p> These Terms of Service are effective unless and until terminated by either you or us. You may terminate these Terms of Service at any time by notifying us that you no longer wish to use our Services, or when you cease using our site. </p>
                                            <br>
                                            <p> If in our sole judgment you fail, or we suspect that you have failed, to comply with any term or provision of these Terms of Service, we also may terminate this agreement at any time without notice and you will remain liable for all amounts due up to and including the date of termination; and/or accordingly may deny you access to our Services (or any part thereof). </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="AGREEMENT" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> The failure of us to exercise or enforce any right or provision of these Terms of Service shall not constitute a waiver of such right or provision. </p>
                                            <br>
                                            <p> These Terms of Service and any policies or operating rules posted by us on this site or in respect to The Service constitutes the entire agreement and understanding between you and us and govern your use of the Service, superseding any prior or contemporaneous agreements, communications and proposals, whether oral or written, between you and us (including, but not limited to, any prior versions of the Terms of Service). </p>
                                            <br>
                                            <p> Any ambiguities in the interpretation of these Terms of Service shall not be construed against the drafting party. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="GOVERNING" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> These Terms of Service and any separate agreements whereby we provide you Services shall be governed by and construed in accordance with the laws of Canada. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="changes-terms" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> You can review the most current version of the Terms of Service at any time at this page. </p>
                                            <br>
                                            <p> We reserve the right, at our sole discretion, to update, change or replace any part of these Terms of Service by posting updates and changes to our website. It is your responsibility to check our website periodically for changes. Your continued use of or access to our website or the Service following the posting of any changes to these Terms of Service constitutes acceptance of those changes. </p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="side-content-tabs" id="contact-information" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> Questions about the Terms of Service should be sent to us at info@banglez.com.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="tab-main tab-pane" id="cookies-policy">
                            <h1>Cookie Policy</h1>
                            <p>Last updated: September 3, 2025</p>
                            <p>This Cookie Policy explains how Banglez uses cookies and similar technologies on our website.</p>
                            <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="what-cookie" class="active">What are cookies?</li>
                                        <li data-target="cookie-use">Types of cookies we use</li>
                                        <li data-target="consent">Consent & control</li>
                                        <li data-target="manage-cookie">Managing cookies in your browser</li>
                                        <li data-target="analytics">Analytics & ads</li>
                                        <li data-target="rentention">Data retention</li>
                                        <li data-target="region-specific">Your rights & region-specific notices</li>
                                        <li data-target="update-policy-cookie">Updates to this policy</li>

                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="what-cookie">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Cookies are small text files placed on your device to make the site work, remember your preferences, and understand how you use our pages. We also use pixels and local storage for similar purposes.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="cookie-use" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>Strictly Necessary (required): Enable core functionality like navigation, security, and checkout.</p><br>
                                            <p>Performance/Analytics: Help us understand site usage to improve speed and content.</p><br>
                                            <p>Functional: Remember choices (e.g., region, language).</p><br>
                                            <p>Advertising/Targeting: Show relevant offers and measure campaign effectiveness.</p><br>
                                            <p>Social Media: Enable sharing and social features embedded on our pages.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="consent" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>When you first visit, you’ll see a cookie banner. You can:</p><br>
                                            <p>Accept all, Reject non-essential, or Customize categories.</p><br>
                                            <p>Change your choices anytime via Cookie Settings in the site footer.</p><br>
                                            <p>Withdraw consent at any time; this won’t affect the lawfulness of processing before withdrawal.</p><br>
                                            <p>We honor Global Privacy Control (GPC) signals where feasible.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="manage-cookie" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>You can block or delete cookies using your browser settings. Doing so may affect site functionality (especially checkout and account features).</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="analytics" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                          <p>We may use tools such as &lt;e.g., Google Analytics/Meta Pixel/LinkedIn Insights &gt;. These providers may set their own cookies. Where required, we obtain your consent before loading non-essential scripts. You can opt out through Cookie Settings or provider-specific tools.</p><br>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="rentention" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                          <p>Session cookies: deleted when you close your browser.</p><br>
                                          <p>Persistent cookies: stored until expiry or deletion.</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="region-specific" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Canada (PIPEDA): Contact us for questions about data handling.</p><br>
                                            <p>EU/UK (GDPR): You may withdraw consent and exercise rights like access, correction, and deletion.</p><br>
                                            <p>California (CPRA): You can opt out of “sale”/“sharing” for cross-context behavioral advertising via Do Not Sell or Share <a href="{{ url('personal-account') }}">My Personal Information</a></p><br>

                                        </div>
                                    </div>
                                </div>

                                 <div class="side-content-tabs" id="update-policy-cookie" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                        <p>We may update this policy to reflect changes to our practices or legal requirements.</p><br>
                                        <p><strong>Contact</strong></p>
                                        <p>Email: info@banglez.com</p><br>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>


                        <div class="tab-main tab-pane" id="accessibility">
                            <h1>Accessibility Statement</h1>
                            <p>Last updated: September 3, 2025</p>
                            <p>Banglez is committed to providing a website that is accessible to the widest possible audience. We aim to meet WCAG 2.2 Level AA and comply with applicable accessibility laws, including the Accessibility for Ontarians with Disabilities Act (AODA).</p>
                            <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="what-doing" class="active">What we’re doing</li>
                                        <li data-target="limitation">Known limitations</li>
                                        <li data-target="aoda">Feedback & Requests (AODA)</li>

                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="what-doing">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>Designing and testing for keyboard navigation, screen readers, sufficient color contrast, captions/alt text, and error prevention.</p><br>
                                            <p>Reviewing new features for accessibility before release and fixing issues we discover or that users report.</p><br>
                                            <p>Offering accessible formats and communication supports on request, at no additional charge and within a reasonable timeframe.</p><br>

                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="limitation" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>If you encounter an accessibility barrier on our site, please tell us. We’ll acknowledge your message within 2 business days and aim to resolve issues promptly, prioritizing critical barriers.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="aoda" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>Email: info@banglez.com</p>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>


                         <div class="tab-main tab-pane" id="feedback">
                            <h1>Feedback</h1>
                            <p>Last updated: September 3, 2025</p>
                            <p>We want the Banglez experience to be clear, fast, and helpful. If you have ideas, run into bugs, or need support, reach out—your feedback directly informs our roadmap.</p>
                            <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="send-feedback" class="active">How to send feedback</li>
                                        <li data-target="response">Our response</li>
                                        <li data-target="accessible-feed">Accessibility feedback</li>
                                        <li data-target="privacy-feed">Privacy</li>

                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="send-feedback">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>Feedback form: <a href="{{ url('contact-us') }}"> link to form</a></p><br>
                                            <p>Email: info@banglez.com</p><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="response" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>We acknowledge feedback within 2 business days.</p><br>
                                            <p>We triage by impact (critical issues first), then update you when the status changes or a fix ships.</p><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="accessible-feed" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>If your feedback relates to accessibility or you need content in an alternative format, mention “Accessibility” in the subject line so we can prioritize and respond quickly (see details in our Accessibility Statement).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="privacy-feed" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>We use your feedback only to improve our products and services. For details, see our Privacy Policy.</p>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>



                        <div class="tab-main tab-pane" id="shipping">
                            <h1>Shipping Policy</h1>
                            <p>*Important msg update: April 16th, 2020, Ontario was put under a stay-at-home order to prevent the spread of the Coronavirus (COVID-19). Since then Banglez has been taking all measures advised by the Government of Canada and in accordance with the Government of Ontario Ministry of health's guidelines, we are still taking virtual appointments and still shipping out orders. Some but not all shipping services may experience additional time in transit as a result of the pandemic. If you need your items by a certain date, please speak to us so we can make sure it gets to you by that date.</p>
                            <br>
                            <p><strong>Orders are packaged and shipped from Tuesday - Friday only. Most orders are shipped within 1-3 business days from your payment being cleared with the exception of sale times where it may take up to an additional 48-72 hours. Orders placed on weekends and select holidays are processed on the next business day.</strong></p>
                            <br>
                            <p>If we are unable to process your order due to inaccurate or incomplete payment information, we will reach out to you to rectify the situation. In the event that no communication is made from your (customers) end, your order will be cancelled.</p>
                            <br>
                            <p>Orders with out-of-stock item(s): although we try our best to maintain 100% accuracy with inventory, there are rare occasions where we experience an inventory error. In this case, we will contact you to rectify the situation. If we are not able to get in touch with you within 1-5 business days, we will cancel the order. </p>
                            <br>
                            <p>In the event that you need your item(s) earlier than chosen shipping method, please contact us at info@banglez.com to make arrangements. *will include additional costs*</p>
                             <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="where-deliver" class="active">Where Do We Deliver?</li>
                                        <li data-target="shiping-charg">Shipping Charges:</li>
                                        <li data-target="pick-up">Local Pick-up:</li>
                                        <li data-target="hidden-expense">Hidden expenses?</li>
                                        <li data-target="shipment">Shipment and Tracking Details:</li>
                                        <li data-target="address-change">Address Change Requests</li>
                                        <li data-target="multi-address">Multiple Address Order</li>
                                        <li data-target="incomplete-adress">Incorrect or Incomplete Address</li>
                                        <li data-target="time-ship">Time to Ship</li>
                                        <li data-target="billing-address">Billing Address and Shipping Address</li>
                                        <li data-target="add-fees">Additional Fees</li>
                                        <li data-target="shiping">Shipping Carriers</li>
                                        <li data-target="custome">CUSTOMS, DUTIES, AND TAXES</li>





                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="where-deliver" >
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p><span><strong>We now ship worldwide!</strong> Should you experience any issues checking out, please contact us at info@banglez.com and we will do our best to accommodate you!</span></p>
                                            <br>
                                            <p>Please note that some residential shipments will be left at the door if someone is not there to receive the package or if no one answers the door. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="shiping-charg" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Free shipping with a minimum purchase of $80+ for Canadian customers, $80+ more for North American customers and $200+ for international customers *some exceptions apply*! This limited-time offer applies only to standard ground shipping.</p>
                                            <br>
                                            <p><strong>*No free shipping option offered for Australia, New Zealand and the UAE*</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="pick-up" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Free curbside pick up ONLY at Oakville, ON L6H 4V9.</p>
                                            <br>
                                            <p>Call (416) 834–6717 to arrange a pick-up time within 5 days of receiving an order fulfillment e-mail. On arrival show your confirmation email & a piece of ID to collect your order. Please provide a note at check out if someone else is collecting the order on your behalf.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="hidden-expense" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>The Government in your country of residence can impose taxes or import duties applicable on entry as per local laws, please understand that Banglez has no control over this and is not responsible for paying these fees. (Please see customs, duties and taxes below for more information)</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="shipment" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Once your order has been shipped, you will receive an email confirmation of your shipping details and a tracking number. Following the tracking number link will take you to the respective courier website we have shipped with and show you a timeline with and estimated date of delivery. The tracking number for your order shipped might take 24 business hours to become active on the courier website. For international orders that do not have a tracking number, contact us at mahak@banglez.com for more details regarding your order. </p>
                                            <br>
                                            <p>In some cases, tracking information won't be available or as up to date. This may be a result of the timing of tracking database's updates by the carrier, the complexity of an individual carrier's tracking system, or the absence of complete integration into our stores tracking systems.</p>
                                        </div>
                                    </div>
                                </div>

                                 <div class="side-content-tabs" id="address-change" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Once an order has been placed, you cannot make any changes. However, address alteration may be accommodated within 24 hours of placing the order if your order has not yet been shipped out. Please send your change request to info@banglez.com or call +1 (416) 834 - 6717 as soon as possible.</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="multi-address" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Currently, this option is not available. However, if you want to send the product to different addresses, you can place multiple Orders. Unfortunately, you may only ship to one address per order.</p>
                                            <br>
                                            <p>If your order contains gifts or items that require shipping to multiple locations, you will need to place separate orders for each address.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="incomplete-adress" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Please note: some courier companies charge a penalty for incorrect shipping addresses, wherein the address and zip code do not match. The customer will, without exception, bear the cost of any such penalties and/or fees, not Banglez. Please make sure your shipping address is correct.</p>
                                            <br>
                                            <p>In the event of a reshipment of the same order, customers will be responsible for paying charges for the reshipment.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="time-ship" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                            <p>Shipping times are listed at checkout. Please add a 24 hour processing time to your listed shipping time when checking out.</p>
                                            <br>
                                            <p>For our Kahlo collection, pieces are made to order and require three weeks for production plus shipping.</p>
                                            <br>
                                            <p>During sale periods it may take up to an additional 48-72 hours to send out orders.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="billing-address" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                           <p>Your billing address is the place you get your bills from the credit card company/the address your bank has on file. Shipping address is the address where you (customer) wants to receive his/her goods.</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="add-fees" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Restocking fee: A 10-15% restocking fee will be charged for any packages refused** on delivery by the customer or returned.</p>
                                            <br>
                                            <p>Reshipping orders: The shipping charges for special requests such as reshipping orders may be higher than the shipping charges for your original order. In these cases, a customer service representative will let you know about your new shipping charge when your order is replaced.</p>
                                            <br>
                                            <p>Be advised that conversion and import/duty fees do not apply to your order. However, if you live outside Canada, your financial institution or country you live in may charge additional fees on top of your total as conversion or import taxes/customs fees. This is not something Banglez can avoid or credit you for since the fees come from your financial institution or country.</p>
                                            <br>
                                            <p><strong>Package refused :</strong> We take great care in preparing and shipping out your package. Should the situation arise where you refuse the package and it is abandoned, please email us immediately. This will allow us the opportunity to arrive at a resolution with the carrier company. All costs associated with shipping your package, resolution fees and restocking fees will be deducted before a refund is issued.</p>
                                            <br>
                                            <p>It is best for you to let us know you no longer want the package before it is delivered. Or accept the package so we can arrange for it to be shipped back to us. This is in the best interest of both parties since it will cost less for when we issue the customer a refund.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="shiping" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> <strong>Banglz</strong> delivers some packages through the following carriers. We have contact information for these carriers:</p>
                                            <br>
                                            <p>1.&nbsp;<a href="https://www.ups.com/ca/en/Home.page" title="UPS Home page" target="_blank">UPS</a></p>
                                            <br>
                                            <p>Phone: 1-800-PICK-UPS (1-800-742-5877) *includes International services originating in Canada*</p>
                                            <br>
                                            <p>2.&nbsp;<a href="https://www.canadapost.ca/cpc/en/home.page" title="Canada Post Home Page" target="_blank">Canada Post</a></p>
                                            <br>
                                            <p>Phone: 1 (866) 607-6301</p>
                                            <br>
                                            <p>3.&nbsp;<a href="https://www.fedex.com/ca_english/index.html" title="FedEx Home Page" target="_blank">FedEx</a></p>
                                            <br>
                                            <p>Phone (US &amp; Canada): 1.800.GoFedEx 1.800.463.3339</p>
                                            <br>
                                            <p>TTY: 1.800.238.4461</p>
                                            <br>
                                            <p><span class="s2">Outside Canada: <a href="http://www.fedex.com/us/customersupport/call/index.html">http://www.fedex.com/us/customersupport/call/index.html</a></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="custome" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>International shipments may be subject to import taxes, customs duties, and fees levied by the destination country. Additional charges for customs clearance must be borne by the recipient; we have no control over these charges and cannot predict what they may be. Customs policies vary widely from country to country. Please contact your local customs office for information.</p>
                                            <br>
                                            <p><b>Note: </b>If you have feedback about your experience with one of our carriers, please contact us at info@banglez.com</p>
                                            <br>
                                            <p><b>UPS Carbon Neutral </b><em>Banglez promise to offset the climate impact of your shipping! Furthering our commitment to being a green business</em>!</p>
                                            <br>
                                            <p>We know that our customers are as concerned as we are about the impact shipping has on the environment. That's why we cover an additional amount on shipments to purchase the carbon neutral shipping option. </p>
                                            <br>
                                            <p>Banglez wants to reduce its carbon footprint while demonstrating our commitment to sustainability. We care about climate change and want our lovely customers to be aware of this commitment.</p>
                                            <br>
                                            <p>UPS's carbon neutral option supports projects that offset the emissions of the shipment's transport. UPS has supported projects that include reforestation, landfill gas destruction, wastewater treatment, and methane destruction.</p>
                                            <br>
                                            <p>UPS carbon neutral option is verified by Société Générale de Surveillance (SGS), an inspection, testing, and verification company. This means that you can have confidence in the UPS carbon neutral method. Additionally, UPS's carbon offset process is certified by The Carbon Neutral Company. </p>
                                            <br>
                                            <p>For more information on this process, check out this&nbsp;<a href="https://www.carbonneutral.com/page/ups/" title="UPS CarbonNeutral shipment" target="_blank">link</a>!</p>
                                            <br>
                                            <p></p>
                                            <br>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>


                         <div class="tab-main tab-pane" id="returns">
                            <h1>Refund policy</h1>
                            <p><strong>Please note: Duties and taxes are not our responsibility nor do we have any control or say as to the amount that each country charges.</strong></p>
                           <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="regular-price" class="active">Regular Priced Items:</li>
                                        <li data-target="Refunds">Refunds:</li>
                                        <li data-target="Resolution">Immediate Refunds/Resolution will be made in the following cases:</li>
                                        <li data-target="norefunds">NO refunds will be issued in the following cases:</li>
                                        <li data-target="missing-refunds">Late or missing refunds</li>
                                        <li data-target="clear-item">Clearance items</li>
                                        <li data-target="Exchanges">Exchanges</li>
                                        <li data-target="Shipping">Shipping</li>
                                        <li data-target="Special-circumstance">Special circumstance</li>
                                        <li data-target="Returned-package">Returned package</li>
                                        <li data-target="Color-Description">Color & Description Disclaimer</li>
                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="regular-price" >
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>Our policy allows returns from online purchases within 15 days of our ship date for North American customers and 30 days of our ship date for international customers. After those allotted days, the sale is final. For your order to qualify for a return, your item(s) must be unused and in the same condition that you received it. It must also be in the original packaging with all barcode tags attached. In addition, to complete your return, we require a receipt or proof of purchase to be emailed to us at info@banglez.com.</p>
                                            <br>
                                            <p><strong>Please note that Clearance Sale Items, Gift cards, Bangle boxes, Sleeves, Bridal choora and ALL Black Friday Sales, Boxing Day or any other sale marked is FINAL SALE.</strong></p>
                                            <br>
                                            <p><strong>With respect to the auspicious value that many of our clients feel about their Bridal choora, we will no longer accept any exchanges or refunds. What is a Bridal choora? A bangle set is made of thick plastic bangles and is traditionally arranged. *Please see the product description for more details.</strong></p>
                                            <br>
                                            <p>Please do not send any items back until you receive direct confirmation from our team to return. The customer is responsible for the costs associated with the return shipping of items to Banglez. PLEASE NOTE THAT NO CREDIT OR REPLACEMENT ITEMS WILL BE CREDITED UNLESS OR UNTIL WE VERIFY THE RETURN. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="Refunds" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Once we receive the item(s), they will undergo an inspection, and then you will receive an email to notify you of the approval or rejection of your refund.</p>
                                            <br>
                                            <p>If you are approved, your refund will be processed minus a restocking fee of 10% and any other fees (i.e. duties, broker fees, etc.) incurred during the return process. The credit will automatically be issued in your original payment method within 5-10 business days.</p>
                                            <br>
                                            <p>Why a restocking fee? Banglez charges a 10% restocking fee to cover any processing fees, handling, and other costs associated with processing returns. The percentage is determined on a case basis.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="Resolution" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <ul>
                                                <li>Genuine quality issues.</li>
                                                <li>Packages lost in transit.</li>
                                                <li>Banglez discovers that the wrong item has been shipped to you.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="norefunds" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <ul>
                                                <li>Incorrect or outdated delivery address.</li>
                                                <li>Incorrect address format, including any form of a PO Box address.</li>
                                                <li>After 3 failed delivery attempts by our respective courier agent.</li>
                                                <li>Package refused by the recipient.**</li>
                                                <li>Products returned in a used or damaged condition.</li>
                                                <li>If the jewelry is not faulty or damaged, as stated by the recipient.</li>
                                                <li>Shipping costs are non-refundable.</li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="missing-refunds" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Once the Banglez team has processed a refund & you have been notified by email, please consider the following: </p>
                                            <br>
                                            <ul>
                                                <li>If you haven’t received a refund yet, please allow 5-10 business days for the amount to be posted back to your bank account.</li>
                                                <li>Then contact your credit card company; it may take some time before your refund is officially posted.</li>
                                                <li>Next, contact your bank. There is often some processing time before a refund is posted.</li>
                                                <li>If you’ve done all of this and still haven’t received your refund, please contact us by emailing info@banglez.com.</li>
                                            </ul>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>

                                 <div class="side-content-tabs" id="clear-item" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>Only regular-priced items will be refunded. Clearance Sale Items, Gift cards, Bangle boxes, Sleeves, Bridal choora will not be refunded and are FINAL SALE. </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="Exchanges" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>All items are carefully inspected before being shipped. If you ordered the wrong size or are unhappy with your purchase, contact info@banglez.com to initiate the exchange process. Exchanges require the customer to drop off or pay shipping fees to us and back to them. We will make it our priority to promptly fix any problem associated with your order. </p>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="Shipping" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>To return your product, contact<a href="mailto:info@banglez.com" class="editor-rtfLink" target="_blank">info@banglez.com</a>, and you will be given further instructions.</p>
                                            <br>
                                            <p>Once the Banglez team has authorized your return, you will be responsible for paying for the shipping costs associated with returning your purchase unless you wish to come and drop off your purchase in Oakville. </p>
                                            <br>
                                            <p>Depending on where you live, the time it may take for your exchanged product to reach you may vary. </p>
                                            <br>
                                            <p>As safe delivery to you is our responsibility, in the same way sending back pieces safely to us is your responsibility. When shipping an item over $75, we suggest using a trackable shipping service or purchasing shipping insurance. We also recommend you keep the postal receipt until delivery is confirmed. </p>
                                            <br>
                                            <p>Guidelines:</p>
                                            <ul>
                                                <li>Always report your problem as soon as possible after receiving the item in question.</li>
                                                <li>Always report any problems associated with a single order/package delivery at the same time. When describing the problem, be as specific as possible, as all returned items are examined for defects/variations.</li>
                                                <li>Please return within allotted days (depending on region) of confirmation from our end and with original packing & in original condition (used or altered items will not be accepted). Please ensure to include a copy of the invoice you received.</li>
                                                <li>Please do not send your purchase back to us UNTIL we have verified it, and no credit or replacement will be given on such items.</li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="Special-circumstance" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                            <p><strong>Missing package</strong></p>
                                            <br>
                                            <p>If your tracking link shows that your package has been delivered, but you can’t find it. Do the following: </p>
                                            <br>
                                            <ul>
                                                <li>Open your shipping confirmation and verify your shipping address</li>
                                                <li>Look for a notice from the post office of an attempted delivery</li>
                                                <li>Ask members of your household, neighbours or building management if someone else accepted your delivery</li>
                                                <li>Look around your delivery location for the package</li>
                                                <li>In rare cases, wait 36 hours; some parcels may show as being delivered 36 hours before arrival.</li>
                                                <li>Lastly, notify us so we can find out what happened. </li>
                                            </ul>
                                            <br>
                                            <p>As much as we hope for a positive outcome, sometimes a package will go missing. We will launch an inquiry in such a circumstance, and an agent from our customer service department will be in contact until the issue is resolved. Rest knowing that we are just as worried and aggravated in situations like these and will not rest until the issue is resolved. </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="Returned-package" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content resource-table">
                                            <p>If a package is returned to us, we will inquire into the matter and deal with it accordingly. </p>
                                            <br>
                                            <p>When a package is returned to us, we sometimes have to pay a courier fee, inconveniencing us. Then: </p>
                                            <br>
                                            <p>- If the customer wishes to be reshipped their order, they will be charged the return courier fee (if we were charged one, which is not always the case) and new shipping charges(in the method they choose). In this case, a customer service representative will guide you through replacing your order.</p>
                                            <br>
                                            <p>- If the customer no longer wishes to be reshipped their order, they will be refunded for their order minus the return courier fee(if charged) and shipping charges. In this case, a customer service representative will process your refund, and you will be notified of your refund via email.</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="side-content-tabs" id="Color-Description" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>The descriptions of the products, product specifications and images are only approximate values. </p>
                                            <br>
                                            <p>We make every effort to ensure that product colours/finishes/textures are represented accurately. However, there may be minor variations in the shade of the colour of the actual product because of the differences in calibration of the display output due to lighting, digital photography, colour settings and capabilities of monitors/devices etc. Therefore colour reproduction on the internet is limited by technology in that it is not always precise. Please refer to product descriptions, images or email info@banglez.com to avoid misunderstandings and confirm colour/shade accuracy. </p>
                                            <br>
                                            <p>Note: Just because some products have the same colour name, this does not mean they are the same colour. Also, do not misinterpret the colour’s name to be what you may think it should be. i.e., just because a colour may be named “Tan” does not mean it will necessarily look like what most people would consider the Tan colour to be; we all have our variation/interpretation of what we think “Tan” should be. Therefore, please do not order using colour names as your guide; always read the description or reference the multiple images. </p>
                                            <br>
                                            <p>A customer placing an order through the website should do so while keeping in mind that this minor variation in colour seen on a computer/tablet/mobile/TV screen against the actual colour of the product received can happen. </p>
                                            <br>
                                            <p>For example:</p>
                                            <br>
                                            <p>- Red, maroon and orange colours have a higher tendency to reflect a different shade than other colours. Though imaging technology has advanced, slight colour variations are often challenging to convey digitally. </p>
                                            <br>
                                            <p>Often, green and blue shades may overlap and the colours off-white, white and cream. </p>
                                            <br>
                                            <p>- Sea Green colours may appear Aqua blue and vice versa. </p>
                                            <br>
                                            <p><strong>**package refused or abandoned:</strong> We take great care in preparing and shipping your package. In the event that the shipment is refused or considered abandoned, all costs associated with returning your package including, resolution fees, restocking fees, broker fees, and applicable duties and taxes will be deducted before issuing a refund.</p>
                                            <br><br>
                                            <p>
                                                <a href="https://form.jotform.com/202434078614250" title="Banglez return form" target="_blank"><strong><em>**Begin a return request now(Click here!)**</em></strong></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="shiping" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p> <strong>Banglz</strong> delivers some packages through the following carriers. We have contact information for these carriers:</p>
                                            <br>
                                            <p>1.&nbsp;<a href="https://www.ups.com/ca/en/Home.page" title="UPS Home page" target="_blank">UPS</a></p>
                                            <br>
                                            <p>Phone: 1-800-PICK-UPS (1-800-742-5877) *includes International services originating in Canada*</p>
                                            <br>
                                            <p>2.&nbsp;<a href="https://www.canadapost.ca/cpc/en/home.page" title="Canada Post Home Page" target="_blank">Canada Post</a></p>
                                            <br>
                                            <p>Phone: 1 (866) 607-6301</p>
                                            <br>
                                            <p>3.&nbsp;<a href="https://www.fedex.com/ca_english/index.html" title="FedEx Home Page" target="_blank">FedEx</a></p>
                                            <br>
                                            <p>Phone (US &amp; Canada): 1.800.GoFedEx 1.800.463.3339</p>
                                            <br>
                                            <p>TTY: 1.800.238.4461</p>
                                            <br>
                                            <p><span class="s2">Outside Canada: <a href="http://www.fedex.com/us/customersupport/call/index.html">http://www.fedex.com/us/customersupport/call/index.html</a></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="custome" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>International shipments may be subject to import taxes, customs duties, and fees levied by the destination country. Additional charges for customs clearance must be borne by the recipient; we have no control over these charges and cannot predict what they may be. Customs policies vary widely from country to country. Please contact your local customs office for information.</p>
                                            <br>
                                            <p><b>Note: </b>If you have feedback about your experience with one of our carriers, please contact us at info@banglez.com</p>
                                            <br>
                                            <p><b>UPS Carbon Neutral </b><em>Banglez promise to offset the climate impact of your shipping! Furthering our commitment to being a green business</em>!</p>
                                            <br>
                                            <p>We know that our customers are as concerned as we are about the impact shipping has on the environment. That's why we cover an additional amount on shipments to purchase the carbon neutral shipping option. </p>
                                            <br>
                                            <p>Banglez wants to reduce its carbon footprint while demonstrating our commitment to sustainability. We care about climate change and want our lovely customers to be aware of this commitment.</p>
                                            <br>
                                            <p>UPS's carbon neutral option supports projects that offset the emissions of the shipment's transport. UPS has supported projects that include reforestation, landfill gas destruction, wastewater treatment, and methane destruction.</p>
                                            <br>
                                            <p>UPS carbon neutral option is verified by Société Générale de Surveillance (SGS), an inspection, testing, and verification company. This means that you can have confidence in the UPS carbon neutral method. Additionally, UPS's carbon offset process is certified by The Carbon Neutral Company. </p>
                                            <br>
                                            <p>For more information on this process, check out this&nbsp;<a href="https://www.carbonneutral.com/page/ups/" title="UPS CarbonNeutral shipment" target="_blank">link</a>!</p>
                                            <br>
                                            <p></p>
                                            <br>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="tab-main tab-pane" id="jewelry-care">
                            <h1>Jewelry care</h1>
                           <div class="main-side-heding-tabs">
                                <div class="side-headings-tabs">
                                    <ul id="tab-side-menu">
                                        <li data-target="Always-clean" class="active">Always clean your fashion jewelry after wear & keep it dry</li>
                                        <li data-target="remove-jewelery">Remove your jewelry when you have no use to wear it</li>
                                        <li data-target="fashion-jewelry">Store your fashion jewelry carefully</li>
                                        <li data-target="not-coat">Do not coat your costume and semi-precious jewelry</li>
                                        <li data-target="your-bindis">Reusing your bindis</li>
                                    </ul>
                                </div>
                                <div class="side-content-tabs" id="Always-clean" >
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                           <p>A great tip to make your<strong>costume jewelry look its best as long as possible</strong>is to<strong>clean them after each use</strong>and keep them dry It might seem like a hassle after a long day, but it can make a huge difference in the way it looks and shines. There’s always the possibility that you got perfumes, lotion, oil from your skin on your jewelry while you wore it, so don’t put it away before you get the chance to clean it or at least wipe it down with a soft cloth.</p>
                                            <br>
                                            <p>Protect the plating of your jewelry by removing it when washing dishes, exercising, cleaning, washing your hands, doing laundry, going swimming (chlorinated and salt water can react with the metals). </p>
                                            <br>
                                            <p><strong>Avoid </strong> cleaners that contain acid, vinegar or ammonia and some jewelry cleaners, as they can damage your jewelry. Alcohol wipes can be ok from time to time to sanitize the back of earrings. Also, make sure your jewelry is completely dry before you put it away!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="remove-jewelery" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>It is important that your jewelry is the <strong>last thing you put on</strong>after applying hairspray, makeup or lotion and to ensure you clothing doesn’t get caught in it. It is also important that your jewelry is the <strong>first thing you take off</strong>before changing out of your clothes and going to bed, as it may break if slept with on.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="fashion-jewelry" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>We all have our preferences when storing jewelry. The best way to prevent damage or breakage is to <strong>store fashion/costume jewelry individually</strong>, in cotton, velvet or plastic pouches. Jewelry boxes come in a close second, but storing the pieces individually in a <u>bag/pouch</u>is the best way to prevent damage.</p>
                                            <br>
                                            <p>It is preferable if your necklaces are <strong>hung on hooks</strong>and not in contact with other jewelry.</p>
                                            <br>
                                            <p>This helps to keep your jewelry from tangling and breaking. It also prevents any kind of dulling that can occur from metals rubbing off on one another.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-content-tabs" id="not-coat" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>We would advise against using any kind of protectant or finish on your jewelry, as it can end up taking off or changing the finish of your jewelry.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-content-tabs" id="your-bindis" style="display:none">
                                    <div class="side-inner-content-main">
                                        <div class="side-inner-content resource-content">
                                            <p>If you would like to reuse your bindi, place it back on the sheet it originally came on for safe keeping. Some bindis have incredible holding power and can be used multiple times, however more than often the natural oils from our skin will deter the sticky backing. In the case that happens, apply some bindi or eyelash glue to the back and have fun! </p>
                                        </div>
                                    </div>
                                </div>




                            </div>


                        </div>


                    </div>
            </div>



                {{-- our mission --}}

                <div class="our-mission-section">
                    <div class="mission-left-section">
                        <div class="mission-left-detail">
                            <h1>OUR MISSION</h1>
                            <p>Since 2006, we have taken pride in designing unique pieces that reflect quality craftsmanship and cultural heritage. At Banglez we believe that jewelry is more than just an accessory - it’s a reflection of who we are, where we come from and what we value and we remain committed to preserving the rich history and artistry of South Asian jewelry while adding a modern and personal touch.</p>
                        </div>
                        <a href="{{ url('about-us') }}" class="shop-now">
                            Shop Now
                        </a>
                    </div>
                    <div class="mission-right-section">
                        <img src="{{asset('assets/images/12.png')}}" alt="missing image">
                    </div>

                </div>

                {{--customization Buttons --}}
               <div class="Customize-section">
                    <div class="customize-sec-content">
                        <h1>Bundle your Look. Unlock Rewards</h1>
                        <p>Select pieces marked with the Complete Your Look tag to build your perfect set.
                            Add three eligible items and unlock exclusive perks, including free styling services and more.</p>
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


        </script>
       <script>
document.addEventListener("DOMContentLoaded", function () {
  // Handle tab switching when clicked
  document.querySelectorAll('.custom-tabs li').forEach(tab => {
    tab.addEventListener('click', function() {
      activateTab(this.dataset.tab);
    });
  });

  // Function to activate a tab + pane
  function activateTab(tabName) {
    // Remove active from all tabs
    document.querySelectorAll('.custom-tabs li').forEach(t => t.classList.remove('active'));
    // Remove active from all panes
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

    // Activate the correct tab
    const activeTab = document.querySelector(`.custom-tabs li[data-tab="${tabName}"]`);
    if (activeTab) activeTab.classList.add('active');

    // Show the related pane
    const activePane = document.getElementById(tabName);
    if (activePane) activePane.classList.add('active');
  }

  // 🔑 Check URL param for tab (e.g. /about-us?tab=Size-Guide)
  const urlParams = new URLSearchParams(window.location.search);
  const defaultTab = urlParams.get('tab');
  if (defaultTab) {
    activateTab(defaultTab);
  }
});
</script>
<script>
  // Get all tab items and content divs
  const tabItems = document.querySelectorAll("#tab-side-menu li");
  const tabContents = document.querySelectorAll(".side-content-tabs");

  // Loop through each tab item
  tabItems.forEach(item => {
    item.addEventListener("click", () => {
      const targetId = item.getAttribute("data-target");

      // Remove active class from all tabs
      tabItems.forEach(tab => tab.classList.remove("active"));

      // Hide all tab contents
      tabContents.forEach(content => {
        content.style.display = "none";
      });

      // Add active class to clicked tab
      item.classList.add("active");

      // Show the clicked one
      document.getElementById(targetId).style.display = "block";
    });
  });
</script>

    </x-slot>
</x-layouts.user-default>

</html>
