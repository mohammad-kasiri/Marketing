@extends('agent.layout.master')
@section('title' , " ویرایش کار   " )
@section('headline', "ویرایش کار  ")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست کارها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('agent.task.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'ویرایش کار'" />
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
                        ویرایش کار
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('agent.task.update', ['task' => $task->id] )}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="عنوان" name="title" type="text" value="{{$task->title}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="توضیحات" name="note" value="{{$task->note}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="تاریخ یادآوری"  name="remind_date" datepicker="true" value="{{$task->jalaliRemindDate()}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="ساعت یادآوری"  name="remind_time" type="time" value="{{$task->jalaliRemindTime()}}" />
                        </div>
                    </div>
                    <button class="btn btn-primary float-right" type="submit">
                        ویرایش کار
                        <i class="far fa-save ml-3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
