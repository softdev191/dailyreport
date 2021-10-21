<button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_equip_price" id="btn_equip_price"></button>
<div class="modal fade" id="kt_modal_equip_price" tabindex="-1" role="dialog" aria-labelledby="worker_title" aria-hidden="true">
    <input type="hidden" class="type_id" />
    <input type="hidden" class="equip_id" />
    <input type="hidden" class="price_id" />
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title worker_title">建設機材費</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped- table-bordered">
                    <tbody>
                        <form autocomplete="off">
                            <tr>
                                <td class="td_head" style="width: 30%">費用</td>
                                <td style="width: 70%">
                                    <label class="number-label">&nbsp;</label>
                                    <input type="text" class="form-control equip_price price" style="width: 230px; padding: 0px 13px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.start_date')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control form_date equip_price_startdate" style="width: 230px; padding: 0px 13px;" readonly>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                <button type="button" class="btn btn-primary" onclick="update_equip_price()">{{trans('login.add')}}</button>
            </div>
        </div>
    </div>
</div>
