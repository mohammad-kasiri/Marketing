@extends('admin.layout.master')
@section('title' , "افزودن کار  جدید" )
@section('headline', "افزودن کار جدید")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست کار ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('admin.task.index', ['salesCase' => $salesCase->id]) ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'افزودن کار جدید'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        افزودن کار جدید
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.task.store', ['salesCase' => $salesCase->id])}}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="عنوان" name="title" type="text"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="توضیحات" name="note"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="تاریخ یادآوری"  name="remind_date" datepicker="true"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="ساعت یادآوری"  name="remind_time" type="time"/>
                        </div>
                    </div>
                    <button class="btn btn-primary float-right" type="submit">
                        افزودن کار
                        <i class="far fa-save ml-3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection


