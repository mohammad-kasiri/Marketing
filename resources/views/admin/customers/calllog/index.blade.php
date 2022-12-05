@extends('admin.layout.master' , ['title' => 'تاریخچه تماس ها'])
@section('title' , 'تاریخچه تماس ها')

@section('subheader')
    @php
        $buttons = [
           [
               'title'  =>  'پروفایل مشتری' ,
               'icon'   =>  '<i class="fas fa-house-user"></i>' ,
               'route'  =>  route('admin.customer.show' , $customer->id) ,
               'color'  =>  'btn-light-info'
            ],
       ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'تاریخچه تماس ها'" />
@endsection

@section('content')
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
        <!--end::Notice-->
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        لیست تاریخچه تماس ها
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table ">
                        <thead>
                        <tr class="text-muted">
                            <th class="text-center">#</th>
                            <th class="text-center">نوع</th>
                            <th class="text-center">مبدا</th>
                            <th class="text-center">مقصد</th>
                            <th class="text-center">زمان</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($callLogs as $key=>$log)
                            <tr>
                                <td class="text-center align-middle"> {{$key+1}} </td>
                                <td class="text-center align-middle"> {{$log->event_name}} </td>
                                <td class="text-center align-middle"> {{$log->from}} </td>
                                <td class="text-center align-middle text-nowrap">{{$log->to}} </td>
                                <td class="text-center align-middle text-nowrap">{{$log->created_at()}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
@endsection
