@php
$siteUrl = env('APP_URL');
@endphp
@extends('layout.default')
@section('content')
<div class="head-spcing"></div>
<section class="about section-padding ab-sec pt-5 position-relative">
        <div class="container">
            <div class="row align-items-center mt-5">
                <div class="col-md-10 mx-auto text-center" data-aos="fade-up" data-aos-duration="2000">
                    <h1 class="section-heading-main text-dark fw-bold">Our  <span class="text-gold">Services</span></h1>
                    <p class="section-text">At MAMU’s INFUSION , we’re not just about serving food; we’re about ensuring your event is seamless and unforgettable. With our experienced and dedicated team, we manage every detail of off-site catering and event planning, so you can relax and enjoy your celebration as a guest. From the very first impression to the lasting memories, our commitment is to turn every event into a truly exceptional experience!</p>                    
                </div>
            </div>
            <h2 class="section-heading service-heading text-center text-dark">Mehandi Event</h2>
            <div class="row service">
                <div class="col-md-12" data-aos="fade-up" data-aos-duration="3000">
                     <div class="video-gallery">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video3.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video4.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline ></video>
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
        <img src="{{$siteUrl}}public/img/verticle-bg.png" class="service-svg" alt="">
    </section>

      <section class="about ab-sec section-padding sangeet">
            <h2 class="section-heading service-heading text-center text-dark">Sangeet Event</h2>
            <div class="row">
                <div class="col-md-12">
                     <div class="video-gallery" data-aos="fade-up" data-aos-duration="2000">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="2500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3000">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video3.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video4.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="about ab-sec section-padding pt-5 position-relative  bg-white">
        <div class="container">
            <h2 class="section-heading service-heading text-center text-dark" data-aos="fade-up" data-aos-duration="2000">Luxury Catering </h2>
            <div class="row service">
                <div class="col-md-12">
                     <div class="video-gallery" data-aos="fade-up" data-aos-duration="2000">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="2500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3000">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video3.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video4.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="4000">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="4500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline ></video>
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
      <section class="section-padding sangeet-ex ">
            <h2 class="section-heading service-heading text-center mt-0 text-dark" data-aos="fade-up" data-aos-duration="2000">Sangeet Event</h2>
            <div class="row">
                <div class="col-md-12">
                     <div class="video-gallery" data-aos="fade-up" data-aos-duration="2000">
                        <div class="video-card">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video1.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="2500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video2.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3000">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video3.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>

                        <div class="video-card" data-aos="fade-up" data-aos-duration="3500">
                            <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video4.jpg" playsinline ></video>
                            <div class="play-btn">
                                <svg viewBox="0 0 24 24">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                        </div>
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
                                    <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video-test.jpg" playsinline ></video>
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
                                    <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video-test.jpg" playsinline ></video>
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
                                    <video src="{{$siteUrl}}public/img/video.mp4" poster="img/video-test.jpg" playsinline ></video>
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




    <section class="clients-marquee-section bg-white">
        <div class="container text-center" data-aos="fade-up" data-aos-duration="2000">
            <h2 class="section-heading text-center text-dark">Our Noteable <span class="text-gold">Clients</span></h2>
        </div>


        <div class="marquee" data-aos="fade-up" data-aos-duration="3000">
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