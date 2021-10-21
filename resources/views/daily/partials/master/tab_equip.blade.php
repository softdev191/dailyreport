<div class="tab-pane" id="kt_tabs_3" role="tabpanel">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{trans('login.tool_master')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="col-lg-12 kt-portlet__body_search">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{trans('login.lease_company')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="col-lg-12 kt-portlet__body_search">
                            <div class="row" style="margin: 10px 0 20px;">
                                <button type="button" class="btn btn-brand" onclick="change_company(0)">{{trans('login.company_add')}}</button>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_company">
                                        <thead>
                                        <tr>
                                            <th width="30%">NO</th>
                                            <th width="30%">{{trans('login.lease_company_name')}}</th>
                                            <th width="40%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin: 10px 0 20px;">
                    <div class="company_id" style="width: 145px;">
                        <select class="form-control kt-selectpicker" id="company_id">
                            @foreach($company as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{trans('login.lease_type')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="col-lg-12 kt-portlet__body_search">

                            <div class="row" style="margin: 10px 0 20px;">
                                <button type="button" class="btn btn-brand" onclick="change_type(0)">{{trans('login.type_add')}}</button>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_type">
                                        <thead>
                                        <tr>
                                            <th width="20%">NO</th>
                                            <th width="20%">{{trans('login.lease_company')}}</th>
                                            <th width="20%">{{trans('login.lease_type')}}</th>
                                            <th width="40%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{trans('login.tool')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="col-lg-12 kt-portlet__body_search">
                            <div class="row" style="margin: 10px 0 20px;">
                                <button type="button" class="btn btn-brand" onclick="change_equipment_tool(0)">{{trans('login.tool_add')}}</button>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_equipment_tool">
                                        <thead>
                                        <tr>
                                            <th width="20%">NO</th>
                                            <th width="20%">{{trans('login.lease_company')}}</th>
                                            <th width="20%">{{trans('login.tool')}}</th>
                                            <th width="40%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_equipment_price_tool">
                                        <thead>
                                        <tr>
                                            <th width="10%">NO</th>
                                            <th width="20%">{{trans('login.lease_type')}}</th>
                                            <th width="20%">{{trans('login.tool')}}</th>
                                            <th width="20%">{{trans('login.building_tool_cost')}}</th>
                                            <th width="30%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_equipment_price_list">
                                        <thead>
                                        <tr>
                                            <th width="20%">{{trans('login.building_tool_cost')}}</th>
                                            <th width="20%">{{trans('login.start_date')}}</th>
                                            <th width="30%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{trans('login.car')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="col-lg-12 kt-portlet__body_search">
                            <div class="row" style="margin: 10px 0 20px;">
                                <button type="button" class="btn btn-brand" onclick="change_equipment_car(0)">{{trans('login.car_add')}}</button>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_equipment_car">
                                        <thead>
                                        <tr>
                                            <th width="20%">NO</th>
                                            <th width="20%">{{trans('login.lease_company')}}</th>
                                            <th width="20%">{{trans('login.car')}}</th>
                                            <th width="40%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_equipment_price_car">
                                        <thead>
                                        <tr>
                                            <th width="10%">NO</th>
                                            <th width="20%">{{trans('login.lease_type')}}</th>
                                            <th width="20%">{{trans('login.car')}}</th>
                                            <th width="20%">{{trans('login.building_car_cost')}}</th>
                                            <th width="30%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_lease_car_price_list">
                                        <thead>
                                        <tr>
                                            <th width="20%">{{trans('login.building_car_cost')}}</th>
                                            <th width="20%">{{trans('login.start_date')}}</th>
                                            <th width="30%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
