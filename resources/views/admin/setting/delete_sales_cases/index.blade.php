@extends('admin.layout.master')
@section('title' , "حذف گروهی پرونده ها " )
@section('headline', "حذف گروهی پرونده ها ")

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
                        حذف گروهی پرونده ها
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.delete.sales.cases.destroy')}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input
                                                        name="group_tag"
                                                        label="تگ ایجاد پرونده"/>
                        </div>
                    </div>

                    <button class="btn btn-danger float-right" type="submit"> حذف </button>
                </form>
            </div>
        </div>
    </div>
@endsection


