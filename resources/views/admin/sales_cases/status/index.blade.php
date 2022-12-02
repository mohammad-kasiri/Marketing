@extends('admin.layout.master' , ['title' => 'لیست وضعیت های پرونده ها'])
@section('title' ,  'لیست وضعیت های پرونده ها')

@section('subheader')
    @php
        $buttons = [
            ['title' => 'افزودن وضعیت جدید' , 'icon' => '<i class="fas fa-plus icon-nm"></i>' , 'route' => route('admin.sales-case-status.create') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons' :title="'لیست وضعیت های پرونده ها'" />
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
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        لیست وضعیت ها
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
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">توضیح</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($statuses as $key=>$status)
                            <tr>
                                <td class="text-center align-middle">  {{$key+1}} </td>
                                <td class="text-center align-middle text-nowrap"> {{$status->name}}</td>
                                <td class="text-center align-middle text-nowrap">
                                     <span class="text-{{$status->is_active ? 'success' : 'danger'}}">
                                         {{$status->is_active ? 'فعال' : 'غیرفعال'}}
                                     </span>
                                </td>
                                <td class="text-center align-middle text-nowrap"> {{$status->note()}}</td>
                                <td class="text-center align-middle text-nowrap">
                                    <a
                                        href="{{route('admin.sales-case-status.edit', ['status' => $status->id])}}"
                                        class="btn btn-icon btn-circle btn-sm btn-outline-primary"  data-container="body"
                                        data-delay="500"
                                        data-toggle="popover"
                                        data-placement="top"
                                        data-content="ویرایش">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
@endsection
