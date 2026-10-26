@php
$siteUrl = env('APP_URL');
@endphp
@extends('layout.default')
@section('content')
<div class="head-spcing"></div>
<section class="about section-padding ab-sec pt-5">
        <div class="container">
            <div class="row align-items-center mt-5">
                <div class="col-md-10 mx-auto text-center" data-aos="fade-up" data-aos-duration="2000">
                    <h1 class="section-heading-main text-dark fw-bold">Contact <span class="text-gold">Us</span></h1>
                    <p class="section-text">Share your event details and let us craft a menu that delights every guest and fits your vision perfectly.</p>                    
                </div>
            </div>

            <div class="row g-4 contact align-items-stretch mt-5">
            
            <div class="col-lg-7">
                <div class="card custom-rounded" data-aos="fade-right" data-aos-duration="2500">
                    <h4 class="text-gold mb-2">Get in Touch</h4>
                    <h2 class="serif-heading my-3 fw-bold">Let's Chat, Reach Out to Us</h2>
                    <p class="mb-4">Fill out the form below and our team will get back to you with a personalized proposal within 24 hours.</p>

                    <form id="contactForm" class="">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control custom-input" id="firstname" name="firstname" placeholder="Enter first name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control custom-input" id="lastname" name="lastname" placeholder="Enter last name">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control custom-input" id="email_address" name="email_address" placeholder="Enter email id">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Phone No.</label>
                            <input type="tel" class="form-control custom-input" id="phone" name="phone" maxlength="10" placeholder="Enter phone no">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea class="form-control custom-input" rows="4" id="message" name="message" placeholder="Enter Message"></textarea>
                        </div>
                        
                        <a id="contactSubmit" class="btn btn--primary">SUBMIT</a>
                    </form>
                </div>
            </div>

            <div class="col-lg-5 d-flex flex-column gap-4">
                
                <div class="card border-0 p-0 custom-rounded overflow-hidden image-wrapper" data-aos="fade-up" data-aos-duration="2000">
                    <img src="{{$siteUrl}}public/img/contact-img.jpg" alt="Customer Support Agent" class="img-fluid object-fit-cover">
                </div>

                <div class="card border-0 shadow-sm p-4 custom-rounded bg-white" data-aos="fade-up" data-aos-duration="3000">
                    <h4 class="serif-heading mb-4 fs-5">Connect with us via:</h4>

                    <div class="info-box d-flex align-items-center">
                        <div class="icon-circle bg-white d-flex justify-content-center align-items-center rounded-circle">
                            <img src="{{$siteUrl}}public/img/mail.svg" alt="">
                        </div>
                        <div>
                            <h6 class="mb-0 ">Email</h6>
                            <a href="mailto:mamusinfusioncatering@gmail.com" class="text-decoration-none text-dark small">mamusinfusioncatering@gmail.com</a>
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="icon-circle d-flex justify-content-center align-items-center rounded-circle">
                           <img src="{{$siteUrl}}public/img/call.svg" alt="">    
                        </div>
                        <div>
                            <h6 class="mb-0 ">Phone Number</h6>
                            <a href="tel:+919829050290" class="text-decoration-none text-dark small">+91 98290 50290</a>
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </div>
    </section>

    <section class="clients-marquee-section bg-white" data-aos="fade-up" data-aos-duration="2000">
        <div class="container text-center">
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
    <script type="text/javascript">	
	$(document).ready(function(){	
		$('#contactSubmit').click(function(e){

			$('#contactSubmit').html('Processing...');
			$.ajax({
				type: 'POST',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{route('saveContact')}}",
				data: $('#contactForm').serialize(),
				success: function(msg){
					$('#contactSubmit').html('SUBMIT');
					var obj = JSON.parse(msg);
					if(obj.success){
						$('#firstname').val('');
						$('#lastname').val('');
						$('#email_address').val('');
						$('#phone').val('');
						$('#message').val('');
						swal("Success!", obj.message, "success");
					}else{
						showMessage(obj.message);
					return false;
					}
				},error: function(ts) {
					showMessage('Something went wrong, please try after sometime.');
					return false;
				}
			});
			return false;
			
		});
	});	
	function showMessage(msg){
		swal("Error!", msg, "error");
	}
</script> 
@endsection