@extends('admin.layout.master' , ['title' => 'ویرایش پیامک'])
@section('title' , 'ویرایش اپیامک')
@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'ویرایش پیامک'" />
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
        <div class="card card-custom my-5">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        ویرایش متن پیامک
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.sms.update', ['sms' => $sms->id])}}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8 ">
                            <x-dashboard.form.row-input label="شناسه ی قالب"  name="template_id" type="text" value="{{$sms->template_id}}"/>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.text.textarea  name="text"  value="{{$sms->text}}"   label="متن پیامک" />
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row label="وضعیت" name="is_active">
                                <option {{$sms->is_active == 1 ? 'selected' : ''}} value="1">فعال</option>
                                <option {{$sms->is_active == 0 ? 'selected' : ''}} value="0">غیرفعال</option>
                            </x-dashboard.form.select.row>
                        </div>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!--end::Container-->
@endsection
