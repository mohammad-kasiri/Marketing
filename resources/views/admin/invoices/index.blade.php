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
                                         <option value="{{$user->id}}" {{request()->input('user') == $user->id ? 'selected' : ''}}>
                                             {{$user->full_name}}
                                         </option>
                                    @endforeach
                                </x-dashboard.form.select.row>
                            </div>
                            <div class="col-md-8">
                                 <x-dashboard.form.row-input  name="account_number" type="number" label="چهار رقم آخر شماره کارت" value="{{request()->input('account_number')}}"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row name="status"  label="وضعیت">
                                    <option></option>
                                    <option value="sent"     {{request()->input('status ')== 'sent' ? 'selected' : ''}}>ارسال شده</option>
                                    <option value="approved" {{request()->input('status ')== 'approved' ? 'selected' : ''}}>تایید شده</option>
                                    <option value="rejected" {{request()->input('status ')== 'rejected' ? 'selected' : ''}}>رد شده</option>
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
                                <th class="text-center">چهار رقم آخر شماره کارت</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">تاریخ ایجاد</th>
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
                                    <td class="text-center align-middle text-nowrap"> {{ $invoice->account_number}}  </td>
                                    <td class="text-center align-middle text-nowrap
                                         text-{{$invoice->status_color()}}">
                                        {{ $invoice->status()}} </td>
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
                                                data-content="رد رسید  "
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
                                                data-content="ارسال شده"
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



