@extends('admin.layout.master' , ['title' => ' مشاهده ی پروفایل '])
@section('title' , 'مشاهده ی پروفایل')
@section('subheader')
    @php
        $buttons = [
            [
                'title'  =>  'لیست بازاریاب ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route'  =>  route('admin.agent.index') ,
                'color'  =>  'btn-light-warning'
             ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons' :title="' پروفایل ' . $agent->fullname" />
@endsection

@section('content')
    <!--begin::Entry-->
    <!--begin::Container-->
    <div class=" container ">
        <!--begin::پروفایل بررسی-->
        <div class="d-flex flex-row">
            <!--begin::Aside-->
            <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                <!--begin::پروفایل Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::User-->
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5  align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url('{{ $agent->avatar() }}')"></div>
                                <i class="symbol-badge bg-success"></i>
                            </div>
                            <div>
                                <p  class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                                    {{$agent->fullname}}
                                </p>
                                <div class="text-muted">
                                    جنسیت : {{$agent->gender()}}
                                </div>
                            </div>
                        </div>
                        <!--end::User-->

                        <!--begin::مخاطب-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">ایمیل:</span>
                                <a href="mailto:{{$agent->email ?? ''}}" class="text-muted text-hover-primary">{{$agent->email ? : 'وارد نشده'}}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">تلفن:</span>
                                <a href="tel:{{$agent->mobile}}" class="text-muted text-hover-primary">{{$agent->mobile}}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">آخرین ورود:</span>
                                <p class="text-muted text-hover-primary">{{$agent->last_login()}}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">تاریخ عضویت:</span>
                                <p class="text-muted text-hover-primary">{{$agent->created_at()}}</p>
                            </div>
                        </div>
                        <!--end::مخاطب-->

                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                            <div class="navi-item mb-2">
                                <a href="{{route('admin.agent.show' , $agent->id)}}" class="navi-link py-4 active">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/desgin/Layers.svg-->
                                                <x-dashboard.icons.svg.user/>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text font-size-lg">
                                        اطلاعات کلی
                                    </span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a  href="{{route('admin.agent.edit' , $agent->id)}}" class="navi-link py-4 ">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/عمومی/User.svg-->
                                            <x-dashboard.icons.svg.edit/>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">
                                    ویرایش کاربر
                                </span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a  href="{{route('admin.agent.invoice.index' , ['agent' =>  $agent->id])}}" class="navi-link py-4 ">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/عمومی/User.svg-->
                                            <x-dashboard.icons.svg.money/>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">
                                    رسید   های کاربر
                                </span>
                                </a>
                            </div>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::پروفایل Card-->
            </div>
            <!--end::Aside-->

            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::پیشرفت Table: Widget 7-->
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">عملکرد کاربر</span>
                        </h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-2">
                        <div class="row">
                            <!-- Begin :: WEEKLY CHART -->
                            <div class="col-xl-6">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex flex-column p-0">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <div class="d-flex flex-column mr-2">
                                                <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">فروش هفتگی</a>
                                            </div>
                                        </div>
                                        <div id="agent_weekly" data-user="{{$agent->id}}" data-percentage="{{$agent->percentage}}" class="card-rounded-bottom" style="height: 150px"></div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <!-- end :: WEEKLY CHART -->
                            <!-- Begin :: Monthly CHART -->
                            <div class="col-xl-6">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex flex-column p-0">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <div class="d-flex flex-column mr-2">
                                                <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">فروش ماهانه</a>
                                            </div>
                                        </div>
                                        <div id="agent_monthly" data-user="{{$agent->id}}" data-percentage="{{$agent->percentage}}" class="card-rounded-bottom" style="height: 150px"></div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <!-- end :: Monthly CHART -->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::پیشرفت Table Widget 7-->
                <!--begin::پیشرفت Table: Widget 7-->
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">10 رسید   آخر</span>
                        </h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-2">
                        <!--begin::Table-->
                        <div class="table-responsive-sm">
                            <table class="table ">
                                <thead>
                                <tr class="text-muted">
                                    <th class="text-center">مبلغ</th>
                                    <th class="text-center">چهار رقم آخر شماره کارت</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">تاریخ واریز</th>
                                    <th class="text-center">توضیحات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $key=>$invoice)
                                    <tr>
                                        <td class="text-center align-middle text-nowrap"> {{$invoice->price() }}  تومان </td>
                                        <td class="text-center align-middle text-nowrap"> {{$invoice->account_number}} </td>
                                        <td class="text-center align-middle text-nowrap
                                        @if($invoice->status == 'sent')
                                            text-warning
                                        @elseif($invoice->status == 'rejected')
                                            text-danger
                                        @elseif($invoice->status == 'approved')
                                            text-success
                                        @endif"> {{$invoice->status()}} </td>
                                        <td class="text-center align-middle text-nowrap"> {{$invoice->paid_at()}} </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button class="btn btn-outline-danger"
                                                    data-container="body"
                                                    data-delay="500"
                                                    data-toggle="popover"
                                                    data-placement="top"
                                                    data-content="{{$invoice->description}}">توضیحات</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::پیشرفت Table Widget 7-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::پروفایل بررسی-->
    </div>
    <!--end::Entry-->
@endsection
