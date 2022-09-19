@extends('admin.layout.master')
@section('title' , "ویرایش  پورسانت   " )
@section('headline', "ویرایش  پورسانت   ")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست  پورسانت   ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('admin.transaction.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'لیست  پورسانت   ها'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        ویرایش و مشاهده ی  پورسانت
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.transaction.update' , ['transaction' => $transaction->id])}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="status"  label="وضعیت">
                                <option value="created"     {{$transaction->status == 'created' ? 'selected' : ''}}>ایجاد شده</option>
                                <option value="paid" {{$transaction->status == 'paid' ? 'selected' : ''}}>پرداخت شده</option>
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="شماره پیگیری" name="tracing_number" type="text" value="{{$transaction->tracing_number}}" />
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="توضیحات"  name="description" value="{{$transaction->description}}" />
                        </div>
                    </div>

                    <button class="btn btn-primary float-right" type="submit"> ویرایش  پورسانت  </button>
                </form>
            </div>
        </div>
    </div>
@endsection


