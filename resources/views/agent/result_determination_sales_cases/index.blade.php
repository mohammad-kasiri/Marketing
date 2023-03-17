@extends('agent.layout.master')
@section('title' , "تعیین تکلیف رسید ها" )
@section('headline',  "تعیین تکلیف رسید ها")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="' تعیین تکلیف رسید ها'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Notice-->
            @if(\Illuminate\Support\Facades\Session::has('message'))
                <div class="alert alert-custom alert-light-success fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="flaticon2-checkmark"></i></div>
                    <div class="alert-text">{{\Illuminate\Support\Facades\Session::get('message')}}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="نزدیک">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="row my-3">
                <div class="col-md-12">
                    <a class="btn btn-warning btn-block" href="#stagnant">لیست پرونده های راکد</a>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست پرونده های نیاز به تعیین تکلیف
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                                <tr class="text-muted">
                                    <th class="text-center">#</th>
                                    <th class="text-center">نام مشتری</th>
                                    <th class="text-center">محصول</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">کد ایجاد</th>
                                    <th class="text-center">آخرین ویرایش</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($awaitingForResultDeterminationSalesCases as $key=>$salesCases)
                                <tr>
                                    <td  class="text-center">{{$key+1}}</td>
                                    <td  class="text-center">{{$salesCases->agent->fullname}}</td>
                                    <td  class="text-center">
                                        @foreach($salesCases->products as $product)
                                           -   {{$product->title}}   -
                                        @endforeach
                                    </td>
                                    <td  class="text-center">{{$salesCases->status->name}}</td>
                                    <td  class="text-center">{{$salesCases->tag->title}}</td>
                                    <td  class="text-center">{{$salesCases->updated_at()}}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <a href="{{route('agent.result-determination.choose-invoice' , $salesCases->id)}}"
                                           class="btn btn-outline-info"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="مشاهده">
                                            <i class="far fa-check-circle"></i>
                                            انتخاب رسید
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card card-custom my-5 pt-5" id="stagnant">
                <br><br>
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست پرونده های راکد
                        </h3>
                    </div>
                    <div class="card-subtitle mt-5">
                        <h3 class="card-label text-muted">
                            (از آخرین ویرایش این پرونده ها بیش از دو ماه میگذرد.امیدواریم با پیشبرد فروش این پرونده ها و تعیین وضعیت به مرحله ی فروش موفق برسیم.)
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">نام مشتری</th>
                                <th class="text-center">محصول</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">کد ایجاد</th>
                                <th class="text-center">آخرین ویرایش</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stagnantSalesCases as $key=>$salesCases)
                                <tr>
                                    <td  class="text-center">{{$key+1}}</td>
                                    <td  class="text-center">{{$salesCases->agent->fullname}}</td>
                                    <td  class="text-center">
                                        @foreach($salesCases->products as $product)
                                            -   {{$product->title}}   -
                                        @endforeach
                                    </td>
                                    <td  class="text-center">{{$salesCases->status->name}}</td>
                                    <td  class="text-center">{{$salesCases->tag->title}}</td>
                                    <td  class="text-center">{{$salesCases->updated_at()}}</td>
                                    <td class="text-center align-middle text-nowrap">

                                        <a href="{{route('agent.sales-case.show', ['salesCase' => $salesCases])}}"
                                           class="btn btn-outline-primary"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="مشاهده پرونده">
                                            <i class="far fa-check-circle"></i>
                                            مشاهده پرونده
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection
