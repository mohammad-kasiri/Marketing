@extends('admin.layout.master')
@section('title' , "افزودن مشتری ها و پرونده با اکسل" )
@section('headline', "افزودن مشتری ها و پرونده با اکسل")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست مشتری ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('admin.customer.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'لیست مشتری ها'" />
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
        @error('products')
            <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon2-checkmark"></i></div>
                <div class="alert-text">یک کالا باید انتخاب شود</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="نزدیک">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
        @enderror
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        افزودن مشتری ها و پرونده با اکسل
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.customer.store.excel')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.file.file name="file"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input name="source" label="منبع"/>
                        </div>
                    </div>
                    <h4 class="card-label mt-10">
                        انتخاب محصولات پرونده
                    </h4>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-3 my-5">
                                        <x-dashboard.form.checkbox
                                            name="products[{{$product->id}}]"
                                            value="{{ $product->id }}"
                                            checked="{{old('products.'.$product->id) ? '1' : 0}}"
                                        >
                                            {{ $product->title }}
                                        </x-dashboard.form.checkbox>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary float-right" type="submit"> ایجاد پرونده ها </button>
                </form>
            </div>
        </div>
    </div>
@endsection

