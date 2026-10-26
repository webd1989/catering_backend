@php
$siteUrl = env('APP_URL');
@endphp
<footer class="footer pt-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-duration="1500">
                    <div class="footer-contact-box text-center">
                        <div class="icon d-flex justify-content-center">
                            <img src="{{$siteUrl}}public/img/messagesvg.svg" alt="">
                        </div>
                        <h5 class="title">About us</h5>
                        <p class="text">Founded in 1990 as a small outlet, MAMU'S has grown into a landmark brand.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-duration="2000">
                    <div class="footer-contact-box text-center">
                        <div class="icon d-flex justify-content-center">
                            <img src="{{$siteUrl}}public/img/call.svg" alt="">
                        </div>
                        <h5 class="title">Let's talk</h5>
                        <p class="text"><a href="tel:+919829050290">Phone: +91 9829050290</a></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-duration="2500">
                    <div class="footer-contact-box text-center">
                        <div class="icon d-flex justify-content-center">
                            <img src="{{$siteUrl}}public/img/mail.svg" alt="">
                        </div>
                        <h5 class="title">For Booking</h5>
                        <p class="text">mamusinfusioncatering@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-duration="3000">
                    <div class="footer-contact-box text-center">
                        <div class="icon d-flex justify-content-center">
                            <img src="{{$siteUrl}}public/img/location.svg" alt="">
                        </div>
                        <h5 class="title">Contact us</h5>
                        <p class="text">101, 1st Floor, Mangalam Ambition Tower, D-46B Subhash Marg, C-Scheme, Jaipur,
                            Rajasthan - 302001</p>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{$siteUrl}}public/img/divider.png" class="my-5" alt="">
        <div class="container">
            <div class="row pt-4 mt-3">
                <div class="col-lg-3 col-md-4 col-sm-4 col-6 " data-aos="fade-up" data-aos-duration="1500">
                    <h5 class="footer-widget-title">Explore</h5>
                    <ul class="footer-links ps-0">
                        <li><a href="{{route('index')}}" class="active">Home</a></li>
                    <li><a href="{{route('aboutUs')}}">About Us</a></li>
                    <li><a href="{{route('services')}}">Services</a></li>
                    <li><a href="{{route('gallery')}}">Gallery</a></li>
                    <li><a href="{{route('contactUs')}}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6 " data-aos="fade-up" data-aos-duration="2000">
                    <h5 class="footer-widget-title">Others</h5>
                    <ul class="footer-links ps-0">
                        <li><a href="#">Testimonials</a></li>
                        <li><a target="_blank" href="{{$siteUrl}}public/mamus-menu2024.pdf">Menu</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6 " data-aos="fade-up" data-aos-duration="2500">
                    <h5 class="footer-widget-title">Socials</h5>
                    <ul class="footer-links ps-0">
                        <li><a target="_blank" href="https://www.instagram.com/mamusinfusioncatering?utm_source=qr">Instagram</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/share/14mMNUN2mZ7/?mibextid=wwXIfr">Facebook</a></li>
                        <li><a target="_blank" href="https://www.youtube.com/@rinkujoshi2010?si=oG5JUfMAdOdc0KNT">Youtube</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-12 col-12" data-aos="fade-up" data-aos-duration="3000">
                    <h5 class="footer-widget-title">Instagram</h5>
                    <ul class="footer-links insta ps-0">
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                        <li><a href="#"><img src="{{$siteUrl}}public/img/01.jpg" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <img src="{{$siteUrl}}public/img/divider.png" class="my-5" alt="">
        <div class="row">
            <div class="col-12 text-center py-3">
                <p class="copyright-text mb-0">&copy; Copyright 2026 Mamu's Infusion. All Right Reserved</p>
            </div>
        </div>

    </footer>
    <style>
    .chat_icon {
    position: fixed;
    right: 16px;
    bottom: 22px;
    cursor: pointer;
}
    </style>
    <div id="chatBoatIcon" class="chat_icon">
	<a href="https://wa.link/6wvw3a" target="_blank"><img width="58" src="https://mamusinfusion.com/public/img/wp.png"></a>
</div>