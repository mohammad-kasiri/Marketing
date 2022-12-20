@extends('admin.layout.master')
@section('title' , "توزیع پرونده ها" )
@section('headline', "توزیع پرونده ها")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'توزیع پرونده ها'" />
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
        <div class="alert alert-danger" role="alert">
            <h1 class="d-inline">{{$unassignedSalesCases}}</h1>
            <span class=" h4 ml-3">پرونده ی بدون ایجنت در لیست پرونده ها موجود است.</span>
        </div>

        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                       توزیع کردن پرونده های فروش
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.distribute.action')}}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input  name="countToAssign" type="number" label="تعداد پرونده به هر نفر"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.select.row label="کد ایجاد" name="tag" searchable="true">
                                <option value=""></option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">
                                        {{ $tag->title }}
                                    </option>
                                @endforeach
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-success mb-4 float-right" id="selectAll" type="button">انتخاب همه</button>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                @foreach($agents as $agent)
                                    <div class="col-md-3 my-5">
                                        <x-dashboard.form.checkbox
                                            name="agents[{{$agent->id}}]"
                                            value="{{ $agent->id }}"
                                            checked=""
                                        >
                                            {{ $agent->fullname }}
                                        </x-dashboard.form.checkbox>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary float-right" type="submit"> تایید و انجام </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $("#selectAll").click(function(){
                $('input[type=checkbox]').not(this).prop('checked',true);
            });
        })
    </script>
@endsection
