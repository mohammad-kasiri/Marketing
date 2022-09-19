@extends('admin.layout.master')
@section('title' , "تنظیمات " )
@section('headline', "تنظیمات")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'تنظیمات'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
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
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        تنظیمات
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.setting.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="ranking"  label="نمایش رنکینگ در پنل بازاریاب">
                                <option value="0"  {{$ranking == '0' ? 'selected' : ''}}>نمایش داده نشود</option>
                                <option value="1"  {{$ranking == '1' ? 'selected' : ''}}>نمایش داده شود</option>
                            </x-dashboard.form.select.row>
                        </div>
                    </div>

                    <button class="btn btn-primary float-right" type="submit"> ویرایش تنظیمات</button>
                </form>
            </div>
        </div>
    </div>
@endsection


