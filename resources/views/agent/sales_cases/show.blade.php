@extends('agent.layout.master')
@section('title' , " جزئیات پرونده  ")
@section('headline', " جزئیات پرونده ها ")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'جزئیات پرونده '" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom @if($salesCase->is_promoted)  border border-left-warning border-3 @endif mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h5>لیست محصولات پرونده فروش</h5>
                                <ul>
                                    @foreach($salesCase->products as $product)
                                        <li>{{$product->title}}</li>
                                    @endforeach
                                </ul>

                                <small class="text-muted"> کد ایجاد: {{$salesCase->group_tag}}</small>
                            </div>
                            <div class="col-md-3 py-5">
                                <a href="{{ route('agent.customer.show', ['customer' => $salesCase->customer_id]) }}" class="h6 mr-3 text-muted">کاربر پرونده:<span class="text-black h6">{{$salesCase->customer->fullname}}</span></a>
                                <br><br>
                                <span class="h6 mr-3 text-muted">تلفن کاربر:</span><span class="h6">{{$salesCase->customer->mobile}}</span>
                                <br><br>
                                <span class="h6 mr-3 text-muted">ایجنت پرونده:</span><span class="h6">{{!is_null($salesCase->agent) ? $salesCase->agent->fullname : 'بدون ایجنت'}}</span>
                            </div>
                            <div class="col-md-3 py-5">
                                <span class="h6 mr-3 text-muted">تاریخ ایجاد پرونده:</span><span class="h6">{{$salesCase->created_at()}}</span>
                                <br><br>
                                <span class="h6 mr-3 text-muted">آخرین ویرایش:</span><span class="h6">{{$salesCase->updated_at()}}</span>
                            </div>
                            <div class="col-md-3 py-5">
                                <a href="tel:{{$salesCase->customer->mobile}}" class="btn btn-success btn-block"> <i class="fas fa-phone mr-2"></i> تماس با کاربر </a>
                                <br>
                                <a  onclick="copyToClipboard('{{$salesCase->customer->mobile}}')"  class="btn btn-danger btn-block">
                                    <i class="far fa-copy mr-2"></i>کپی شماره تماس
                                </a>
                                <br>
                                <a href="https://wa.me/{{Illuminate\Support\Str::replaceFirst('0', '98', $salesCase->customer->mobile)}}" class="btn btn-success btn-block"> <i class="fab fa-whatsapp mr-2"></i> ارتباط در واتس اپ</a>
                                <br>
                                <a href="{{route('agent.task.create', ['salesCase' => $salesCase->id])}}" class="btn btn-primary btn-block">
                                    <i class="far fa-bell mr-2"></i>افزودن کار و یادآور
                                </a>
                                <br>
                                <a href="{{ route('agent.customer.show', ['customer' => $salesCase->customer_id]) }}" class="btn btn-info btn-block">
                                    <i class="far fa-user mr-2"></i>مشاهده پروفایل
                                </a>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-content-stretch my-5">
           <div class="col-md-6">
               <div class="card card-custom mb-4 h-100">
                   <div class="card-header flex-wrap border-0 pt-6 pb-0">
                       <div class="card-title">
                           <h3 class="card-label">
                               پیامک
                           </h3>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('agent.sales-case.send-sms', ['salesCase' => $salesCase->id])}}" method="post">
                           @csrf
                           <div class="row">
                               <div class="col-12">
                                   <x-dashboard.form.text.textarea label="متن پیامک" name="sms"/>
                                   {{-- <x-dashboard.form.select.row label="متن پیام" name="sms_id">--}}
                                   {{--     @foreach($smsTemplates as $sms)--}}
                                   {{--         <option value="{{$sms->id}}">{{$sms->text}}</option>--}}
                                   {{--     @endforeach--}}
                                   {{-- </x-dashboard.form.select.row>--}}
                               </div>
                           </div>
                           <div class="float-right">
                               <button class="btn btn-primary btn-block" type="submit">ارسال</button>
                           </div>
                       </form>
                       <div class="row">
                           @foreach($smsLogs as $smsLog)
                               <div class="card card-custom">
                                   <div class="card-header">
                                       <div class="card-title">
                                           <h3 class="card-label">
                                               {{$smsLog->agent->fullname}}
                                               <small>فرستنده</small>
                                           </h3>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <p>{{$smsLog->text}}</p>
                                   </div>
                                   <div class="card-footer">
                                       <a class="btn btn-outline-secondary font-weight-bold">{{$smsLog->created_at()}}</a>
                                   </div>
                               </div>
                           @endforeach
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-md-6">
               <div class="card card-custom mb-4 h-100">
                   <div class="card-header flex-wrap border-0 pt-6 pb-0">
                       <div class="card-title">
                           <h3 class="card-label">
                               جریان فروش
                           </h3>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('agent.sales-case.status', ['salesCase' => $salesCase->id])}}" method="post">
                           @csrf
                           <div class="row justify-content-center my-3">
                               <div class="col-12">
                                   <x-dashboard.form.select.row name="status_id"   label="وضعیت جدید">
                                       @foreach($salesCaseStatusRules as $status)
                                           <option {{$salesCase->status_id == $status->toStatus->id ? 'selected' : ''}} value="{{$status->toStatus->id}}">{{$status->toStatus->name}}</option>
                                       @endforeach
                                   </x-dashboard.form.select.row>
                               </div>
                               @if($salesCase->status->is_before_last_step)
                                   <a href="{{route('agent.invoice.create', ['salesCase' => $salesCase->id])}}" class="btn btn-success
                                        @if($salesCase->invoice_id != null)
                                            disabled
                                        @endif
                                   ">لینک کردن به رسید</a>
                               @elseif($salesCase->status->	is_last_step)
                                   <a class="btn btn-success disabled">فروش به پایان رسید</a>
                               @else
                                    <div class="col-12">
                                        <x-dashboard.form.row-input  name="description"   label=" توضیح تغییر وضعیت" />
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary float-right" type="submit">ارسال</button>
                                    </div>
                               @endif
                           </div>
                       </form>
                       @foreach($salesCaseStatusHistories as $history)
                           <div class="row">
                               <div class="col-12 my-5">
                                    <p>{{$history->status->name}}</p>
                                    <span class="text-muted d-block">{{$history->description}}</span>
                                    <span class="text-muted float-right">{{$history->created_at()}}</span>
                                    <span class="text-muted float-left">{{$history->user->full_name}}</span>
                               </div>
                           </div>
                       @endforeach
                   </div>
               </div>
           </div>
        </div>
        <div class="row my-5 d-flex align-content-stretch">
            <div class="col-md-4">
                <div class="card card-custom mb-4 h-100">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                توضیحات پرونده
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('agent.sales-case.description', ['salesCase' => $salesCase->id])}}" method="post" class="mb-5">
                            @csrf
                            <x-dashboard.form.text.textarea label="توضیحات" name="description" />
                            <button class="btn btn-primary btn-block">
                                ثبت توضیح
                            </button>
                        </form>
                        <p class="mt-5">
                            {!! $salesCase->description !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom mb-4 h-100">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                توضیحات مدیریت
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="my-5">
                            {!! $salesCase->admin_note !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom mb-4 bg-light-danger h-100">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label ">
                                بستن پرونده
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(is_null($salesCase->failure_reason_id))
                            <form action="{{route('agent.sales-case.close', ['salesCase' => $salesCase->id])}}" method="post" class="mb-5">
                                @csrf
                                <x-dashboard.form.select.row name="failure_reason_id"  label="علت شکست">
                                    @foreach($failureReasons as $reason)
                                        <option {{$salesCase->failure_reason_id  == $reason->id}}
                                                value="{{$reason->id}}">
                                            {{$reason->title}}
                                        </option>
                                    @endforeach
                                </x-dashboard.form.select.row>
                                <x-dashboard.form.text.textarea label="توضیح علت شکست فروش" name="failure_reason" />
                                <button class="btn btn-primary btn-block">
                                    ثبت توضیح
                                </button>
                            </form>
                        @else
                            <form action="{{route('agent.sales-case.open', ['salesCase' => $salesCase->id])}}" method="post" class="my-5">
                                @csrf
                                <button name="open" value="open" class="btn btn-success btn-block">بازکردن مجدد</button>
                            </form>
                        @endif
                        <b class="mt-5">علت شکست فروش:</b>
                        {{$salesCase->failure_reason}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function copyToClipboard(number)
    {
        navigator.clipboard.writeText(number);
        Swal.fire(
            'حله !',
            'شماره تماس کاربر کپی شد.',
            'success'
        )
    }
</script>


{{--<div class="card card-custom mb-4">--}}
{{--    <div class="card-header flex-wrap border-0 pt-6 pb-0">--}}
{{--        <div class="card-title">--}}
{{--            <h3 class="card-label">--}}

{{--            </h3>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="card-body">--}}

{{--    </div>--}}
{{--</div>--}}


