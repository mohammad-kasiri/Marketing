@extends('admin.layout.master' , ['title' => 'لیست جریان ها'])
@section('title' , 'لیست جریان ها')

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
                        افزودن جریان
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.sales-case-status-rule.store')}}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row label="از وضعیت" name="from">
                                @foreach($statuses as $status)
                                    <option {{old('from' == $status->id ? 'selected' : '')}} value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.select.row label="به وضعیت" name="to">
                                @foreach($statuses as $status)
                                    <option {{old('to' == $status->id ? 'selected' : '')}} value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </x-dashboard.form.select.row>
                            <button class="btn btn-primary float-right" type="submit">افزودن جریان</button>

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
                        لیست جریان ها
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table ">
                        <thead>
                        <tr class="text-muted">
                            <th class="text-center">#</th>
                            <th class="text-center">از</th>
                            <th class="text-center"></th>
                            <th class="text-center">به</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rules as $key=>$rule)
                            <tr>
                                <td class="text-center align-middle"> {{$key +1 }} </td>
                                <td class="text-center align-middle text-nowrap"> {{$rule->fromStatus->name}}</td>
                                <td class="text-center align-middle text-nowrap">
                                    <i class="far fa-hand-point-left text-primary"></i>
                                </td>
                                <td class="text-center align-middle text-nowrap"> {{$rule->toStatus->name}}</td>
                                <td class="text-center align-middle text-nowrap">
                                    <form action="{{route('admin.sales-case-status-rule.destroy' , $rule->id)}}" method="post">
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
    </div>
    <!--end::Container-->
@endsection
