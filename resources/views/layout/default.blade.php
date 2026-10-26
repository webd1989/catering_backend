@php
$siteUrl = env('APP_URL');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mamu's Infusion | Elevate Your Events</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&amp"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{$siteUrl}}public/css/style.css">
    <link rel="stylesheet" href="{{$siteUrl}}public/css/responsive.css">
    <link rel="stylesheet" href="{{$siteUrl}}public/css/sweet-alert.css">
    <link href="{{$siteUrl}}public/img/mamu-1favicon.ico?v=726" type="icon" rel="icon"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{$siteUrl}}public/js/sweet-alert.min.js"></script>
</head>

<body>

    @include('element.header')

    @yield('content')

    @include('element.footer');

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="{{$siteUrl}}public/js/custom.js"></script>
    

</body>

</html>