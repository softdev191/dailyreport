<div class="tab-pane" id="kt_tabs_6" role="tabpanel">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{trans('login.user_master')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="col-lg-12 kt-portlet__body_search">
                <div class="row" style="margin: 10px 0 20px;">
                    <button type="button" class="btn btn-brand" onclick="change_user(0)">{{trans('login.user_add')}}</button>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped- table-bordered" id="kt_table_user">
                            <thead>
                            <tr>
                                <th width="20%">{{trans('login.name')}}</th>
                                <th width="20%">ID</th>
                                <th width="20%">{{trans('login.role')}}</th>
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
