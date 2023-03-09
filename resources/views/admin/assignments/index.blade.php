@extends('admin.layout.master' , ['title' => 'لیست انتقال ها'])
@section('title' , 'لیست انتقال ها')

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'لیست انتقال ها'" />
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
                       انتقال پرونده
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.assignment.store')}}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="from_user_id"  label="از کاربرِ:">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" > {{$user->fullname}} </option>
                                @endforeach
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="sales_case_status_id"  label="وضعیت:">
                                <option value="0" > همه (بجز فروش موفق و تحویل لایسنس) </option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}" > {{$status->name}} </option>
                                @endforeach
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="to_user_id"  label="به کاربرِ:">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" > {{$user->fullname}} </option>
                                @endforeach
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                           <button class="btn btn-primary float-right" type="submit">انتقال</button>
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
                            <th class="text-center">از فروشنده</th>
                            <th class="text-center">به فروشنده</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center"> تعداد پرونده ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assignments as $key=>$assignment)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-center">{{$assignment->from_user->fullname}}</td>
                                <td class="text-center">{{$assignment->to_user->fullname}}</td>
                                <td class="text-center">{{is_null($assignment->sales_case_status) ? 'همه' : $assignment->sales_case_status->name}}</td>
                                <td class="text-center">{{$assignment->count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card-->
        <div class="text-center mt-5">
        </div>
    </div>
    <!--end::Container-->
@endsection
