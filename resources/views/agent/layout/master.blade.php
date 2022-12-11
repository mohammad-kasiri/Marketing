<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">

<head>
    <meta charset="utf-8"/>
    <title>   @yield('title')  </title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="refresh" content="240">
    <link href="{{mix('dashboard/css/dashboard.css')}}" rel="stylesheet" type="text/css"/>
    <link  href="{{asset("dashboard/css/jalaliDatepicker.min.css")}}" type="text/css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('/dashboard/img/logo.png')}}">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
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
                    <!-- مودال-->
                    <div class="modal fade" id="callmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Incoming Call</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="نزدیک">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <i class="fa fa-phone  text-warning icon-3x d-block my-5"></i>
                                    <span> تماس ورودی از </span><span id="contactName"></span>
                                    :
                                    <br>
                                    <h4 id="contactPhone" class="text-center my-5">09109529484</h4>
                                </div>
                                <div class="modal-footer">
                                    <a id="contactProfile" class="btn btn-primary font-weight-bold">مشاهده پروفایل</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    setInterval(get_fb, 3000);
    function get_fb(){
       $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{route('agent.call.check')}}",
            async: false,
           success: function(data){
                let status= data.status
                if(status === 100)
                {
                     $('#contactName').text(data.name);
                     $('#contactPhone').text(data.mobile);
                     $('#contactProfile').attr('href', 'https://panel.studio-mim.com/agent/customer/' + data.id);
                     $('#callmodal').modal().show();
                }
           }
       });
    }
</script>
@yield('script')
</body>

</html>
