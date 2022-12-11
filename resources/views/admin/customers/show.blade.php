@extends('admin.layout.master' , ['title' => 'پروفایل مشتری'])
@section('title' , 'پروفایل مشتری')
@section('subheader')
    @php
        $buttons = [
            [
                'title'  =>  'لیست مشتری ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route'  =>  route('admin.customer.index') ,
                'color'  =>  'btn-light-warning'
             ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons' :title="' پروفایل ' . $customer->fullname" />
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
                                <div class="symbol-label " style="background-image:url('{{ $customer->genderIcon() }}')"></div>
                                <i class="symbol-badge bg-success"></i>
                            </div>
                            <div>
                                <p  class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                                    {{$customer->fullname}}
                                </p>
                                <div class="text-muted">
                                    جنسیت : {{$customer->gender()}}
                                </div>
                            </div>
                        </div>
                        <!--end::User-->

                        <!--begin::مخاطب-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">ایمیل:</span>
                                <a href="mailto:{{$customer->email ?? ''}}" class="text-muted text-hover-primary">{{$customer->email ? : 'وارد نشده'}}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">تلفن:</span>
                                <a href="tel:{{$customer->mobile}}" class="text-muted text-hover-primary">{{$customer->mobile}}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold">ایجاد:</span>
                                <p class="text-muted text-hover-primary">{{$customer->created_at()}}</p>
                            </div>
                        </div>
                        <!--end::مخاطب-->

                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                            <div class="navi-item mb-2">
                                <a href="{{route('admin.customer.show' , $customer->id)}}" class="navi-link py-4 active">
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
                                <a  href="{{route('admin.customer.edit' , $customer->id)}}" class="navi-link py-4 ">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/عمومی/User.svg-->
                                            <x-dashboard.icons.svg.edit/>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">
                                        ویرایش پروفایل
                                    </span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a  href="{{route('admin.customer.calllog' , $customer->id)}}" class="navi-link py-4 ">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/عمومی/User.svg-->
                                            <x-dashboard.icons.svg.outgoing/>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">
                                       تاریخچه تماس
                                    </span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a  href="{{route('admin.customer.smslog' , $customer->id)}}" class="navi-link py-4 ">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/عمومی/User.svg-->
                                            <x-dashboard.icons.svg.chat4/>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">
                                       تاریخچه پیامک
                                    </span>
                                </a>
                            </div>
                            {{--                            <div class="navi-item mb-2">--}}
                            {{--                                <a  href="{{route('admin.agent.invoice.index' , ['agent' =>  $customer->id])}}" class="navi-link py-4 ">--}}
                            {{--                                <span class="navi-icon mr-2">--}}
                            {{--                                    <span class="svg-icon">--}}
                            {{--                                        <!--begin::Svg Icon | path:assets/media/svg/icons/عمومی/User.svg-->--}}
                            {{--                                            <x-dashboard.icons.svg.money/>--}}
                            {{--                                        <!--end::Svg Icon-->--}}
                            {{--                                    </span>--}}
                            {{--                                </span>--}}
                            {{--                                    <span class="navi-text font-size-lg">--}}
                            {{--                                    رسید   های کاربر--}}
                            {{--                                </span>--}}
                            {{--                                </a>--}}
                            {{--                            </div>--}}
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
                <div class="row">
                    @foreach($salesCases as $salesCase)
                        <div class="col-12">
                            <div class="card card-custom @if($salesCase->failure_reason_id)bg-light-danger @endif @if($salesCase->is_promoted) border border-left-warning border-5 @endif mt-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5>لیست محصولات پرونده </h5>
                                            <ul>
                                                @foreach($salesCase->products as $product)
                                                    <li>{{$product->title}}</li>
                                                @endforeach
                                            </ul>

                                            <small class="text-muted"> کد ایجاد: {{$salesCase->tag->title}}</small>
                                        </div>
                                        <div class="col-md-4 py-5">
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
                                            <a href="{{route('admin.sales-case.show', ['salesCase' => $salesCase])}}" class="btn btn-primary btn-block">جزئیات پرونده</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::پروفایل بررسی-->
    </div>
    <!--end::Entry-->
@endsection
