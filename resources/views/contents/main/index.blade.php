<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>{{ config('app.full_name') }}</title>
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_url')) }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if (config('app.env') == 'production')
        <!-- Meta -->
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://{{ config('app.url') }}" />
        <meta property="og:site_name" content="{{ config('app.full_name') }}" />
        <meta property="og:title" content="{{ config('app.full_name') }} | {{ config('app.url') }}">
        <meta property="og:description" content="{{ config('app.full_name') }}" />
        <meta name="description" content="{{ config('app.full_name') }}">
        <meta name="keywords" content="{{ config('app.full_name') }}">
        <meta name="googlebot" content="index, follow" />
        <meta name="robots" content="index, follow" />
        <meta name="slurp" content="all" />
        <meta name="publisher" content="{{ config('app.full_name') }}" />
        <meta name="author" content="{{ config('app.full_name') }}">
        <meta name="rating" content="general" />
        <meta name="revisit-after" content="1 days">
        <link rel="canonical" href="https://{{ config('app.url') }}" />
    @endif

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        html,
        body {
            font-family: "Courier New";
            height: 100%;
        }

        .in-middle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="in-middle text-center font-italic">
        Made with
        <img src="{{ asset('assets/images/logos/heart.gif') }}" alt="♡" height="15px" style="color: #E02542;">
        by {{ config('app.full_name') }}
    </div>
</body>

</html>
