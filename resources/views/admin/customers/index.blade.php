@extends('admin.layout.master' , ['title' => 'لیست مشتری ها'])
@section('title' , 'لیست مشتری ها')

@section('subheader')
    @php
        $buttons = [
//            ['title' => 'افزودن مشتری جدید' , 'icon' => '<i class="fas fa-plus icon-nm"></i>' , 'route' => route('admin.customer.create') ],
            ['title' => 'واردکردن فایل اکسل' , 'icon' => '<i class="fas fa-file-upload"></i>' , 'route' => route('admin.customer.create.excel') , 'color' => 'btn-light-success' ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'لیست مشتری ها'" />
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
        <div class="card card-custom mb-4">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        فیلتر پیشرفته
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.customer.index')}}">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input  name="name"  label="نام" />
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="شماره تلفن" name="mobile"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.select.row label="جنسیت" name="gender">
                                <option value=""></option>
                                <option value="male">مرد</option>
                                <option value="female">زن</option>
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-primary float-right"> اعمال فیلتر </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title d-inline">
                    <h3 class="card-label">
                        <span>لیست مشتری ها </span>
                    </h3>
                </div>
                <div class="card-title d-inline">
                    <h3 class="card-label float-left text-success">
                           تعداد کل مشتری ها:
                            {{number_format($customersCount)}}
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table ">
                        <thead>
                        <tr class="text-muted">
                            <th class="text-center">#</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">تلفن همراه</th>
                            <th class="text-center">پروفایل</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $key=>$customer)
                            <tr>
                                <td class="text-center align-middle"> {{\App\Functions\PaginationCounter::item($customers , $key)}} </td>
                                <td class="text-center align-middle"> {{$customer->fullname}} </td>
                                <td class="text-center align-middle text-nowrap"><a href="tel:{{$customer->mobile}}">{{$customer->mobile}}</a></td>
                                <td class="text-center align-middle text-nowrap">
                                    <a href="{{route('admin.customer.show' , $customer->id)}}"
                                       class="btn btn-icon btn-circle btn-sm btn-outline-info"
                                       data-container="body"
                                       data-delay="500"
                                       data-toggle="popover"
                                       data-placement="top"
                                       data-content="مشاهده">
                                        <i class="far fa-eye"></i>
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
            {{$customers->appends([
            'name' => request()->input('name'),
            'mobile' => request()->input('mobile'),
            'gender' => request()->input('gender')
            ])->render()}}
        </div>
    </div>
    <!--end::Container-->
@endsection
