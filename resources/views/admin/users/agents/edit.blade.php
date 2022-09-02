@extends('admin.layout.master' , ['title' => 'ویرایش اطلاعات بازاریاب'])
@section('title' , 'ویرایش اطلاعات بازاریاب')
@section('subheader')
    @php
        $buttons = [
            [
                'title'  =>  'پروفایل بازاریاب' ,
                'icon'   =>  '<i class="fas fa-house-user"></i>' ,
                'route'  =>  route('admin.agent.show' , $agent->id) ,
                'color'  =>  'btn-light-info'
             ],
             [
               'title'  =>  'لیست بازاریابان' ,
               'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
               'route'  =>  route('admin.agent.index') ,
               'color'  =>  'btn-light-warning'
             ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons' :title="' پروفایل ' . $agent->fullname" />
@endsection

@section('content')
    <!--begin::Entry-->
    <!--begin::Container-->
    <div class=" container ">
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
                                        <h3 class="wizard-title">1.مشخصات بازاریاب</h3>
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
                                        <h3 class="wizard-title">2.تنظیمات</h3>
                                    </div>

                                    <span class="svg-icon svg-icon-xl wizard-arrow">
                                        <x-dashboard.icons.svg.arrow-left/>
                                    </span>
                                </div>

                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
								        <span class="svg-icon svg-icon-4x wizard-icon">
                                            <x-dashboard.icons.svg.lock/>
                                        </span>
                                        <h3 class="wizard-title">3.کلمه ی عبور</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end::ویزارد Nav-->
                        </div>

                        <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                            <div class="col-xl-12 col-xxl-7">
                                <!--begin::Form ویزارد Form-->
                                <form class="form" action="{{route('admin.agent.update' , $agent->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                    <!--begin::Form ویزارد گام 1-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h3 class="mb-10 font-weight-bold text-dark">اطلاعات اصلی بازاریاب:</h3>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <x-dashboard.form.row-input label="نام" name="first_name" value="{{$agent->first_name}}"/>
                                                <x-dashboard.form.row-input label=" نام خانوادگی" name="last_name" value="{{$agent->last_name}}"/>
                                                <x-dashboard.form.row-input label="تلفن همراه"  name="mobile" type="number" value="{{$agent->mobile}}"/>
                                                <x-dashboard.form.row-input label="آدرس ایمیل" name="email" type="email" value="{{$agent->email}}"/>
                                                <x-dashboard.form.radio.row label="جنسیت">
                                                    <x-dashboard.form.radio.button label="آقا" name="gender" value="male" color="danger" checked="{{$agent->gender == 'male'}}"/>
                                                    <x-dashboard.form.radio.button label="خانم" name="gender" value="female" color="success" checked="{{$agent->gender == 'female'}}"/>
                                                </x-dashboard.form.radio.row>
                                                <x-dashboard.form.file.image
                                                    name="avatar"
                                                    label="تصویر پروفایل"
                                                    id="doctor_avatar"
                                                    default_image="{{$agent->avatar()}}"
                                                />
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
                                                        <h3 class="mb-10 font-weight-bold text-dark">درصد بازاریاب</h3>
                                                    </div>
                                                </div>
                                                <x-dashboard.form.row-input label="درصد بازاریاب"  name="percentage" type="number" value="{{$agent->percentage}}"/>
                                                <x-dashboard.form.row-input label="شماره شبا"     name="sheba_number" type="number" value="{{$agent->sheba_number}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form ویزارد گام 2-->

                                    <!--begin::Form ویزارد گام 3-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h3 class="mb-10 font-weight-bold text-dark">تنظیم کلمه ی عبور</h3>
                                        <x-dashboard.form.row-input label="کلمه ی عبور"  name="password" type="password" value="xxxxx" disabled="true"/>
                                        <x-dashboard.form.row-input label="تکرار کلمه ی عبور" name="password_confirmation" type="password" value="xxxxx" disabled="true"/>
                                    </div>
                                    <!--end::Form ویزارد گام 3-->


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
