<header class="admin-header d-flex align-items-center justify-content-between">
    <a class="d-none d-sm-none d-md-flex d-lg-flex d-xl-flex d-xxl-flex" href="{{url('dashboard')}}">
        <img class="logo" src="{{asset('images/branding/logo.png')}}" alt="Logo">
    </a>

    <a class="d-flex d-sm-flex d-md-none d-lg-none d-xl-none d-xxl-none" href="{{url('dashboard')}}">
        <img class="logo" src="{{asset('images/branding/logo-mobile.png')}}" alt="Logo">
    </a>
   @include('garlito.layouts.admin.menu')
</header>
