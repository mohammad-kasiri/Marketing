@props([
    "active" => false ,
])
<!--begin::Toggle-->
<style>
    .heart {
        font-size: 150px;
        color: #e00;
        animation: beat .25s infinite alternate;
        transform-origin: center;
    }

    /* Heart beat animation */
    @keyframes beat{
        to { transform: scale(1.3); }
    }
</style>
<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse @if($active) pulse-danger @else pulse-primary @endif  ">
	    <span class="svg-icon svg-icon-xl  @if($active) heart svg-icon-danger @else svg-icon-primary  @endif ">
            <x-dashboard.icons.svg.compiling/>
        </span>
        @if($active)
            <span class="pulse-ring"></span>
        @endif
    </div>
</div>
<!--end::Toggle-->

