<?php
/**
 * Created by PhpStorm.
 * User: Blue Dragon
 * Date: 2020.04.27
 * Time: AM 8:39
 */
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daily Report</title>

    @yield('meta-data')

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link href="{{ asset('metronic/theme/classic/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('metronic/theme/classic/assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/theme/classic/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/theme/classic/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/theme/classic/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/theme/classic/assets/vendors/custom/vendors/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('metronic/theme/classic/assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
    <link href="{{ asset('metronic/theme/classic/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    @yield('page-style')

</head>
<style>
    .item_content .number-label {
        width: 100%;
        height: calc(1.5em + 1.3rem + 2px);
        padding: 8.45px 13px;
    }
    .light-border .number-label {
        border-color: #e0e0e0;
    }
    .number-label {
        width: 230px;
        height: 25px;
        padding: 2px 13px;
        border: 1px solid #C0C0C0;
        border-radius: 4px;
        margin-bottom: 0;
        text-align: left;
    }
    .price {
        display: none;
    }
</style>
