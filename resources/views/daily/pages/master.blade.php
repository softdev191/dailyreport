<?php
/**
 * Created by PhpStorm.
 * User: Blue Dragon
 * Date: 2020.04.27
 * Time: AM 8:52
 */
?>
@extends('daily.layout.app')

@section('page-style')
    <style>
        .kt-portlet__body_search {
            border: none !important;
            padding: 0px;
        }

        .modal-dialog .bootstrap-select {
            width: 120px !important;
        }
    </style>
@endsection
@section('main_content')
    <div class="body">
        @include('daily.partials.header_bar')
        <div class="kt-content  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    {{trans('login.master_item')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="col-lg-12 kt-portlet__body_search">
                                <ul class="nav nav-tabs  nav-tabs-line" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1" role="tab">{{trans('login.employee_master')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_2" role="tab">{{trans('login.oursider_master')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_7" role="tab">作業員・外注員順番設定</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_3" role="tab">{{trans('login.tool_car_master')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_5" role="tab">{{trans('login.excise_master')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_6" role="tab">{{trans('login.user_master')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content">
                        @include('daily.partials.master.tab_worker')
                        @include('daily.partials.master.tab_lancer')
                        @include('daily.partials.master.tab_equip')
                        @include('daily.partials.master.tab_tax')
                        @include('daily.partials.master.tab_user')
                        @include('daily.partials.master.tab_worker_order')
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_company" id="btn_company_change"></button>
        <div class="modal fade" id="kt_modal_company" tabindex="-1" role="dialog" aria-labelledby="company_title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="company_title">{{trans('login.company_regist')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped- table-bordered">
                            <tbody>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.lease_company_name')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control" id="company_name" style="width: 210px;">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                        <button type="button" class="btn btn-primary" onclick="save_company()" id="save_company">{{trans('login.add')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_type" id="btn_type_change"></button>
        <div class="modal fade" id="kt_modal_type" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans('login.type_regist')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped- table-bordered">
                            <tbody>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.lease_type')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control" id="type_name" style="width: 210px;">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                        <button type="button" class="btn btn-primary" onclick="save_type()" id="save_type">{{trans('login.add')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_equipment_tool" id="btn_equipment_tool_change"></button>
        <div class="modal fade" id="kt_modal_equipment_tool" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans('login.tool_regist')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped- table-bordered">
                            <tbody>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.tool')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control" id="equipment_tool_name" style="width: 210px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.start_date')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control form_date" id="equipment_tool_startdate" style="width: 210px; padding: 0px 13px;" readonly>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                        <button type="button" class="btn btn-primary" onclick="save_equipment_tool()" id="save_equipment_tool">{{trans('login.add')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_equipment_car" id="btn_equipment_car_change"></button>
        <div class="modal fade" id="kt_modal_equipment_car" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans('login.car_regist')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped- table-bordered">
                            <tbody>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.car')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control" id="equipment_car_name" style="width: 210px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.start_date')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control form_date" id="equipment_car_startdate" style="width: 210px; padding: 0px 13px;" readonly>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                        <button type="button" class="btn btn-primary" onclick="save_equipment_car()" id="save_equipment_car">{{trans('login.add')}}</button>
                    </div>
                </div>
            </div>
        </div>

        @include("daily.partials.worker.create")
        @include("daily.partials.worker.edit")
        @include("daily.partials.worker.price")
        @include("daily.partials.equipment.change")

        <button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_user" id="btn_user_change"></button>
        <div class="modal fade" id="kt_modal_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{trans('login.user_regist')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped- table-bordered">
                            <tbody>
                            <tr>
                                <td class="td_head" style="width: 20%">ID</td>
                                <td style="width: 30%">
                                    <input type="text" class="form-control" id="user_id" style="width: 120px;">
                                </td>
                                <td class="td_head" style="width: 20%">{{trans('login.name')}}</td>
                                <td style="width: 30%">
                                    <input type="text" class="form-control" id="user_name" style="width: 120px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head">Password</td>
                                <td>
                                    <input type="password" class="form-control" id="user_password" style="width: 120px;">
                                </td>
                                <td class="td_head">Password confirm</td>
                                <td>
                                    <input type="password" class="form-control" id="user_password_confirm" style="width: 120px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head">{{trans('login.role')}}</td>
                                <td colspan="3">
                                    <select class="form-control kt-selectpicker" id="user_role" style="width: 120px;">
                                        <option value="0">{{trans('login.user')}}</option>
                                        <option value="1">{{trans('login.master')}}</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                        <button type="button" class="btn btn-primary" onclick="save_user()" id="save_user">{{trans('login.add')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="number" class="form-control hidden" id="lease_type" style="width: 210px;">
        <input type="number" class="hidden form-control" id="id" style="width: 120px;">
        <input type="number" class="hidden form-control" id="price_id" style="width: 120px;">
    </div>

    <script>
        var company_table;
        var type_table;
        var equipment_tool_table;
        var equipment_price_tool_table;
        var equipment_price_list_table;
        var equipment_car_table;
        var equipment_price_car_table;
        var equipment_price_car_list_table;
        var worker_table;
        var worker_order_table;
        var worker_hidden_table;
        var worker_price_table;
        var outsider_table;
        var outsider_hidden_table;
        var outer_price_table;
        var user_table;
        var role_html = ["{{trans('login.user')}}", "{{trans('login.master')}}"];
        var change_label = "{{trans('login.change')}}";
        var delete_label = "{{trans('login.delete')}}";

        if ($('#kt_table_lease_company')) {
            $(function(){
                company_table = $('#kt_table_lease_company').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_company_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html('<button type="button" class="btn btn-brand" onclick="change_company(' + data[2] + ')">' + change_label + '</button>\n' +
                            '        <button type="button" class="btn btn-danger" onclick="delete_company(' + data[2] + ')">' + delete_label + '</button>');
                    },
                });
            });
        }

        if ($('#kt_table_lease_type')) {
            $(function(){
                type_table = $('#kt_table_lease_type').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_type_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.company_id = $('#company_id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(3).html('<button type="button" class="btn btn-brand" onclick="change_type(' + data[3] + ')">' + change_label + '</button>\n' +
                            '        <button type="button" class="btn btn-danger" onclick="delete_type(' + data[3] + ')">' + delete_label + '</button>');
                    },
                });
            });
        }

        if ($('#kt_table_lease_equipment_tool')) {
            $(function(){
                equipment_tool_table = $('#kt_table_lease_equipment_tool').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_equipment_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 1;
                            data.company_id = $('#company_id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(3).html('<button type="button" class="btn btn-brand" onclick="change_equipment_tool(' + data[3] + ')">' + change_label + '</button>\n' +
                            '        <button type="button" class="btn btn-danger" onclick="delete_equipment(' + data[3] + ', 1)">' + delete_label + '</button>');
                    },
                });
            });
        }

        if ($('#kt_table_lease_equipment_price_tool')) {
            $(function(){
                equipment_price_tool_table = $('#kt_table_lease_equipment_price_tool').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_equipment_price_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.company_id = $('#company_id').val();
                            data.type = 1;
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(4).html(
                            `<button type="button" class="btn btn-brand" onclick="change_equipment_price(${data[5]}, ${data[4]}, 0)">追加</button>\n` +
                            `<button type="button" class="btn btn-info" onclick="list_equipment_price(${data[4]}, ${data[5]}, 0)">${change_label}</button>`
                        );
                    },
                });
            });
        }

        if ($('#kt_table_lease_equipment_price_list')) {
            $(function(){
                equipment_price_list_table = $('#kt_table_lease_equipment_price_list').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_equipment_price_list_detail') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.equip_id = $('#kt_modal_equip_price .equip_id').val();
                            data.type_id = $('#kt_modal_equip_price .type_id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html(`<button type="button" class="btn btn-info" onclick="change_equipment_price(${data[3]}, ${data[4]}, ${data[2]})">${change_label}</button>\n` +
                            `<button type="button" class="btn btn-danger" onclick="delete_equip_price(${data[2]})">${delete_label}</button>`);
                    },
                });
            });
        }

        if ($('#kt_table_lease_equipment_car')) {
            $(function(){
                equipment_car_table = $('#kt_table_lease_equipment_car').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_equipment_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 0;
                            data.company_id = $('#company_id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(3).html('<button type="button" class="btn btn-brand" onclick="change_equipment_car(' + data[3] + ')">' + change_label + '</button>\n' +
                            '        <button type="button" class="btn btn-danger" onclick="delete_equipment(' + data[3] + ', 0)">' + delete_label + '</button>');
                    },
                });
            });
        }

        if ($('#kt_table_lease_equipment_price_car')) {
            $(function(){
                equipment_price_car_table = $('#kt_table_lease_equipment_price_car').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_equipment_price_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 0;
                            data.company_id = $('#company_id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(4).html(
                            `<button type="button" class="btn btn-brand" onclick="change_equipment_price(${data[5]}, ${data[4]}, 0)">追加</button>\n` +
                            `<button type="button" class="btn btn-info" onclick="list_equipment_price(${data[4]}, ${data[5]}, 1)">${change_label}</button>`
                        );
                    },
                });
            });
        }

        if ($('#kt_table_lease_car_price_list')) {
            $(function(){
                equipment_price_car_list_table = $('#kt_table_lease_car_price_list').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_equipment_price_list_detail') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.equip_id = $('#kt_modal_equip_price .equip_id').val();
                            data.type_id = $('#kt_modal_equip_price .type_id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html(`<button type="button" class="btn btn-info" onclick="change_equipment_price(${data[3]}, ${data[4]}, ${data[2]})">${change_label}</button>\n` +
                            `<button type="button" class="btn btn-danger" onclick="delete_equip_price(${data[2]})">${delete_label}</button>`);
                    },
                });
            });
        }

        if ($('#kt_table_worker')) {
            $(function(){
                worker_table = $('#kt_table_worker').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('/get_personal_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 0;
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html(`<button type="button" class="btn btn-brand" onclick="change_worker(${data[2]}, 0)">${change_label}</button>\n`
                            + `<button type="button" class="btn btn-info" onclick="price_worker(${data[2]},'${data[0]}', 0)">人件費</button>\n`
                            + `<button type="button" class="btn btn-danger" onclick="delete_worker(${data[2]}, 0)">${delete_label}</button>\n`);
                    },
                });
            });
        }

        if ($('#kt_table_worker_order')) {
            $(function(){
                worker_order_table = $('#kt_table_worker_order').DataTable({
                    "bSort": false,
                    "pageLength": 100,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,
                    "rowReorder": {
                        selector: 'tr',
                    },
                    "ajax": {
                        "url": "{{ url('/get_ordered_personals') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 0;
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html(data[2] == 0 ? '作業員' : '外注員');
                    },
                });
                worker_order_table.on('row-reorder', function ( e, diff, edit ) {
                    const dVals = diff.map((d) => {
                        return {
                            oldV: d.oldData,
                            newV: d.newData,
                        }
                    });
                    if (dVals.length > 0) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/change_position') }}",
                            data: {
                                position: dVals,
                            },
                            success: function (v) {
                                worker_order_table.draw();
                            },
                            error: function(data, status, err) {
                            }
                        });
                    }
                });
            });
        }

        if ($('#kt_table_worker_hidden')) {
            $(function(){
                worker_hidden_table = $('#kt_table_worker_hidden').DataTable({
                    "bSort": false,
                    "pageLength": 10,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_personal_hidden_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 0;
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html('<button type="button" class="btn btn-brand" onclick="show_worker(' + data[2] + ', 0)">表示</button>');
                    },
                });
            });
        }

        if ($('#kt_table_worker_price')) {
            $(function(){
                worker_price_table = $('#kt_table_worker_price').DataTable({
                    "bSort": false,
                    "pageLength": 10,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_price_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.id = $('#id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html('<button type="button" class="btn btn-brand" onclick="change_worker_price(' + data[2] + ', 0)">' + change_label + '</button>\n' +
                            '<button type="button" class="btn btn-danger" onclick="delete_worker_price(' + data[2] + ', 0)">' + delete_label + '</button>');
                    },
                });
            });
        }

        if ($('#kt_table_outsider')) {
            $(function(){
                outsider_table = $('#kt_table_outsider').DataTable({
                    "bSort": false,
                    "pageLength": 10,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_personal_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 1;
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html(`<button type="button" class="btn btn-brand" onclick="change_worker(${data[2]}, 1)">${change_label}</button>\n`
                            + `<button type="button" class="btn btn-info" onclick="price_worker(${data[2]},'${data[0]}', 1)">人件費</button>\n`
                            + `<button type="button" class="btn btn-danger" onclick="delete_worker(${data[2]}, 1)">${delete_label}</button>\n`);
                    },
                });
            });
        }

        if ($('#kt_table_outsider_hidden')) {
            $(function(){
                outsider_hidden_table = $('#kt_table_outsider_hidden').DataTable({
                    "bSort": false,
                    "pageLength": 10,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_personal_hidden_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.type = 1;
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html('<button type="button" class="btn btn-brand" onclick="show_worker(' + data[2] + ', 1)">表示</button>');
                    },
                });
            });
        }

        if ($('#kt_table_outer_price')) {
            $(function(){
                outer_price_table = $('#kt_table_outer_price').DataTable({
                    "bSort": false,
                    "pageLength": 10,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_price_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.id = $('#id').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html('<button type="button" class="btn btn-brand" onclick="change_worker_price(' + data[2] + ', 1)">' + change_label + '</button>\n' +
                            '<button type="button" class="btn btn-danger" onclick="delete_worker_price(' + data[2] + ', 1)">' + delete_label + '</button>');
                    },
                });
            });
        }

        if ($('#kt_table_user')) {
            $(function(){
                user_table = $('#kt_table_user').DataTable({
                    "bSort": false,
                    "pageLength": 10,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,

                    "ajax": {
                        "url": "{{ url('/get_user_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(2).html(role_html[data[2]]);
                        if (data[3] == 1) {
                            $('td', row).eq(3).html('<button type="button" class="btn btn-brand" onclick="change_user(' + data[4] + ')">' + change_label + '</button>');
                        } else {
                            $('td', row).eq(3).html('<button type="button" class="btn btn-brand" onclick="change_user(' + data[4] + ')">' + change_label + '</button>\n' +
                                '        <button type="button" class="btn btn-danger" onclick="delete_user(' + data[4] + ')">' + delete_label + '</button>');
                        }

                    },
                });
            });
        }

        function add_tax() {
            var tax = $('#excise').val();
            if (tax == '') {
                $('#excise').focus();
                return;
            }
            if ($('#tax_startdate').val() == '') {
                $('#tax_startdate').focus();
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ url('/set_excise_info') }}",
                data: {
                    tax: tax,
                    startdate: $('#tax_startdate').val(),
                },
                success: function (v) {
                    $('#kt_group_taxes').html(v);
                    init_event_tax();
                    showNotification("success", "登録されました。", "success");
                },
                error: function(data, status, err) {
                }
            });
        }

        function delete_tax(elem) {
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                var taxid = $(elem).closest('.kt-portlet__body_search').find('input.tax_id').val();
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/delete_tax') }}/" + taxid,
                    success: function (v) {
                        $('#kt_group_taxes').html(v);
                        init_event_tax();
                        showNotification("success", "削除しました。", "success");
                    },
                    error: function(data, status, err) {
                    }
                });
            });
        }

        function edit_tax(elem) {
            var taxid = $(elem).closest('.kt-portlet__body_search').find('input.tax_id').val();
            var taxval = $(elem).closest('.kt-portlet__body_search').find('input.tax_value').val();
            var taxdate = $(elem).closest('.kt-portlet__body_search').find('input.tax_startdate').val();
            if (taxval == '') {
                $(elem).closest('.kt-portlet__body_search').find('input.tax_value').focus();
                return;
            }
            if (taxdate == '') {
                $(elem).closest('.kt-portlet__body_search').find('input.tax_startdate').focus();
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ url('/update_tax') }}",
                data: {
                    id: taxid,
                    tax: taxval,
                    startdate: taxdate,
                },
                success: function (v) {
                    $('#kt_group_taxes').html(v);
                    init_event_tax();
                    showNotification("success", "修正しました。", "success");
                },
                error: function(data, status, err) {
                }
            });
        }

        function change_company_relate(data) {
            var html_type = '<select class="form-control kt-selectpicker" id="company_id" style="width: 120px;">';
            var select_company = $('#company_id').val();
            for (var i = 0; i < data.length; i++) {
                var selected = data[i].id == select_company ? 'selected' : '';
                html_type += '<option value="' + data[i].id + '" ' + selected + '>' + data[i].name + '</option>';
            }
            html_type += '</select>';
            $('.company_id').html(html_type);
            KTBootstrapSelect.init();
            init_tool();
            type_table.draw();
            equipment_tool_table.draw();
            equipment_price_tool_table.draw();
            equipment_car_table.draw();
            equipment_price_car_table.draw();
        }

        function change_company(id) {
            if (id == 0) {
                $('#id').val(0);
                $('#company_name').val('');
                $('#save_company').html("{{trans('login.add')}}");
                $('#btn_company_change').trigger('click');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_company_info') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        $('#id').val(v.id);
                        $('#company_name').val(v.name);
                        $('#save_company').html("{{trans('login.change')}}");
                        $('#btn_company_change').trigger('click');
                    },
                    error: function(data, status, err) {
                    }
                });
            }
        }

        function delete_company(id) {
            const ctinfo = company_table.page.info();
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_company') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        company_table.draw();
                        change_company_relate(v);
                        company_table.page(ctinfo.page).draw(false);
                    },
                    error: function(data, status, err) {
                    }
                });
            })
        }

        function save_company() {
            if ($('#company_name').val() == '') {
                $('#company_name').focus();
                return;
            }
            const ctinfo = company_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/add_company') }}",
                data: {
                    id: $('#id').val(),
                    name: $('#company_name').val(),
                },
                dataType: 'json',
                success: function (v) {
                    $('.btn-secondary').trigger('click');
                    company_table.draw();
                    change_company_relate(v);
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                    company_table.page(ctinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function change_type(id) {
            if ($('#company_id').val() == '' || $('#company_id').val() == undefined) {
                return;
            }
            if (id == 0) {
                $('#id').val(0);
                $('#type_name').val('');
                $('#save_type').html("{{trans('login.add')}}");
                $('#btn_type_change').trigger('click');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_type_info') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        $('#id').val(v.id);
                        $('#type_name').val(v.name);
                        $('#save_type').html("{{trans('login.change')}}");
                        $('#btn_type_change').trigger('click');
                    },
                    error: function(data, status, err) {
                    }
                });
            }
        }

        function change_equipment_tool(id) {
            $('#lease_type').val(1);
            if ($('#company_id').val() == '' || $('#company_id').val() == undefined) {
                return;
            }
            if (id == 0) {
                $('#id').val(0);
                $('#equipment_tool_name').val('');
                $('#equipment_tool_name').val('');
                $('#equipment_tool_startdate').val('');
                $('#save_equipment_tool').html("{{trans('login.add')}}");
                $('#btn_equipment_tool_change').trigger('click');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_equipment_info') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        $('#id').val(v.id);
                        $('#equipment_tool_name').val(v.name);
                        $('#equipment_tool_startdate').val(v.start_date);
                        $('#save_equipment_tool').html("{{trans('login.change')}}");
                        $('#btn_equipment_tool_change').trigger('click');
                    },
                    error: function(data, status, err) {
                    }
                });
            }
        }

        function change_equipment_car(id) {
            $('#lease_type').val(0);
            if ($('#company_id').val() == '' || $('#company_id').val() == undefined) {
                return;
            }
            if (id == 0) {
                $('#id').val(0);
                $('#equipment_car_name').val('');
                $('#equipment_car_startdate').val('');
                $('#save_equipment_car').html("{{trans('login.add')}}");
                $('#btn_equipment_car_change').trigger('click');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_equipment_info') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        $('#id').val(v.id);
                        $('#equipment_car_name').val(v.name);
                        $('#equipment_car_startdate').val(v.start_date);
                        $('#save_equipment_car').html("{{trans('login.change')}}");
                        $('#btn_equipment_car_change').trigger('click');
                    },
                    error: function(data, status, err) {
                    }
                });
            }
        }

        function delete_type(id) {
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_type') }}",
                    data: {
                        id: id,
                    },
                    success: function (v) {
                        type_table.draw();
                        equipment_price_tool_table.draw();
                        equipment_price_car_table.draw();
                    },
                    error: function(data, status, err) {
                    }
                });
            })
        }

        function delete_equipment(id, type) {
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_equipment') }}",
                    data: {
                        id: id,
                    },
                    success: function (v) {
                        if (type == 1) {
                            equipment_tool_table.draw();
                            equipment_price_tool_table.draw();
                        } else {
                            equipment_car_table.draw();
                            equipment_price_car_table.draw();
                        }
                    },
                    error: function(data, status, err) {
                    }
                });
            })
        }

        function save_type() {
            if ($('#type_name').val() == '') {
                $('#type_name').focus();
                return;
            }
            const eptinfo = equipment_price_tool_table.page.info();
            const epcinfo = equipment_price_car_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/add_type') }}",
                data: {
                    id: $('#id').val(),
                    company_id: $('#company_id').val(),
                    name: $('#type_name').val(),
                },
                success: function (v) {
                    $('.btn-secondary').trigger('click');
                    type_table.draw();
                    equipment_price_tool_table.draw();
                    equipment_price_car_table.draw();
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                    equipment_price_tool_table.page(eptinfo.page).draw(false);
                    equipment_price_car_table.page(epcinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function save_equipment_tool() {
            if ($('#equipment_tool_name').val() == '') {
                $('#equipment_tool_name').focus();
                return;
            }
            if ($('#equipment_tool_startdate').val() == '') {
                $('#equipment_tool_startdate').focus();
                return;
            }
            const etinfo = equipment_tool_table.page.info();
            const eptinfo = equipment_price_tool_table.page.info();

            $.ajax({
                type: "POST",
                url: "{{ url('/add_equipment') }}",
                data: {
                    id: $('#id').val(),
                    company_id: $('#company_id').val(),
                    name: $('#equipment_tool_name').val(),
                    start_date: $('#equipment_tool_startdate').val(),
                    type: 1,
                },
                success: function (v) {
                    $('.btn-secondary').trigger('click');
                    equipment_tool_table.draw();
                    equipment_price_tool_table.draw();
                    equipment_tool_table.page(etinfo.page).draw(false);
                    equipment_price_tool_table.page(eptinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function save_equipment_car() {
            if ($('#equipment_car_name').val() == '') {
                $('#equipment_car_name').focus();
                return;
            }
            const ecinfo = equipment_car_table.page.info();
            const epcinfo = equipment_price_car_table.page.info();

            $.ajax({
                type: "POST",
                url: "{{ url('/add_equipment') }}",
                data: {
                    id: $('#id').val(),
                    company_id: $('#company_id').val(),
                    name: $('#equipment_car_name').val(),
                    start_date: $('#equipment_car_startdate').val(),
                    type: 0,
                },
                success: function (v) {
                    $('.btn-secondary').trigger('click');
                    equipment_car_table.draw();
                    equipment_price_car_table.draw();
                    equipment_car_table.page(ecinfo.page).draw(false);
                    equipment_price_car_table.page(epcinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function add_worker(type) {
            $('#kt_modal_worker_add .worker_type').val(type);
            if (type == 0) {
                $('#kt_modal_worker_add .worker_title').html("{{trans('login.worker_regist')}}");
                $('#kt_modal_worker_add .tax_container').hide();
            } else {
                $('#kt_modal_worker_add .tax_container').show();
                $('#kt_modal_worker_add .worker_tax').prop('checked', true);
            }
            $('#visible_container').hide();

            $('#id').val(0);
            $('#kt_modal_worker_add .worker_name').val('');
            $('#kt_modal_worker_add .worker_labor_cost').val('');
            $('#kt_modal_worker_add .number-label').html('&nbsp;');
            $('#kt_modal_worker_add .worker_labor_startdate').val('');
            $('#btn_worker_add').trigger('click');
        }

        function create_worker() {
            var worker_type = $('#kt_modal_worker_add .worker_type').val();
            if ($('#kt_modal_worker_add .worker_name').val() == '') {
                $('#kt_modal_worker_add .worker_name').focus();
                return;
            }
            if ($('#kt_modal_worker_add .worker_labor_cost').val() == '') {
                $('#kt_modal_worker_add .worker_labor_cost').focus();
                return;
            }
            if ($('#kt_modal_worker_add .worker_labor_startdate').val() == '') {
                $('#kt_modal_worker_add .worker_labor_startdate').focus();
                return;
            }
            const wtinfo = worker_table.page.info();
            const whinfo = worker_hidden_table.page.info();
            const otinfo = outsider_table.page.info();
            const ohinfo = outsider_hidden_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/add_personal') }}",
                data: {
                    id: $('#id').val(),
                    worker_type: worker_type,
                    worker_name: $('#kt_modal_worker_add .worker_name').val(),
                    worker_labor_cost: $('#kt_modal_worker_add .worker_labor_cost').val().replace(/,/g, ''),
                    worker_labor_startdate: $('#kt_modal_worker_add .worker_labor_startdate').val(),
                    worker_tax: $('#kt_modal_worker_add .worker_tax').prop('checked') ? 1 : 0,
                },
                success: function (v) {
                    $('.btn-secondary').trigger('click');
                    if (worker_type == 0) {
                        worker_table.draw();
                        worker_hidden_table.draw();
                        worker_table.page(wtinfo.page).draw(false);
                        worker_hidden_table.page(whinfo.page).draw(false);
                    } else {
                        outsider_table.draw();
                        outsider_hidden_table.draw();
                        outsider_table.page(otinfo.page).draw(false);
                        outsider_hidden_table.page(ohinfo.page).draw(false);
                    }
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                },
                error: function(data, status, err) {
                }
            });
        }

        function delete_worker(id, type) {
            const wtinfo = worker_table.page.info();
            const whinfo = worker_hidden_table.page.info();
            const otinfo = outsider_table.page.info();
            const ohinfo = outsider_hidden_table.page.info();
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_personal') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        if (type == 0) {
                            worker_table.draw();
                            worker_hidden_table.draw();
                            $('#worker_price_container').removeClass("kt-visible").addClass("kt-hidden");
                            worker_table.page(wtinfo.page).draw(false);
                            worker_hidden_table.page(whinfo.page).draw(false);
                        } else {
                            outsider_table.draw();
                            outsider_hidden_table.draw();
                            $('#outer_price_container').removeClass("kt-visible").addClass("kt-hidden");
                            outsider_table.page(otinfo.page).draw(false);
                            outsider_hidden_table.page(ohinfo.page).draw(false);
                        }
                    },
                    error: function(data, status, err) {
                    }
                });
            })
        }

        function change_worker(id, type) {
            $('#id').val(id);
            $('#kt_modal_worker_edit .worker_type').val(type);
            if (type == 0) {
                $('#kt_modal_worker_edit .worker_title').html("{{trans('login.worker_regist')}}");
            } else {
                $('#kt_modal_worker_edit .worker_title').html("{{trans('login.outsider_regist')}}");
            }
            $.ajax({
                type: "POST",
                url: "{{ url('/get_personal_info') }}",
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function (v) {
                    console.log(v);
                    $('#id').val(v.id);
                    $('#kt_modal_worker_edit .worker_name').val(v.name);
                    $('#kt_modal_worker_edit .worker_visible').prop('checked', v.visible == 0);
                    $('#kt_modal_worker_edit .worker_labor_startdate').val(v.start_date);
                    $('#kt_modal_worker_edit .save_worker').html("{{trans('login.change')}}");
                    $('#btn_worker_edit').trigger('click');
                },
                error: function(data, status, err) {
                }
            });
        }

        function edit_worker() {
            if ($('#kt_modal_worker_edit .worker_name').val() == '') {
                $('#kt_modal_worker_edit .worker_name').focus();
                return;
            }
            const wtinfo = worker_table.page.info();
            const whinfo = worker_hidden_table.page.info();
            const otinfo = outsider_table.page.info();
            const ohinfo = outsider_hidden_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/edit_personal') }}",
                data: {
                    id: $('#id').val(),
                    worker_name: $('#kt_modal_worker_edit .worker_name').val(),
                    worker_labor_startdate: $('#kt_modal_worker_edit .worker_labor_startdate').val(),
                    worker_visible: $('#kt_modal_worker_edit .worker_visible').prop('checked') ? 0 : 1,
                },
                success: function (v) {
                    $('#kt_modal_worker_edit .btn-secondary').trigger('click');
                    worker_table.draw();
                    worker_hidden_table.draw();
                    outsider_table.draw();
                    outsider_hidden_table.draw();
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                    worker_table.page(wtinfo.page).draw(false);
                    worker_hidden_table.page(whinfo.page).draw(false);
                    outsider_table.page(otinfo.page).draw(false);
                    outsider_hidden_table.page(ohinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function price_worker(id, name, type) {
            $('#id').val(id);
            if (type == 0) {
                $('#worker_price_container').removeClass("kt-hidden").addClass("kt-visible");
                $('#worker_price_title').html(`${name}様の人件費`);
                worker_price_table.draw();
            } else {
                $('#outer_price_container').removeClass("kt-hidden").addClass("kt-visible");
                $('#outer_price_title').html(`${name}様の人件費`);
                outer_price_table.draw();
            }
        }

        function add_worker_price(type) {
            $('#kt_modal_worker_price .price_id').val(0);
            if (type == 0) {
                $('#kt_modal_worker_price .worker_title').html("{{trans('login.worker_regist')}}");
                $('#kt_modal_worker_price .tax_container').hide();
                $('#kt_modal_worker_price .worker_tax').prop('checked', false);
            } else {
                $('#kt_modal_worker_price .worker_title').html("{{trans('login.outsider_regist')}}");
                $('#kt_modal_worker_price .tax_container').show();
                $('#kt_modal_worker_price .worker_tax').prop('checked', true);
            }
            $('#kt_modal_worker_price .worker_labor_cost').val('');
            $('#kt_modal_worker_price .worker_labor_startdate').val('');
            $('#kt_modal_worker_price .save_worker').html("{{trans('login.add')}}");
            $('#btn_worker_price').trigger('click');
        }

        function change_worker_price(id, type) {
            $('#kt_modal_worker_price .price_id').val(id);
            if (type == 0) {
                $('#kt_modal_worker_price .worker_title').html("{{trans('login.worker_regist')}}");
                $('#kt_modal_worker_price .tax_container').hide();
            } else {
                $('#kt_modal_worker_price .worker_title').html("{{trans('login.outsider_regist')}}");
                $('#kt_modal_worker_price .tax_container').show();
            }
            $.ajax({
                type: "POST",
                url: "{{ url('/get_price') }}",
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function (v) {
                    $('#kt_modal_worker_price .worker_labor_cost').val(Math.round(v.price));
                    $('#kt_modal_worker_price .number-label').html(Math.round(v.price).toLocaleString());
                    $('#kt_modal_worker_price .worker_labor_startdate').val(v.start_date);
                    $('#kt_modal_worker_price .worker_tax').prop('checked', v.tax == 1);
                    $('#kt_modal_worker_price .save_worker').html("{{trans('login.change')}}");
                    $('#btn_worker_price').trigger('click');
                },
                error: function(data, status, err) {
                }
            });
        }

        function edit_price() {
            if ($('#kt_modal_worker_price .worker_price').val() == '') {
                return;
            }
            if ($('#kt_modal_worker_price .worker_labor_startdate').val() == '') {
                return;
            }
            const wtinfo = worker_table.page.info();
            const wpinfo = worker_price_table.page.info();
            const otinfo = outsider_table.page.info();
            const opinfo = outer_price_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/edit_price') }}",
                data: {
                    worker_id: $('#id').val(),
                    id: $('#kt_modal_worker_price .price_id').val(),
                    worker_labor_cost: $('#kt_modal_worker_price .worker_labor_cost').val().replace(/,/g, ''),
                    worker_labor_startdate: $('#kt_modal_worker_price .worker_labor_startdate').val(),
                    worker_tax: $('#kt_modal_worker_price .worker_tax').prop('checked') ? 1 : 0,
                },
                success: function (v) {
                    $('.btn-secondary').trigger('click');
                    worker_table.draw();
                    worker_price_table.draw();
                    outsider_table.draw();
                    outer_price_table.draw();
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                    worker_table.page(wtinfo.page).draw(false);
                    outsider_table.page(otinfo.page).draw(false);
                    worker_price_table.page(wpinfo.page).draw(false);
                    outer_price_table.page(opinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function delete_worker_price(id, type) {
            const wtinfo = worker_table.page.info();
            const otinfo = outsider_table.page.info();
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_price') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        worker_table.draw();
                        worker_price_table.draw();
                        outsider_table.draw();
                        outer_price_table.draw();
                        worker_table.page(wtinfo.page).draw(false);
                        outsider_table.page(otinfo.page).draw(false);
                    },
                    error: function(data, status, err) {
                    }
                });
            })
        }

        function show_worker(id) {
            const wtinfo = worker_table.page.info();
            const whinfo = worker_hidden_table.page.info();
            const otinfo = outsider_table.page.info();
            const ohinfo = outsider_hidden_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/show_worker') }}",
                data: {
                    id: id,
                },
                success: function (v) {
                    worker_table.draw();
                    worker_hidden_table.draw();
                    outsider_table.draw();
                    outsider_hidden_table.draw();
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                    worker_table.page(wtinfo.page).draw(false);
                    worker_hidden_table.page(whinfo.page).draw(false);
                    outsider_table.page(otinfo.page).draw(false);
                    outsider_hidden_table.page(ohinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function change_user(id) {
            if (id == 0) {
                $('#id').val(0);
                $('#user_id').val('');
                $('#user_name').val('');
                $('#user_password').val('');
                $('#user_password_confirm').val('');
                $('#user_role').val(0);
                $('#user_role').parent().children('button').children('.filter-option').children('.filter-option-inner').children('.filter-option-inner-inner').html(role_html[0]);
                $('#save_user').html("{{trans('login.add')}}");
                $('#btn_user_change').trigger('click');


            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_user_info') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        $('#id').val(v.id);
                        $('#user_id').val(v.userID);
                        $('#user_name').val(v.name);
                        $('#user_password').val('');
                        $('#user_password_confirm').val('');
                        $('#user_role').val(v.role);
                        $('#user_role').parent().children('button').children('.filter-option').children('.filter-option-inner').children('.filter-option-inner-inner').html(role_html[v.role]);
                        $('#save_user').html("{{trans('login.change')}}");
                        $('#btn_user_change').trigger('click');

                    },
                    error: function(data, status, err) {
                    }
                });
            }
        }

        function delete_user(id) {
            const uinfo = user_table.page.info();
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_user') }}",
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (v) {
                        user_table.draw();
                        user_table.page(uinfo.page).draw(false);
                    },
                    error: function(data, status, err) {
                    }
                });
            })

        }

        function save_user() {
            if ($('#user_id').val() == '') {
                $('#user_id').focus();
                return;
            }
            if ($('#user_name').val() == '') {
                $('#user_name').focus();
                return;
            }
            if ($('#user_password').val() == '') {
                $('#user_password').focus();
                return;
            }
            if ($('#user_password_confirm').val() != $('#user_password').val()) {
                $('#user_password_confirm').focus();
                showNotification("エラーです", "{{trans('login.password_confirm')}}", "warning");
                return;
            }
            const uinfo = user_table.page.info();

            $.ajax({
                type: "POST",
                url: "{{ url('/add_user') }}",
                data: {
                    id: $('#id').val(),
                    userID: $('#user_id').val(),
                    name: $('#user_name').val(),
                    password: $('#user_password').val(),
                    role: $('#user_role').val(),
                },
                success: function (v) {
                    if (v.error && v.error == '101') {
                        showNotification("エラーです", "既に存在するIDです。", "warning");
                    } else {
                        $('.btn-secondary').trigger('click');
                        user_table.draw();
                        user_table.page(uinfo.page).draw(false);
                    }
                },
                error: function(data, status, err) {
                }
            });
        }

        function change_equipment_price(equip_id, type_id, price_id) {
            $('#kt_modal_equip_price .type_id').val(type_id);
            $('#kt_modal_equip_price .equip_id').val(equip_id);
            $('#kt_modal_equip_price .price_id').val(price_id);
            if (price_id != 0) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_equipment_price_one') }}",
                    data: {
                        id: price_id,
                    },
                    success: function (v) {
                        $('#kt_modal_equip_price .equip_price').val(Math.round(v.price));
                        $('#kt_modal_equip_price .number-label').html(Math.round(v.price).toLocaleString());
                        $('#kt_modal_equip_price .equip_price_startdate').val(v.start_date);
                        $('#btn_equip_price').trigger('click');
                    },
                    error: function(data, status, err) {
                    }
                });
            } else {
                $('#kt_modal_equip_price .equip_price').val('');
                $('#kt_modal_equip_price .number-label').html('&nbsp;');
                $('#kt_modal_equip_price .equip_price_startdate').val('');
                $('#btn_equip_price').trigger('click');
            }
        }

        function list_equipment_price(type_id, equip_id, type) {
            $('#kt_modal_equip_price .type_id').val(type_id);
            $('#kt_modal_equip_price .equip_id').val(equip_id);
            if (type == 0) {
                equipment_price_list_table.draw();
            } else {
                equipment_price_car_list_table.draw();
            }
        }

        function update_equip_price() {
            var type_id = $('#kt_modal_equip_price .type_id').val();
            var equip_id = $('#kt_modal_equip_price .equip_id').val();
            var price_id = $('#kt_modal_equip_price .price_id').val();
            var price = $('#kt_modal_equip_price .equip_price').val().replace(/,/g, '');
            var startdate = $('#kt_modal_equip_price .equip_price_startdate').val();
            if (price == '') {
                return;
            }
            const eptinfo = equipment_price_tool_table.page.info();
            const eplinfo = equipment_price_list_table.page.info();
            const epcinfo = equipment_price_car_table.page.info();
            const epclinfo = equipment_price_car_list_table.page.info();
            $.ajax({
                type: "POST",
                url: "{{ url('/change_equipment_price') }}",
                data: {
                    type_id: type_id,
                    equip_id: equip_id,
                    price_id: price_id,
                    price: price,
                    startdate: startdate,
                },
                success: function (v) {
                    $('#kt_modal_equip_price .btn-secondary').trigger('click');
                    equipment_price_tool_table.draw();
                    equipment_price_list_table.draw();
                    equipment_price_car_table.draw();
                    equipment_price_car_list_table.draw();
                    showNotification("success", "{{trans('login.change_success')}}", "success");
                    equipment_price_tool_table.page(eptinfo.page).draw(false);
                    equipment_price_list_table.page(eplinfo.page).draw(false);
                    equipment_price_car_table.page(epcinfo.page).draw(false);
                    equipment_price_car_list_table.page(epclinfo.page).draw(false);
                },
                error: function(data, status, err) {
                }
            });
        }

        function delete_equip_price(id) {
            const eptinfo = equipment_price_tool_table.page.info();
            const eplinfo = equipment_price_list_table.page.info();
            const epcinfo = equipment_price_car_table.page.info();
            const epclinfo = equipment_price_car_list_table.page.info();
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_equip_price') }}",
                    data: {
                        id: id,
                    },
                    success: function (v) {
                        equipment_price_tool_table.draw();
                        equipment_price_list_table.draw();
                        equipment_price_car_table.draw();
                        equipment_price_car_list_table.draw();
                        showNotification("success", "{{trans('login.change_success')}}", "success");
                        equipment_price_tool_table.page(eptinfo.page).draw(false);
                        equipment_price_list_table.page(eplinfo.page).draw(false);
                        equipment_price_car_table.page(epcinfo.page).draw(false);
                        equipment_price_car_list_table.page(epclinfo.page).draw(false);
                    },
                    error: function(data, status, err) {
                    }
                });
            });
        }

        function init_tool() {
            $('#company_id').on('change', function () {
                type_table.draw();
                equipment_tool_table.draw();
                equipment_price_tool_table.draw();
                equipment_car_table.draw();
                equipment_price_car_table.draw();
            });
        }

        function init_tax() {
            $.ajax({
                type: "GET",
                url: "{{ url('/get_taxes_list') }}",
                success: function (v) {
                    $('#kt_group_taxes').html(v);
                    init_event_tax();
                },
                error: function(data, status, err) {
                }
            });
        }

        function init_event_tax() {
            $('.form_date').datepicker({
                format: 'yyyy/mm/dd',
                language: 'jp',
                orientation: 'bottom',
            });
        }

        $(document).ready(function () {
            if ($('#kt_table_lease_company')) {
                company_table.init();
            }

            if ($('#kt_table_lease_type')) {
                type_table.init();
            }

            if ($('#kt_table_lease_equipment_tool')) {
                equipment_tool_table.init();
            }

            if ($('#kt_table_lease_equipment_price_tool')) {
                equipment_price_tool_table.init();
            }

            if ($('#kt_table_lease_equipment_car')) {
                equipment_car_table.init();
            }

            if ($('#kt_table_lease_equipment_price_car')) {
                equipment_price_car_table.init();
            }

            if ($('#kt_table_worker')) {
                worker_table.init();
            }

            if ($('#kt_table_worker_hidden')) {
                worker_hidden_table.init();
            }

            if ($('#kt_table_worker_price')) {
                worker_price_table.init();
            }

            if ($('#kt_table_outsider')) {
                outsider_table.init();
            }

            if ($('#kt_table_outsider_hidden')) {
                outsider_hidden_table.init();
            }

            if ($('#kt_table_user')) {
                user_table.init();
            }

            init_tool();
            init_tax();
        });
    </script>
@endsection
