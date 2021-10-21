<div class="tab-pane" id="kt_tabs_5" role="tabpanel">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{trans('login.excise_master')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="col-lg-12 kt-portlet__body_search">
                <div class="row" style="margin-top: 20px">
                    <div class="col-lg-2" style="text-align: right">
                        <label style="margin-top: 10px;">{{trans('login.excise')}}</label>
                    </div>
                    <div class="col-lg-3">
                        <input
                            type="number"
                            class="form-control"
                            id="excise"
                            placeholder="{{trans('login.excise_enter')}}"
                            min="0"
                            max="100"
                            step="1"
                        >
                        <input
                            type="number"
                            class="form-control hidden"
                            id="excise_origin"
                        >
                    </div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-lg-2" style="text-align: right">
                        <label style="margin-top: 10px;">{{trans('login.start_date')}}</label>
                    </div>
                    <div class="col-lg-3">
                        <input
                            type="text"
                            class="form-control form_date"
                            id="tax_startdate"
                            style="width: 210px; padding: 0px 13px;"
                            readonly
                        >
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-brand" onclick="add_tax()">登録する</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">改定日一覧</h3>
            </div>
        </div>
        <div class="kt-portlet__body" id="kt_group_taxes">

        </div>
    </div>
</div>
