<?php

use App\Configuration\GarlitoApiConfiguration;

$primary_color = GarlitoApiConfiguration::GARLITO_THEME_PRIMARY_COLOR;
?>

<html lang="en">
<head>
    <title>{{env('APP_NAME', '')}} - @yield('title')</title>

    <!-- Imported Stylesheets -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/garlito.css')}}" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

<div class="garlito-admin-layout">
    @include('garlito.layouts.admin.header')
    @include('garlito.layouts.admin.sidebar')
    @include('garlito.layouts.admin.main')
</div>

<!-- Imported Javascript -->
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('/js/garlito.js')}}"></script>
</body>
</html>

