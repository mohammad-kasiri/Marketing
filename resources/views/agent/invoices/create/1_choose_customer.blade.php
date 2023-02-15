@extends('agent.layout.master')
@section('title' , "انتخاب مشتری - افزودن رسید جدید" )
@section('headline', "انتخاب مشتری - افزودن رسید   جدید")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست رسید   ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('agent.invoice.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'انتخاب مشتری - افزودن رسید جدید'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        افزودن رسید  جدید
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('agent.invoice.create.check-customer-exists')}}" method="get">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="شماره تماس مشتری" name="mobile" type="text" placeholder="09-- --- -- --"/>
                        </div>
                    </div>
                    <button class="btn btn-primary float-right" type="submit">
                        مرحله بعدی
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection


