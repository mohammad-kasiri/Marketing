@extends('admin.layout.master')
@section('title' , " لیست پرونده ها ")
@section('headline', " لیست پرونده ها ")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'لیست پرونده ها'" />
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
            <div class="card card-custom mb-4">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            فیلتر پیشرفته
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.sales-case.index')}}">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <x-dashboard.form.row-input  name="fullname" type="text" label="نام مشتری" value="{{request()->input('fullname')}}"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.row-input  name="mobile" type="text" label="تلفن مشتری" value="{{request()->input('mobile')}}"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="وضعیت" name="status_id" searchable="1" >
                                    <option></option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}" {{request()->input('status_id') == $status->id ? 'selected' : ''}}>
                                            {{$status->name}}
                                        </option>
                                    @endforeach
                                </x-dashboard.form.select.row>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="ایجنت پرونده" name="agent_id" searchable="1" >
                                    <option></option>
                                    <option value="0">بدون ایجنت</option>
                                    @foreach($agents as $agent)
                                        <option value="{{$agent->id}}" {{request()->input('agent_id') == $agent->id ? 'selected' : ''}}>
                                            {{$agent->fullname}}
                                        </option>
                                    @endforeach
                                </x-dashboard.form.select.row>
                            </div>


                            <div class="col-md-8">
                                <button class="btn btn-primary float-right"> اعمال فیلتر </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @foreach($salesCases as $salesCase)
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

                                <small class="text-muted"> کد ایجاد: {{$salesCase->tag->title}}</small>
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
                                <a href="{{route('admin.sales-case.show', ['salesCase' => $salesCase])}}" class="btn btn-primary btn-block">جزئیات پرونده</a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            <!--end::Card-->
            <div class="text-center mt-5">
                {{$salesCases->appends([
                    'fullname'  => request()->input('fullname'),
                    'mobile'    => request()->input('mobile'),
                    'status_id' => request()->input('status_id'),
                    'agent_id'  => request()->input('agent_id')
                ])->render()}}
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection



