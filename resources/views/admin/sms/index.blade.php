@extends('admin.layout.master' , ['title' => 'لیست متن پیامک'])
@section('title' , 'لیست متن پیامک')

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'لیست متن پیامک'" />
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
                        افزودن متن جدید
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.sms.store')}}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8 ">
                            <x-dashboard.form.row-input label="شناسه ی قالب"  name="template_id" type="text"/>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.text.textarea  name="text"   label="متن پیامک" />
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row label="وضعیت" name="is_active">
                                <option value="1">فعال</option>
                                <option value="0">غیرفعال</option>
                            </x-dashboard.form.select.row>
                        </div>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    </div>

                </form>
            </div>
        </div>
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        لیست پیامک های تعریف شده
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table ">
                        <thead>
                        <tr class="text-muted">
                            <th class="text-center">#</th>
                            <th class="text-center">قالب</th>
                            <th class="text-center">متن</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($smses as $key=>$sms)
                            <tr>
                                <td class="text-center align-middle"> {{$key+1}} </td>
                                <td class="text-center align-middle text-nowrap"> {{$sms->template_id}}</td>
                                <td class="text-center align-middle text-nowrap"> {{$sms->text}}</td>
                                <td class="text-center align-middle text-nowrap">
                                    @if($sms->is_active)
                                        <span class="text-success"> فعال</span>
                                    @else
                                        <span class="text-danger">غیر فعال</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <a href="{{route('admin.sms.edit' , $sms->id)}}"  class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-container="body" data-delay="500" data-toggle="popover" data-placement="top" data-content="ویرایش">
                                        <i class="fas fa-pencil-alt"></i>
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
