<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="Aplikasi pendataan peroleh bantuan sosial" />
    <meta name="keywords" content="sosial,bantuan,bondowoso" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="Aplikasi" />
    <meta property="og:title" content="Aplikasi data sosial  &amp; Kabupaten Bondowoso" />
    <meta property="og:url" content="http://koperasi.test" />
    <meta property="og:site_name" content="@yield('title') | {{ config('app.name') }}" />
    <link rel="canonical" href="data sosial" />
    <link rel="shortcut icon" href="{{ url('/assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--end::Vendor Stylesheets-->
    @stack('css')
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
@yield('content_master')
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ url('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

@stack('js')
<!--begin::Custom Javascript(used for this page only)-->

<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
