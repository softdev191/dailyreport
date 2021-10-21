<div class="tab-pane" id="kt_tabs_2" role="tabpanel">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{trans('login.oursider_master')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="col-lg-12 kt-portlet__body_search">
                <div class="col-lg-12 kt-portlet__body_search">
                    <div class="row" style="margin: 10px 0 20px;">
                        <button type="button" class="btn btn-brand" onclick="add_worker(1)">{{trans('login.outsider_add')}}</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped- table-bordered" id="kt_table_outsider">
                                <thead>
                                <tr>
                                    <th width="30%">{{trans('login.name')}}</th>
                                    <th width="30%">{{trans('login.labor_cost')}}</th>
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
            <div class="col-lg-12 kt-portlet__body_search kt-hidden" id="outer_price_container">
                <div class="row" style="margin: 10px 0 20px;">
                    <button type="button" class="btn btn-brand" onclick="add_worker_price(0)">人件費追加する</button>
                </div>
                <div class="row" style="margin: 10px 0 20px;" id="outer_price_title">
                    A様の人件費
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped- table-bordered" id="kt_table_outer_price">
                            <thead>
                            <tr>
                                <th width="30%">人件費</th>
                                <th width="30%">改定日</th>
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
                <h3 class="kt-portlet__head-title">非表示一覧表示</h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="col-lg-12 kt-portlet__body_search">
                <div class="col-lg-12 kt-portlet__body_search">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped- table-bordered" id="kt_table_outsider_hidden">
                                <thead>
                                <tr>
                                    <th width="30%">{{trans('login.name')}}</th>
                                    <th width="30%">{{trans('login.labor_cost')}}</th>
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
    </div>
</div>
