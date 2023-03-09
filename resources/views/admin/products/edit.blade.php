@extends('admin.layout.master' , ['title' => 'ویرایش محصول'])
@section('title' , 'ویرایش محصول')
@section('subheader')
    @php
        $buttons = [
            [
                'title'  =>  'لیست محصولات' ,
                'icon'   =>  '<i class="fas fa-undo"></i>' ,
                'route'  =>  route('admin.product.index') ,
                'color'  =>  'btn-light-info'
             ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons' :title="' ویرایش ' . $product->title" />
@endsection

@section('content')
    <!--begin::Entry-->
    <!--begin::Container-->
    <div class=" container ">
        <div class="card card-custom my-5">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        ویرایش محصول
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.product.update', ['product' => $product])}}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <x-dashboard.form.row-input label="عنوان محصول"  name="title" type="text" value="{{$product->title}}"/>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary btn-block">ویرایش محصول</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Entry-->
@endsection
