@extends('admin.layout.master')
@section('title' , " افزودن وضعیت جدید ")
@section('headline', "افزودن وضعیت جدید")

@section('subheader')
    @php
        $buttons = [
            ['title' => 'لیست وضعیت ها' , 'icon' => '<i class="fas fa-undo icon-nm"></i>' , 'route' => route('admin.sales-case-status.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'افزودن وضعیت جدید'" />
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
                    <form action="{{route('admin.sales-case-status.store')}}" method="post">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <x-dashboard.form.row-input label="عنوان"  name="name"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="جایگاه" name="place">
                                    <option {{old('place' == 0 ? 'selected' : '')}} value="0">هیچکدام</option>
                                    <option {{old('place' == 1 ? 'selected' : '')}} value="1">وضعیت هنگام تعریف یک پرونده</option>
                                    <option {{old('place' == 2 ? 'selected' : '')}} value="2">وضعیت یکی مانده به آخر</option>
                                    <option {{old('place' == 3 ? 'selected' : '')}} value="3">وضعیت موفق</option>
                                </x-dashboard.form.select.row>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="وضعیت" name="is_active">
                                    <option {{old('is_active' == 1 ? 'selected' : '')}} value="1">فعال</option>
                                    <option {{old('is_active' == 0 ? 'selected' : '')}} value="0">غیرفعال</option>
                                </x-dashboard.form.select.row>
                            </div>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">افزودن وضعیت</button>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection


