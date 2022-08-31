@extends('admin.layout.master' , ['title' => 'لیست محصولات ها'])
@section('title' , 'لیست محصولات ها')

@section('subheader')
    @php
        $buttons = [
            ['title' => 'افزودن محصولات جدید' , 'icon' => '<i class="fas fa-plus icon-nm"></i>' , 'route' => route('admin.product.create') ],
        ];
    @endphp
    <x-dashboard.subheader :links='[]' :title="'لیست محصولات'" />
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
                            افزودن محصول
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.product.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <x-dashboard.form.row-input label="عنوان محصول"  name="title" type="text"/>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary btn-block">افزودن محصول</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست محصولات ها
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $key=>$product)
                                <tr>
                                    <td class="text-center align-middle"> {{\App\Functions\PaginationCounter::item($products , $key)}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$product->title}}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <form action="{{route('admin.product.destroy' , $product->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="btn btn-icon btn-circle btn-sm btn-outline-danger"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="حذف">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
            <div class="text-center mt-5">
                {{$products->render()}}
            </div>
        </div>
        <!--end::Container-->
@endsection
