@extends('admin.layout.master' , ['title' => 'لیست محصولات ها'])
@section('title' , 'لیست محصولات ها')

@section('subheader')
    @php
        $buttons = [
            ['title' => 'افزودن محصولات جدید' , 'icon' => '<i class="fas fa-plus icon-nm"></i>' , 'route' => route('admin.product.create') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'لیست محصولات'" />
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
                                        <a href="{{route('admin.product.edit' , $product->id)}}"
                                           class="btn btn-icon btn-circle btn-sm btn-outline-info"
                                           data-container="body"
                                           data-delay="500"
                                           data-toggle="popover"
                                           data-placement="top"
                                           data-content="مشاهده">
                                            <i class="far fa-pen"></i>
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
            <div class="text-center mt-5">
                {{$products->render()}}
            </div>
        </div>
        <!--end::Container-->
@endsection
