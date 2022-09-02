<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">

<head>
    <meta charset="utf-8"/>
    <title>   @yield('title')  </title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="{{mix('dashboard/css/dashboard.css')}}" rel="stylesheet" type="text/css"/>
    <link  href="{{asset("dashboard/css/jalaliDatepicker.min.css")}}"type="text/css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('/dashboard/img/logo.png')}}">
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->

<!--begin::Header Mobile-->
    @include('agent.layout.mobile-header')
<!--end::Header Mobile-->

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        @include('agent.layout.sidebar')
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            @include('agent.layout.header' , ['name' => auth()->user()->full_name])
            <!--end::Header-->
            <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                @yield('subheader')
                <div class="d-flex flex-column-fluid">
                    @yield('content')
                </div>
            </div>
            @include('agent.layout.footer')
        </div>
        <!--end::Wrapper-->
    </div>
</div>
<!--end::Main-->
<script src="{{asset('./dashboard/js/plugins.js')}}"></script>
<script src="{{asset('./dashboard/js/scripts.js')}}"></script>
<script src="{{asset('./dashboard/js/widgets.js')}}"></script>
<script src="{{mix('dashboard/js/dashboard.js')}}"></script>
<script src="{{asset("dashboard/js/jalaliDatepicker.min.js")}}" type="text/javascript"></script>
<script>
    jalaliDatepicker.startWatch();
    $('input.number_sep').keyup(function(event) {

        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });
    });

    $('document').ready(function (){
        // format number
        $('input.number_sep').val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        });
    })
</script>
</body>

</html>
