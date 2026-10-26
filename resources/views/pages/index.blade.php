@php
$siteUrl = env('APP_URL');
@endphp
@extends('layout.default')
@section('content')

<!--<section class="hero">
        <div class="hero__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-duration="2000">
                    <h1 class="hero__title">Elevate Your Events<br>with Authentic Flavours</h1>
                    <div class="hero__buttons">
                        <a href="{{route('contactUs')}}" class="btn view-all-btn btn--secondary">BOOK YOUR EVENT &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{$siteUrl}}public/img/ban-bottom.png" class="edition-img" data-aos="fade-up" data-aos-duration="1000" alt="">
    </section>-->
    
<section class="hero">
        <div class="hero__overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center" data-aos="fade-up" data-aos-duration="2000">
                        <h1 class="hero__title"><?php echo ucwords(strtolower('LUXURY VEGETARIAN CATERING'));?><br />
<?php echo ucwords(strtolower('FOR EXTRAORDINARY CELEBRATIONS'));?></h1>
                        <div class="hero__buttons">
                            <a href="{{route('contactUs')}}" class="btn view-all-btn btn--secondary">Plan YOUR EVENT &rarr;</a>
                        <!--<a target="_blank" href="{{$siteUrl}}public/mamus-menu2024.pdf" class="btn view-all-btn btn--outline">EXPLORE MENU</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{$siteUrl}}public/img/ban-bottom.png" class="edition-img" data-aos="fade-up" data-aos-duration="1000" alt="">
         <div class="hero_banner_video-section">
            <video autoplay muted loop playsinline preload="auto">
                <source src="{{$siteUrl}}public/img/hero_banner_video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
         </div>
    </section>

    <section class="about section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 text-center position-relative ab" data-aos="fade-right" data-aos-duration="2000">
                    <img src="{{$siteUrl}}public/img/Left-Img.png" class="img-fluid" alt="">
                    <img src="{{$siteUrl}}public/img/Left-Img2.png" class="img-fluid" alt="">
                    <img src="{{$siteUrl}}public/img/Since-bage.png" class="home-since-badge" alt="">
                </div>
                <div class="col-md-7 ps-3" data-aos="fade-left" data-aos-duration="2000">
                    <div class="about-cont">
                        <h4 class="section-kicker">Welcome to</h4>
                        <h2 class="section-heading text-gold">MAMU'S INFUSION</h2>
                        <p class="section-text">Founded in 1990 as a small outlet, MAMU’S has grown into a symbolic name
                            among Jaipurites. Over the past 35 years, it has become a landmark in the Pink City,
                            celebrated
                            for its rich culinary heritage, authentic flavors, and exceptional hospitality. While MAMU’S
                            hardly needs an introduction today, we are proud to present MAMU’S INFUSION: Luxury Catering
                            — a
                            premium extension of MAMU’S culinary legacy, dedicated exclusively to luxury catering and
                            event
                            hospitality.</p>
                        <p class="section-text">Widely recognized as one of Jaipur’s most trusted and renowned culinary
                            brands, MAMU’S has built its reputation through decades of quality, consistency, and
                            customer
                            satisfaction. MAMU’S INFUSION carries this legacy forward by delivering bespoke catering
                            experiences tailored for weddings, corporate events, private gatherings, and grand
                            celebrations.
                        </p>
                        <p class="section-text">At MAMU’S INFUSION, we believe food is the centerpiece of every
                            memorable
                            occasion. Combining traditional Indian flavors with modern presentation and refined service,
                            we
                            curate catering experiences that leave a lasting impression. From intimate celebrations to
                            large-scale events, our team is committed to delivering exceptional cuisine, elegant setups,
                            and
                            seamless hospitality that elevate every event into an unforgettable experience.</p>
                        <a href="#" class="btn view-all-btn btn--primary">BOOK YOUR EVENT &rarr;</a>

                        <div class="stats-counter-section" data-aos="fade-up" data-aos-duration="2000">
                            <div class="stat-item">
                                <h2 class="stat-number"><span class="counter" data-target="5000">0</span>+</h2>
                                <p class="stat-label">Successful Events</p>
                            </div>

                            <div class="stat-item">
                                <h2 class="stat-number"><span class="counter" data-target="100000">0</span>+</h2>
                                <p class="stat-label">Happy Guests</p>
                            </div>

                            <div class="stat-item">
                                <h2 class="stat-number"><span class="counter" data-target="35">0</span>+ years</h2>
                                <p class="stat-label">Catering Excellence</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Noteable Clients Marquee Section -->
    <section class="clients-marquee-section">
        <div class="container text-center" data-aos="fade-up" data-aos-duration="2000">
            <h2 class="section-heading text-center text-dark">Our Noteable <span class="text-gold">Clients</span></h2>
        </div>

        <!-- Infinite CSS Marquee -->
        <div class="marquee" data-aos="fade-up" data-aos-duration="3000">
            <!-- Group 1 -->
            <div class="marquee-group">
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients.jpg" alt="Amrapali Jaipur">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients2.jpg" alt="Sunita Shekhawat Jaipur">
                </div>
                <div class="client-logo-box bg-maroon">
                    <img src="{{$siteUrl}}public/img/clients3.jpg" alt="Parina International">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients4.jpg" alt="Symetree">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients5.jpg" alt="Laxmi Misthan Bhandar (LMB)">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients6.jpg" alt="Jain International Trade Organisation">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients.jpg" alt="Amrapali Jaipur">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients2.jpg" alt="Sunita Shekhawat Jaipur">
                </div>
                <div class="client-logo-box bg-maroon">
                    <img src="{{$siteUrl}}public/img/clients3.jpg" alt="Parina International">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients4.jpg" alt="Symetree">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients5.jpg" alt="Laxmi Misthan Bhandar (LMB)">
                </div>
                <div class="client-logo-box">
                    <img src="{{$siteUrl}}public/img/clients6.jpg" alt="Jain International Trade Organisation">
                </div>
            </div>

        </div>
    </section>
    <img src="{{$siteUrl}}public/img/verticle-bg.png" class="img-fluid verticle-img" alt="">

    <!-- Experience Section -->
    <section class="experience section-padding bg-experience">
        <div class="container-fluid px-0">
            <div class="row text-center mb-4">
                <div class="col-12 d-flex justify-content-center align-items-center flex-column">
                    <h2 class="section-heading text-dark mb-4" data-aos="fade-up" data-aos-duration="2000">Making Every
                        <span class="text-gold">Experience
                            Magical</span>
                    </h2>

                    <!-- Bootstrap 5 Nav Tabs -->
                    <ul class="nav nav-tabs experience-tabs justify-content-center" id="experienceTabs" role="tablist"
                        data-aos="fade-up" data-aos-duration="2500">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="wedding-tab" data-bs-toggle="tab"
                                data-bs-target="#wedding" type="button" role="tab" aria-controls="wedding"
                                aria-selected="true">Wedding</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="haldi-tab" data-bs-toggle="tab" data-bs-target="#haldi"
                                type="button" role="tab" aria-controls="haldi" aria-selected="false">Haldi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mehndi-tab" data-bs-toggle="tab" data-bs-target="#mehndi"
                                type="button" role="tab" aria-controls="mehndi" aria-selected="false">Mehndi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sangeet-tab" data-bs-toggle="tab" data-bs-target="#sangeet"
                                type="button" role="tab" aria-controls="sangeet" aria-selected="false">Sangeet</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-duration="3000">
                <div class="col-12 col-lg-8">
                    <p class="experience__desc text-center">
                        At MAMU'S INFUSION: Luxury Catering, we believe every celebration deserves to feel
                        extraordinary. From lavish weddings and elegant corporate events to intimate family gatherings,
                        we bring together exceptional cuisine, artistic presentation, and personalized hospitality to
                        create experiences that guests remember long after the event ends. Every detail is thoughtfully
                        curated by our team to reflect your vision, ensuring each occasion is not only seamless, but
                        truly magical.
                    </p>
                </div>
            </div>

            <!-- Bootstrap 5 Tab Content -->
            <div class="tab-content mt-4" id="experienceTabsContent" data-aos="fade-up" data-aos-duration="2000">
                <div class="tab-pane fade show active" id="wedding" role="tabpanel" aria-labelledby="wedding-tab">
                    <div class="video-gallery">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/1.mp4" poster="{{$siteUrl}}public/video-poster/w-1.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/2.mov" poster="{{$siteUrl}}public/video-poster/w-2.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/3.mov" poster="{{$siteUrl}}public/video-poster/w-3.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/5.mp4" poster="{{$siteUrl}}public/video-poster/w-4.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="haldi" role="tabpanel" aria-labelledby="haldi-tab">
                    <div class="video-gallery">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/11.mp4" poster="{{$siteUrl}}public/video-poster/h-1.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/22.mp4" poster="{{$siteUrl}}public/video-poster/h-2.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/33.mp4" poster="{{$siteUrl}}public/video-poster/h-3.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <!--<div class="video-card">
                            <video src="{{$siteUrl}}public/videos/1.mp4" poster="{{$siteUrl}}public/img/video4.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>-->

                    </div>
                </div>

                <div class="tab-pane fade" id="mehndi" role="tabpanel" aria-labelledby="mehndi-tab">
                    <div class="video-gallery">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/m-1.mp4" poster="{{$siteUrl}}public/video-poster/m-1.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/m-2.mp4" poster="{{$siteUrl}}public/video-poster/m-2.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="sangeet" role="tabpanel" aria-labelledby="sangeet-tab">
                    <div class="video-gallery">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/s-1.mp4" poster="{{$siteUrl}}public/video-poster/s-1.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/s-2.mp4" poster="{{$siteUrl}}public/video-poster/s-2.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/s-3.mp4" poster="{{$siteUrl}}public/video-poster/s-3.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/s-4.mp4" poster="{{$siteUrl}}public/video-poster/s-4.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!--<div class="row mt-5" data-aos="fade-up" data-aos-duration="3500">
                <div class="col-12 text-center pt-3">
                    <a href="#" class="btn view-all-btn btn--primary">EXPLORE MORE &rarr;</a>
                </div>
            </div>-->
        </div>
    </section>
    <section class="services section-padding bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h2 class="section-heading text-dark mb-0">Our <span class="text-gold">Services</span></h2>
                    <p class="section-text text-center mb-0 px-md-3 mx-auto">At MAMU’s INFUSION , we’re not just about
                        serving
                        food; we’re about ensuring your event is seamless and unforgettable. With our experienced and
                        dedicated team, we manage every detail of off-site catering and event planning, so you can relax
                        and enjoy your celebration as a guest. From the very first impression to the lasting memories,
                        our commitment is to turn every event into a truly exceptional experience!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                    <div class="service-card">
                        <div class="service-card__img">
                            <img src="{{$siteUrl}}public/img/service1.jpg" alt="Mehendi Event">
                        </div>
                        <h4 class="service-card__title">Mehendi Event</h4>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="2500">
                    <div class="service-card">
                        <div class="service-card__img">
                            <img src="{{$siteUrl}}public/img/service2.jpg" alt="Sangeet Event">
                        </div>
                        <h4 class="service-card__title">Sangeet Event</h4>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="3500">
                    <div class="service-card">
                        <div class="service-card__img">
                            <img src="{{$siteUrl}}public/img/service3.jpg" alt="Luxury Catering">
                        </div>
                        <h4 class="service-card__title">Luxury Catering</h4>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="{{route('services')}}" class="btn view-all-btn btn--primary">Explore All Services &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials section-padding">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-5 mb-4 mb-md-0 text-center text-md-start" data-aos="fade-right"
                    data-aos-duration="2000">
                    <h4 class="section-kicker text-white">TESTIMONIALS</h4>
                    <h2 class="section-heading text-white mt-5">What People Say<br>About Us</h2>
                    <a href="#" class="btn view-all-btn btn--outline-light mt-4">VIEW ALL TESTIMONIALS</a>
                </div>
                <div class="col-md-5" data-aos="fade-left" data-aos-duration="2000">
                    <div class="test-carousel owl-carousel owl-theme">
                        <div class="item">
                            <div class="video-gallery-testimonial">
                                <div class="video-card">
                                    <video src="{{$siteUrl}}public/videos/t-3.mp4" poster="{{$siteUrl}}public/img/video-test.jpg" playsinline></video>
                                    <div class="play-btn">
                                        <svg viewBox="0 0 24 24">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="video-gallery-testimonial">
                                <div class="video-card">
                                    <video src="{{$siteUrl}}public/videos/t-4.mp4" poster="{{$siteUrl}}public/video-poster/t-2.jpg" playsinline></video>
                                    <div class="play-btn">
                                        <svg viewBox="0 0 24 24">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="video-gallery-testimonial">
                                <div class="video-card">
                                    <video src="{{$siteUrl}}public/videos/t-7.mov" poster="{{$siteUrl}}public/video-poster/t-3.jpg" playsinline></video>
                                    <div class="play-btn">
                                        <svg viewBox="0 0 24 24">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stations section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h2 class="section-heading text-white">Signature Station's</h2>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                    <div class="station-card">
                        <img src="{{$siteUrl}}public/img/chat.jpg" alt="Chaat">
                        <div class="station-card__overlay">
                            <h4 class="station-card__title">Chaat</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="2500">
                    <div class="station-card">
                        <img src="{{$siteUrl}}public/img/chat2.jpg" alt="Dessert">
                        <div class="station-card__overlay">
                            <h4 class="station-card__title">Dessert</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="3500">
                    <div class="station-card">
                        <img src="{{$siteUrl}}public/img/chat3.jpg" alt="Western dessert">
                        <div class="station-card__overlay">
                            <h4 class="station-card__title">Western dessert</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gallery section-padding ">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h4 class="section-kicker">OUR GALLERY</h4>
                    <h2 class="section-heading text-dark mt-5">The Prestige <span class="text-gold">Gallery</span></h2>
                </div>
            </div>

            <div class="row g-3 gallery-grid">
                <div class="col-lg-3 d-flex flex-column gap-3" data-aos="fade-up" data-aos-duration="2000">
                    <div class="gallery-item flex-fill">
                        <img src="{{$siteUrl}}public/img/gal1.jpg" alt="Gallery Image 1">
                    </div>
                    <div class="gallery-item flex-fill">
                        <img src="{{$siteUrl}}public/img/gal2.jpg" alt="Gallery Image 2">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="2500">
                    <div class="video-gallery-testimonial">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/m-1.mp4" poster="{{$siteUrl}}public/img/gal3.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-flex flex-column gap-3" data-aos="fade-up" data-aos-duration="2000">
                    <div class="gallery-item flex-fill">
                        <img src="{{$siteUrl}}public/img/gal4.jpg" alt="Gallery Image 3">
                    </div>
                    <div class="gallery-item flex-fill">
                        <img src="{{$siteUrl}}public/img/gal5.jpg" alt="Gallery Image 4">
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="{{route('gallery')}}" class="btn view-all-btn btn--primary">VIEW ALL &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <section class="pass-arounds section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h2 class="section-heading text-white">Theatrical Serving <span class="text-gold">Pass
                            Arounds</span></h2>
                </div>
            </div>
            <div class="video-carousel owl-carousel owl-theme" data-aos="fade-up" data-aos-duration="2500">
                <div class="item">
                    <div class="video-gallery-testimonial">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/ser-1.mp4" poster="{{$siteUrl}}public/img/thumbnail1.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="video-gallery-testimonial">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/ser-2.mp4" poster="{{$siteUrl}}public/img/thumbnail2.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="video-gallery-testimonial">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/videos/ser-3.mp4" poster="{{$siteUrl}}public/img/thumbnail3.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <?php /*?><section class="blogs section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h2 class="section-heading text-dark">Our <span class="text-gold">Blogs</span></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                    <div class="blog-card">
                        <div class="blog-card__img">
                            <img src="{{$siteUrl}}public/img/thumbnail.jpg" alt="">
                        </div>
                        <div class="blog-body">
                            <h4 class="blog-card__title">Never eat more than you can life.</h4>
                            <p class="blog-card__meta">By Admin on 12 October 2023</p>
                            <p class="blog-card__excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <a href="#" class="blog-card__link">Read More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-duration="2500">
                    <div class="blog-card">
                        <div class="blog-card__img">
                            <img src="{{$siteUrl}}public/img/thumbnail.jpg" alt="">
                        </div>
                        <div class="blog-body">
                            <h4 class="blog-card__title">Never eat more than you can life.</h4>
                            <p class="blog-card__meta">By Admin on 12 October 2023</p>
                            <p class="blog-card__excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <a href="#" class="blog-card__link">Read More</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-duration="3500">
                    <div class="blog-card">
                        <div class="blog-card__img">
                            <img src="{{$siteUrl}}public/img/thumbnail.jpg" alt="">
                        </div>
                        <div class="blog-body">
                            <h4 class="blog-card__title">Never eat more than you can life.</h4>
                            <p class="blog-card__meta">By Admin on 12 October 2023</p>
                            <p class="blog-card__excerpt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <a href="#" class="blog-card__link">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-duration="2000">
                    <a href="#" class="btn view-all-btn btn--primary">VIEW ALL POSTS &rarr;</a>
                </div>

            </div>
        </div>
    </section><?php */?>

    <section class="director section-padding pt-0">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 mb-4 mb-md-0 p-0" data-aos="fade-left" data-aos-duration="2000">
                    <div class="content">
                        <h2 class="section-heading text-white mb-4">From the diary of the director</h2>
                        <p class="section-text text-light-gray mb-3">Cooking for me has always been my passion. In the
                            1990s, I began my journey with a small fast-food outlet in Jaipur called Mamu’s Cafe, driven
                            by a dream to create memorable food experiences. Over the years, with dedication,
                            creativity, and a constant desire to innovate, Mamu’s grew into one of Jaipur’s most loved
                            culinary brands.</p>
                        <p class="section-text text-light-gray mb-4">My passion for experimenting with flavors led to
                            the creation of MAMU’S INFUSION, a concept where authentic cuisine meets a modern fusion
                            twist. Today, through MAMU’S INFUSION: Luxury Catering, I continue that journey. My vision
                            is to turn every event into an unforgettable experience by combining exceptional cuisine,
                            elegant presentation, and personalized service. From intimate gatherings to grand weddings
                            and corporate celebrations, my passion continues to inspire experiences where food becomes
                            the heart of every occasion.</p>
                        <p class="section-text text-light-gray mb-4">Looking back, my journey has been one of passion,
                            perseverance, and creativity. What began as a small dream has evolved into a celebrated
                            culinary legacy, made possible through the love, trust, and support of countless guests over
                            the years.</p>
                        <div class="director__signature">
                            Ashwani Joshi
                        </div>
                    </div>
                </div>
                <div class="col-md-5 p-0" data-aos="fade-right" data-aos-duration="2000">
                    <div class="director__img">
                        <img src="{{$siteUrl}}public/img/director.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img src="{{$siteUrl}}public/img/verticle-bg.png" class="director-svg" alt="">
    </section>
@endsection