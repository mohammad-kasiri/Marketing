@extends('agent.layout.master')
@section('title' , "پیشخوان اصلی" )
@section('headline', "پیشخوان اصلی")

@section('content')
    <div class="container-fluid mt-3">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-xl-4">
                    <!--begin::آمار Widget 18-->
                    <a class="card card-custom bg-info bg-hover-state-info card-stretch card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                        <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                            <x-dashboard.icons.svg.equalizer/>
                        </span>
                            <div class="text-inverse-dark font-weight-bolder font-size-h5 mb-2 mt-5">میزان فروش امروز</div>
                            <div class="font-weight-bold text-inverse-dark font-size-sm"> {{number_format($today_sum)}} تومان </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::آمار Widget 18-->
                </div>

                <div class="col-xl-4">
                    <!--begin::آمار Widget 18-->
                    <a class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                        <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                            <x-dashboard.icons.svg.equalizer/>
                        </span>
                            <div class="text-inverse-dark font-weight-bolder font-size-h5 mb-2 mt-5">میزان فروش این هفته</div>
                            <div class="font-weight-bold text-inverse-dark font-size-sm"> {{number_format($weekly_sum)}} تومان </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::آمار Widget 18-->
                </div>

                <div class="col-xl-4">
                    <!--begin::آمار Widget 18-->
                    <a class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                        <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                            <x-dashboard.icons.svg.equalizer/>
                        </span>
                            <div class="text-inverse-dark font-weight-bolder font-size-h5 mb-2 mt-5">میزان فروش از ابتدای ماه مالی</div>
                            <div class="font-weight-bold text-inverse-dark font-size-sm"> {{number_format($monthly_sum)}} تومان </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::آمار Widget 18-->
                </div>

            </div>

            <div class="row">
                <!-- Begin :: WEEKLY CHART -->
                <div class="col-xl-6">
                    <div class="card card-custom card-stretch gutter-b py-4">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <div class="d-flex flex-column mr-2">
                                    <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">فروش هفتگی</a>
                                    <span class="text-muted font-weight-bold mt-2"> {{number_format($weekly_sum)}}  تومان</span>
                                </div>
                            </div>
                            <div id="agent_total_weekly" data-user="{{auth()->id()}}" class="card-rounded-bottom" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <!-- end :: WEEKLY CHART -->
                <!-- Begin :: Monthly CHART -->
                <div class="col-xl-6">
                    <div class="card card-custom card-stretch gutter-b py-4">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <div class="d-flex flex-column mr-2">
                                    <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">فروش ماهانه</a>
                                    <span class="text-muted font-weight-bold mt-2"> {{number_format($monthly_sum)}} تومان </span>
                                </div>
                            </div>
                            <div id="agent_total_monthly" data-user="{{auth()->id()}}" class="card-rounded-bottom" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <!-- end :: Monthly CHART -->
            </div>

            <div class="row">
                <div class="@if($ranking) col-md-9 @else col-md-12 @endif">
                    <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">
                                    10 رسید   آخر
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table class="table ">
                                    <thead>
                                    <tr class="text-muted">
                                        <th class="text-center">#</th>
                                        <th class="text-center">عنوان</th>
                                        <th class="text-center">تاریخ تراکنش</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoices as $key=>$invoice)
                                        <tr>
                                            <td class="text-center align-middle"> {{ $key +1}} </td>
                                            <td class="text-center align-middle text-nowrap"> {{$invoice->price()}} تومان </td>
                                            <td class="text-center align-middle text-nowrap"> {{$invoice->paid_at()}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if($ranking)
                    <div class="col-md-3">
                        <div class="card card-custom">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        رنکینگ
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table class="table ">
                                        <thead>
                                        <tr class="text-muted">
                                            <th class="text-center">#</th>
                                            <th class="text-center">بازاریاب</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($usersRanking as $key=>$user)
                                            <tr   @if($key == 0) class="bg-light-success" @endif>
                                                <td class="text-center align-middle text-nowrap">
                                                    {{$key+1}}
                                                </td>
                                                <td class="text-center align-middle text-nowrap">
                                                    {{ $user->fullName }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection


