<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>
            SmartSchool App | {{ ucfirst(Request::segment(2)) }}
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/') }}">
        <link href="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/demo/demo7/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ asset('assets/demo/demo7/media/img/logo/favicon.ico') }}" />
        @stack('styles')
        <script>
            var base_url = "{{ url('/') }}/";
            var _token = "{{ csrf_token() }}";
        </script>
    </head>
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--fixed m-aside-left--offcanvas m-aside-left--minimize m-brand--minimize m-footer--push m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">

            <!-- BEGIN: Header -->
            @include('templates.header')
            <!-- END: Header -->  

            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

                <!-- BEGIN: Left Aside -->
                @include('templates.aside')
                <!-- END: Left Aside -->

                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <!-- BEGIN: Subheader -->
                    @include('templates.subheader')
                    <!-- END: Subheader -->

                    <div class="m-content">  
                        @yield('content')   
                    </div>
                </div>
            </div>
            <!-- end:: Body -->

            <!-- begin::Footer -->
            @include('templates.footer')
            <!-- end::Footer -->

        </div>
        <!-- end:: Page -->
                   
        <!-- begin::Quick Sidebar -->
        @include('templates.sidebar')
        <!-- end::Quick Sidebar -->  

        <!--begin::Base Scripts -->
        <script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/demo7/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <!--end::Base Scripts -->   
        <!--begin::Page Vendors -->
        <script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/custom/components/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/custom/components/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/custom/components/base/sweetalert2.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/custom/components/forms/widgets/select2.js') }}" type="text/javascript"></script>
        <!-- <script src="{{ asset('assets/custom/components/forms/widgets/typeahead.js') }}" type="text/javascript"></script> -->
        <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
        @if (\Request::is('dashboard') || \Request::is('applications/*'))  
        @else
            <script src="{{ asset('js/fixheader.js') }}" type="text/javascript"></script>
        @endif
        <script src="{{ asset('assets/vendors/easing/jquery.easing.1.3.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
        <!--end::Page Vendors -->  
        <!--begin::append script-->
        @stack('scripts')
        <!--end::append script-->
    </body>
</html>
