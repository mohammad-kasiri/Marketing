@extends('admin.layout.master')
@section('title' , " لیست رسید   ها ")
@section('headline', "لیست رسید   ها")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'لیست رسید   ها'" />
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
                    <form action="{{route('admin.invoice.index')}}">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="کاربر" name="user" searchable="1" >
                                    <option></option>
                                   @foreach($users as $user)
                                         <option value="{{$user->id}}" {{request()->input('user') == $user->id ? 'selected' : ''}} class="@if(!$user->is_active) bg-secondary @endif">
                                             {{$user->full_name}}
                                         </option>
                                    @endforeach
                                </x-dashboard.form.select.row>
                            </div>
                            <div class="col-md-8">
                                 <x-dashboard.form.row-input  name="account_number" type="number" label="اطلاعات واریز" value="{{request()->input('account_number')}}"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row name="status"  label="وضعیت">
                                    <option></option>
                                    <option value="sent"     {{request()->input('status ')== 'sent' ? 'selected' : ''}}>در حال بررسی</option>
                                    <option value="approved" {{request()->input('status ')== 'approved' ? 'selected' : ''}}>تایید شده</option>
                                    <option value="rejected" {{request()->input('status ')== 'rejected' ? 'selected' : ''}}>عدم تایید</option>
                                    <option value="suspicious" {{request()->input('status ')== 'suspicious' ? 'selected' : ''}}>مشکوک</option>
                                </x-dashboard.form.select.row>
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary float-right"> اعمال فیلتر </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست رسید  ها
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">کاربر</th>
                                <th class="text-center">مبلغ</th>
                                <th class="text-center">مقصد</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">تاریخ ایجاد</th>
                                <th class="text-center">تاریخ فروش</th>
                                <th class="text-center">توضیحات</th>
                                <th class="text-center">عملیات</th>
                                <th class="text-center">کنترل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key=>$invoice)
                                <tr>
                                    <td class="text-center align-middle"> {{\App\Functions\PaginationCounter::item($invoices , $key)}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{ $invoice->user->full_name }} </td>
                                    <td class="text-center align-middle text-nowrap"> {{ $invoice->price()}} تومان </td>
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
                                        {{ $invoice->status()}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{ $invoice->created_at()}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{ $invoice->paid_at()}} </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button class="btn btn-outline-danger"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="{{$invoice->description}}">توضیحات</button>
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        @php
                                            $customer_id= isset($invoice->salesCase) &&  count($invoice->salesCase) > 0
                                                ? optional($invoice->salesCase)[0]->customer->id
                                                :  false;
                                        @endphp
                                        <a href="{{route('admin.customer.edit' , ['customer' => $customer_id])}}"
                                           class="btn btn-icon btn-circle btn-sm btn-outline-primary  @if(!$customer_id) disabled @endif"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="پروفایل مشتری">
                                            <i class="far fa-user"></i>
                                        </a>
                                        <a href="{{route('admin.invoice.edit' , ['invoice' => $invoice->id])}}"
                                           class="btn btn-icon btn-circle btn-sm btn-outline-info"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="مشاهده">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <form action="{{route('admin.invoice.destroy' , ['invoice' => $invoice->id])}}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="btn btn-icon btn-circle btn-sm btn-outline-danger"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="حذف">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td class="text-center align-middle text-nowrap">
                                        <form action="{{route('admin.invoice.update.status' , ['invoice' => $invoice->id])}}" id="update{{$invoice->id}}" method="post" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="btn btn-icon btn-circle btn-sm btn-outline-success"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="تایید رسید  "
                                                type="submit"
                                                form="update{{$invoice->id}}"
                                                name="status"
                                                value="approved">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{route('admin.invoice.update.status' , ['invoice' => $invoice->id])}}" id="update{{$invoice->id}}" method="post" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="btn btn-icon btn-circle btn-sm btn-outline-danger"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="عدم تایید رسید  "
                                                type="submit"
                                                form="update{{$invoice->id}}"
                                                name="status"
                                                value="rejected">
                                                <i class="fas fa-skull"></i>
                                            </button>
                                        </form>

                                        <form action="{{route('admin.invoice.update.status' , ['invoice' => $invoice->id])}}" id="update{{$invoice->id}}" method="post" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="btn btn-icon btn-circle btn-sm btn-outline-warning"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="در حال بررسی"
                                                type="submit"
                                                form="update{{$invoice->id}}"
                                                name="status"
                                                value="sent">
                                                <i class="fas fa-exclamation"></i>
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
            <!--end::Card-->
            <div class="text-center mt-5">
                {{$invoices->appends(request()->all())->links()}}
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection



