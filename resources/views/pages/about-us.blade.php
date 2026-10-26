@php
$siteUrl = env('APP_URL');
@endphp
@extends('layout.default')
@section('content')
<div class="head-spcing"></div>
<section class="about ab-sec section-padding pt-5">
        <div class="container">
            <div class="row align-items-center mt-5">

                <div class="col-lg-6 pe-5" data-aos="fade-right" data-aos-duration="2000">
                    <h1 class="section-heading-main text-dark fw-bold">About <span class="text-gold">US</span></h1>
                    <p class="section-text">Founded in 1990 as a small outlet, MAMU’S has grown into a symbolic name
                        among Jaipurites. Over the past 35 years, it has become a landmark in the Pink City, celebrated
                        for its rich culinary heritage, authentic flavors, and exceptional hospitality. While MAMU’S
                        hardly needs an introduction today, we are proud to present MAMU’S INFUSION: Luxury Catering — a
                        premium extension of MAMU’S culinary legacy, dedicated exclusively to luxury catering and event
                        hospitality.</p>
                    <p class="section-text">Widely recognized as one of Jaipur’s most trusted and renowned culinary
                        brands, MAMU’S has built its reputation through decades of quality, consistency, and customer
                        satisfaction. MAMU’S INFUSION carries this legacy forward by delivering bespoke catering
                        experiences tailored for weddings, corporate events, private gatherings, and grand celebrations.
                    </p>
                </div>

                <div class="col-lg-6 text-center position-relative" data-aos="fade-left" data-aos-duration="2500">
                    <img src="{{$siteUrl}}public/img/about-img.jpg" class="img-fluid" alt="">
                    <img src="{{$siteUrl}}public/img/Since-bage.png" class="badge-img position-absolute" alt="">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-8 mx-auto" data-aos="fade-up" data-aos-duration="2000">
                    <p class="section-text text-center pt-5 mt-5 about-page">At MAMU’S INFUSION, we believe food is the centerpiece of every
                        memorable
                        occasion. Combining traditional Indian flavors with modern presentation and refined service, we
                        curate catering experiences that leave a lasting impression. From intimate celebrations to
                        large-scale events, our team is committed to delivering exceptional cuisine, elegant setups, and
                        seamless hospitality that elevate every event into an unforgettable experience.</p>
                    <div class="stats-counter-section pt-5">
                        <div class="stat-item text-center" data-aos="fade-up" data-aos-duration="1500">
                            <h2 class="stat-number"><span class="counter" data-target="500">0</span>+</h2>
                            <p class="stat-label">Successful Events</p>
                        </div>

                        <div class="stat-item text-center" data-aos="fade-up" data-aos-duration="2500">
                            <h2 class="stat-number"><span class="counter" data-target="10000">0</span>+</h2>
                            <p class="stat-label">Happy Guests</p>
                        </div>

                        <div class="stat-item text-center" data-aos="fade-up" data-aos-duration="3000">
                            <h2 class="stat-number"><span class="counter" data-target="35">0</span>+ years</h2>
                            <p class="stat-label">Catering Excellence</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <img src="{{$siteUrl}}public/img/verticle-bg.png" class="img-fluid verticle-img" alt="">

    <!-- Experience Section -->
    <section class="experience section-padding bg-experience">
        <div class="container-fluid px-0">
            <div class="row text-center mb-4">
                <div class="col-12 d-flex justify-content-center align-items-center flex-column" data-aos="fade-up" data-aos-duration="2000">
                    <h2 class="section-heading text-dark mb-4">What We <span class="text-gold">Do</span></h2>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12 col-lg-8">
                    <p class="experience__desc text-center" data-aos="fade-up" data-aos-duration="3000">
                        At MAMU'S INFUSION: Luxury Catering, we believe every celebration deserves to feel
                        extraordinary. From lavish weddings and elegant corporate events to intimate family gatherings,
                        we bring together exceptional cuisine, artistic presentation, and personalized hospitality to
                        create experiences that guests remember long after the event ends. Every detail is thoughtfully
                        curated by our team to reflect your vision, ensuring each occasion is not only seamless, but
                        truly magical.
                    </p>
                </div>
            </div>

            <div class="video-gallery mt-5">
                        <div class="video-card" data-aos="fade-up" data-aos-duration="2000">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="2500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3000">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video3.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video4.jpg" playsinline></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                    </div>
        </div>
    </section>
    <section class="services section-padding bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h2 class="section-heading text-dark mb-0">Our Vision <span class="text-gold">& Mission</span></h2>

                </div>
            </div>
            <div class="row vision-sec">
                <div class="col-md-6">
                    <div class="service-card" data-aos="fade-up" data-aos-duration="2000">
                        <div class="service-card__img">
                            <img src="{{$siteUrl}}public/img/vision.jpg" alt="Mehendi Event">
                        </div>
                        <h4 class="service-card__title mt-5">Vision</h4>
                        <p class="section-text mt-3 mb-0 p-0 text-start">At MAMU’S INFUSION: Luxury Catering, we believe
                            every celebration deserves
                            to feel extraordinary. From lavish weddings and elegant corporate events to
                            intimate family gatherings, we bring together exceptional cuisine</p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-up" data-aos-duration="3000">
                    <div class="service-card">
                        <div class="service-card__img">
                            <img src="{{$siteUrl}}public/img/mission.jpg" alt="Sangeet Event">
                        </div>
                        <h4 class="service-card__title mt-5">Mission</h4>
                        <p class="section-text mt-3 mb-0 p-0 text-start">At MAMU’S INFUSION: Luxury Catering, we believe
                            every celebration deserves
                            to feel extraordinary. From lavish weddings and elegant corporate events to
                            intimate family gatherings, we bring together exceptional cuisine</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="clients-marquee-section">
        <div class="container text-center" data-aos="fade-up" data-aos-duration="2000">
            <h2 class="section-heading text-center text-dark">Our Noteable <span class="text-gold">Clients</span></h2>
        </div>


        <div class="marquee" data-aos="fade-up" data-aos-duration="2500">
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
                <div class="col-md-4 p-0" data-aos="fade-right" data-aos-duration="2000">
                    <div class="director__img">
                        <img src="{{$siteUrl}}public/img/director.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img src="{{$siteUrl}}public/img/verticle-bg.png" class="director-svg" alt="">
    </section>
@endsection