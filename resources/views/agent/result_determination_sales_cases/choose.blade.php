@extends('agent.layout.master')
@section('title' , "انتخاب رسید" )
@section('headline',  "انتخاب رسید")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="' انتخاب رسید '" />
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

            <div class="card card-custom @if($salesCase->failure_reason_id)bg-light-danger @endif @if($salesCase->is_promoted) border border-left-warning border-5 @endif mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>لیست محصولات پرونده فروش</h5>
                            <ul>
                                @foreach($salesCase->products as $product)
                                    <li>{{$product->title}}</li>
                                @endforeach
                            </ul>

                            <small class="text-muted"> کد ایجاد: {{$salesCase->tag?->title}}</small>
                        </div>
                        <div class="col-md-4 py-5">
                            <span class="h6 mr-3 text-muted">کاربر پرونده:</span><span class="h6">{{$salesCase->customer->fullname}}</span>
                            <br><br>
                            <span class="h6 mr-3 text-muted">ایجنت پرونده:</span><span class="h6">{{!is_null($salesCase->agent) ? $salesCase->agent->fullname : 'بدون ایجنت'}}</span>
                            <br><br>
                            <span class="h6 mr-3 text-muted">تاریخ ایجاد پرونده:</span><span class="h6">{{$salesCase->created_at()}}</span>
                            <br><br>
                            <span class="h6 mr-3 text-muted">آخرین ویرایش:</span><span class="h6">{{$salesCase->updated_at()}}</span>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-{{$salesCase->status->color}} btn-block">
                                <img src="{{$salesCase->status->icon()}}"  class="mx-auto d-block pb-4"/>
                                <a class="text-white font-weight-bold font-size-h6 mx-auto">
                                    {{$salesCase->status->name}}
                                </a>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger btn-block"
                                    @if(is_null($salesCase->admin_note)) disabled @endif
                                    data-container="body"
                                    data-delay="500"
                                    data-toggle="popover"
                                    data-placement="top"
                                    data-html="true"
                                    data-content="{!! $salesCase->admin_note ?? "خالی" !!}">توضیحات مدیر</button>
                            <br>
                            <button class="btn btn-info btn-block"
                                    @if(is_null($salesCase->description)) disabled @endif
                                    data-container="body"
                                    data-delay="500"
                                    data-toggle="popover"
                                    data-placement="top"
                                    data-html="true"
                                    data-content="{!! $salesCase->description ?? "خالی" !!}">یادداشت ایجنت</button>
                            <br>
                            <a href="{{route('agent.sales-case.show', ['salesCase' => $salesCase])}}" class="btn btn-primary btn-block">جزئیات پرونده</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-custom my-3">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                           انتخاب رسید
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                                <tr class="text-muted">
                                    <th class="text-center">#</th>
                                    <th class="text-center">محصول</th>
                                    <th class="text-center">مبلغ</th>
                                    <th class="text-center">مقصد</th>
                                    <th class="text-center">توضیحات</th>
                                    <th class="text-center">تاریخ ایجاد رسید</th>
                                    <th class="text-center">تاریخ پرداخت</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key=>$invoice)
                                <tr>
                                    <td class="text-center align-middle"> {{ $key + 1 }} </td>
                                    <td  class="text-center align-middle">
                                        @foreach($invoice->products as $product)
                                            -   {{$product->title}}   -
                                        @endforeach
                                    </td>
                                    <td class="text-center align-middle text-nowrap"> {{$invoice->price()}} تومان </td>
                                    <td class="text-center align-middle text-nowrap">
                                        @if($invoice->paid_by == 'card')
                                            <i class="fab fa-cc-visa"></i>
                                            {{ $invoice->account_number}}
                                        @endif

                                        @if($invoice->paid_by == 'gateway')
                                            <i class="fas fa-warehouse"></i>
                                            {{ $invoice->gateway_tracking_code}}
                                        @endif

                                        @if($invoice->paid_by == 'site')
                                            <i class="fas fa-globe-americas"></i>
                                            {{ $invoice->order_number}}
                                        @endif

                                    </td>
                                    <td class="text-center align-middle text-nowrap
                                               text-{{$invoice->status_color()}}">
                                        {{$invoice->status()}}
                                    </td>
                                    <td class="text-center align-middle text-nowrap"> {{$invoice->created_at()}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$invoice->paid_at()}} </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button class="btn btn-outline-danger"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="{{$invoice->description}}">توضیحات</button>
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <form action="{{route('agent.result-determination.submit-invoice' , ['salesCase' => $salesCase->id, 'invoice' => $invoice->id])}}" method="post" class="d-inline">
                                            @csrf
                                            <button
                                                class="btn btn-sm btn-outline-success"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="لینک کردن">

                                                <i class="fas fa-link"></i>
                                                لینک کردن پرونده به این رسید
                                            </button>
                                        </form>
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
