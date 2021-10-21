<?php
/**
 * Created by PhpStorm.
 * User: Blue Dragon
 * Date: 2020.04.27
 * Time: AM 8:56
 */
?>

<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
        {{trans('login.daily_report_system')}}
    </div>
    <div class="kt-header__topbar">
        @if(Auth::check())
            <span>{{Auth::user()->name}}</span>
        @endif
        <span class="name_suffic">{{trans('login.name_suffic')}}</span>
        <a href="{{ url('/logout') }}" style="cursor: pointer; color: black;"><i class="la la-unlock"></i>{{trans('login.logout')}}</a>

    </div>
</div>
<div class="kt-header kt-grid__item  kt-header--fixed kt_menu">
    <a class="btn btn-menu" onclick="onTop()">{{trans('login.daily_managte')}}</a>
    @if(Auth::check() && Auth::user()->role == 1)
        <a href="{{ url('/master') }}" class="btn btn-menu">{{trans('login.master_manage')}}</a>
    @endif
</div>
