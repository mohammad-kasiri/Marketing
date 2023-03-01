@extends('admin.layout.master' , ['title' => 'لیست بازاریاب ها'])
@section('title' , 'لیست بازاریاب ها')

@section('subheader')
    @php
        $buttons = [
            ['title' => 'افزودن بازاریاب جدید' , 'icon' => '<i class="fas fa-plus icon-nm"></i>' , 'route' => route('admin.agent.create') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'لیست بازاریاب'" />
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
                            لیست بازاریاب ها
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">تصویر</th>
                                <th class="text-center">نام</th>
                                <th class="text-center">تلفن همراه</th>
                                <th class="text-center">ویپ</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($agents as $key=>$agent)
                                <tr>
                                    <td class="text-center align-middle"> {{\App\Functions\PaginationCounter::item($agents , $key)}} </td>
                                    <td class="text-center align-middle"> <img src="{{$agent->avatar()}}" width="40px"></td>
                                    <td class="text-center align-middle text-nowrap"> {{$agent->full_name}}</td>
                                    <td class="text-center align-middle"> <a href="tel:{{$agent->mobile}}">{{$agent->mobile}}</a> </td>
                                    <td class="text-center align-middle"> <a href="tel:{{$agent->voip_number}}">{{$agent->voip_number}}</a> </td>
                                    @if($agent->is_active)
                                        <td class="text-center align-middle text-nowrap text-success"> فعال </td>
                                    @else
                                        <td class="text-center align-middle text-nowrap text-danger"> غیر فعال </td>
                                    @endif
                                    <td class="text-center align-middle text-nowrap">
                                        <a href="{{route('admin.agent.show' , $agent->id)}}"
                                           class="btn btn-icon btn-circle btn-sm btn-outline-info"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="مشاهده">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{route('admin.agent.login' , $agent->id)}}"
                                           class="btn btn-icon btn-circle btn-sm btn-outline-success"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="ورود به عنوان کاربر">
                                            <i class="fas fa-walking"></i>
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
            <div class="text-center mt-5">
                {{$agents->render()}}
            </div>
        </div>
        <!--end::Container-->
@endsection
