@extends('admin.layout.master')
@section('title' , " لیست فاکتور های " .$agent->full_name )
@section('headline', " لیست فاکتور های " . $agent->full_name )

@section('subheader')
    @php
        $buttons = [
            [
                'title'  =>  'پروفایل بازاریاب' ,
                'icon'   =>  '<i class="fas fa-house-user"></i>' ,
                'route'  =>  route('admin.agent.show' , $agent->id) ,
                'color'  =>  'btn-light-info'
             ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'لیست فاکتور ها'" />
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
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست فاکتورها
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">مبلغ</th>
                                <th class="text-center">چهار رقم آخر شماره کارت</th>
                                <th class="text-center">توضیحات</th>
                                <th class="text-center">تاریخ واریز</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key=>$invoice)
                                <tr>
                                    <td class="text-center align-middle"> {{\App\Functions\PaginationCounter::item($invoices , $key)}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$invoice->price()}} تومان </td>
                                    <td class="text-center align-middle text-nowrap"> {{$invoice->account_number}}  </td>
                                    <td class="text-center align-middle text-nowrap"> {{$invoice->status()}} </td>
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
                                        <a href="{{route('admin.agent.invoice.edit' , ['agent'=> $agent->id , 'invoice' => $invoice->id])}}"
                                           class="btn btn-icon btn-circle btn-sm btn-outline-info"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="مشاهده">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <form action="{{route('admin.agent.invoice.destroy' , ['agent'=> $agent->id , 'invoice' => $invoice->id])}}" method="post" class="d-inline">
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
            <div class="text-center mt-5">
                {{$invoices->render()}}
            </div>
        </div>
        <!--end::Container-->

    </div>
@endsection


