@extends('admin.layout.master')
@section('title' , " ویرایش وضعیت ")
@section('headline', "ویرایش وضعیت")

@section('subheader')
    @php
        $buttons = [
            ['title' => 'لیست وضعیت ها' , 'icon' => '<i class="fas fa-undo icon-nm"></i>' , 'route' => route('admin.sales-case-status.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'ویرایش وضعیت'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
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
            <!--begin::Notice-->
            <div class="card card-custom mb-4">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            افزودن وضعیت پرونده جدید
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.sales-case-status.update', [$status->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <x-dashboard.form.row-input label="عنوان"  name="name" value="{{$status->name}}"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="جایگاه" name="place">
                                    <option  value="0">هیچکدام</option>
                                    <option {{$status->is_first_step ? 'selected' : ''}} value="1">وضعیت هنگام تعریف یک پرونده</option>
                                    <option {{$status->is_before_last_step ? 'selected' : ''}} value="2">وضعیت یکی مانده به آخر</option>
                                    <option {{$status->is_last_step ? 'selected' : ''}} value="3">وضعیت موفق</option>
                                </x-dashboard.form.select.row>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="وضعیت" name="is_active">
                                    <option {{$status->is_active ? 'selected' : ''}} value="1">فعال</option>
                                    <option {{$status->is_active ? '' : 'selected'}} value="0">غیرفعال</option>
                                </x-dashboard.form.select.row>
                            </div>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">ویرایش وضعیت</button>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection


