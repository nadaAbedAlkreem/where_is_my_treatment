<!DOCTYPE html>

<html lang="ar" dir="rtl">
<!--begin::Head-->
<head><base href="../../">
    <title>أين علاجي؟ - تطبيق العثور على العيادات والخدمات الطبية</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="where my treatment" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="ar_SA" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="where my treatment" />
    <meta property="og:site_name" content="where my treatment" />
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
    <!--begin::Fonts-->
   @include('dashboard.assets.css')

</head>
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('dashboard.layout.header._base')
            @include('dashboard.layout.aside._base')
            <div class="d-flex flex-column flex-column-fluid container-fluid">

            @yield('content')
            @include('dashboard.layout.footer._base')
            </div>

        </div>

    </div>
    <!--end::Page-->
</div>


@include('dashboard.assets.js')

</body>
<!--end::Body-->
</html>



