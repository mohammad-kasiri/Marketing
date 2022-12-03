@extends('admin.layout.master' , ['title' => 'ویرایش اطلاعات مشتری'])
@section('title' , 'ویرایش اطلاعات مشتری')
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
    <x-dashboard.subheader :links='$buttons' :title="' پروفایل ' . $customer->fullname" />
@endsection

@section('content')
    <!--begin::Entry-->
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
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body p-0">

                <!--begin::ویزارد-->
                <div class="wizard wizard-1"id="patient_add" data-wizard-state="step-first" data-wizard-clickable="true">
                    <div class="kt-grid__item">
                        <!--begin::ویزارد Nav-->
                        <div class="wizard-nav border-bottom">
                            <div class="wizard-steps p-8 p-lg-10">
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                    <div class="wizard-label">
								        <span class="svg-icon svg-icon-4x wizard-icon">
                                           <x-dashboard.icons.svg.file/>
                                        </span>
                                        <h3 class="wizard-title">1.مشخصات مشتری</h3>
                                    </div>

                                    <span class="svg-icon svg-icon-xl wizard-arrow">
                                        <x-dashboard.icons.svg.arrow-left/>
                                    </span>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
								        <span class="svg-icon svg-icon-4x wizard-icon">
                                            <x-dashboard.icons.svg.globe/>
                                        </span>
                                        <h3 class="wizard-title">2.اطلاعات تکمیلی</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end::ویزارد Nav-->
                        </div>

                        <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                            <div class="col-xl-12 col-xxl-7">
                                <!--begin::Form ویزارد Form-->
                                <form class="form" action="{{route('admin.customer.update' , $customer->id)}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <!--begin::Form ویزارد گام 1-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h3 class="mb-10 font-weight-bold text-dark">اطلاعات اصلی :</h3>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <x-dashboard.form.row-input label="نام" name="fullname" value="{{$customer->fullname}}"/>
                                                <x-dashboard.form.row-input label="تلفن همراه"  name="mobile" type="number" value="{{$customer->mobile}}" disabled="true"/>
                                                <x-dashboard.form.row-input label="آدرس ایمیل" name="email" type="email" value="{{$customer->email}}"/>
                                                <x-dashboard.form.radio.row label="جنسیت">
                                                    <x-dashboard.form.radio.button label="آقا" name="gender" value="male" color="danger" checked="{{$customer->gender == 'male'}}"/>
                                                    <x-dashboard.form.radio.button label="خانم" name="gender" value="female" color="success" checked="{{$customer->gender == 'female'}}"/>
                                                </x-dashboard.form.radio.row>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form ویزارد گام 1-->

                                    <!--begin::Form ویزارد گام 2-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-9 col-xl-6">
                                                        <h3 class="mb-10 font-weight-bold text-dark">جزئیات</h3>
                                                    </div>
                                                </div>
                                                <x-dashboard.form.row-input label="تاریخ تولد"  name="birth_date" datepicker="true" value="{{$customer->age()}}" />
                                                <x-dashboard.form.select.row label="شهر محل زندگی" name="city_id" searchable="true">
                                                    <option value="">انتخاب شهر</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}"
                                                            {{$city->id == $customer->city_id ? 'selected' : ''}}>
                                                            {{$city->name}}
                                                        </option>
                                                    @endforeach
                                                </x-dashboard.form.select.row>
                                                <x-dashboard.form.row-input label="توضیحات" name="description" value="{{$customer->description}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form ویزارد گام 2-->




                                    <!--begin::ویزارد اقدامات-->
                                    <div class="d-flex justify-content-between border-top pt-10">
                                        <div class="mr-2">
                                            <button type="button" class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">
                                                قبلی
                                            </button>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-submit">
                                                ثبت تغییرات
                                            </button>
                                            <button type="button" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">
                                                گام بعد
                                            </button>
                                        </div>
                                    </div>
                                    <!--end::ویزارد اقدامات-->
                                </form>
                                <!--end::Form ویزارد Form-->
                            </div>
                        </div>
                    </div>
                    <!--end::ویزارد-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
