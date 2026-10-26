@php
$siteUrl = env('APP_URL');
@endphp
    
    <header class="header">
        <div class="">
            <div class="header__inner">
                <div class="header__logo">
                    <a href="{{route('index')}}">
                        <img src="{{$siteUrl}}public/img/logo.svg" alt="Mamu's Infusion Logo">
                    </a>
                </div>
                <input id="menu-toggle" type="checkbox" />
                <label class='menu-button-container' for="menu-toggle">
                    <div class='menu-button'></div>
                </label>
                <ul class="header__menu menu">
                    <li><a href="{{route('index')}}" class="active">HOME</a></li>
                    <li><a href="{{route('aboutUs')}}">ABOUT US</a></li>
                    <li><a href="#">WEDDINGS</a></li>
                    <li><a href="#">EXPERIENCES</a></li>
                    <li><a href="{{route('services')}}">SERVICES</a></li>
                    <li><a href="{{route('gallery')}}">GALLERY</a></li>
                    <li><a href="{{route('contactUs')}}">CONTACT</a></li>
                </ul>

                <div class="header__actions">
                    <a href="tel:+919829050290" class="header__phone"><img src="{{$siteUrl}}public/img/phone.svg" alt=""> &nbsp; <span>+91-9829050290</span></a>
                    <a href="{{route('contactUs')}}" class="btn view-all-btn btn--primary">PLAN YOUR EVENT</a>
                </div>
            </div>
        </div>
    </header>