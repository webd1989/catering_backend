@php
$siteUrl = env('APP_URL');
@endphp
@extends('layout.default')
@section('content')
<style>
.section-padding{ padding:30px 0px;}
</style>
<div class="head-spcing"></div>
    <section class="gallery section-padding ">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
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