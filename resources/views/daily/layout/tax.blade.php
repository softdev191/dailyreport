@foreach ($taxes as $tax)
    <div class="col-lg-12 kt-portlet__body_search">
        <input class="tax_id" type="hidden" value="{{ $tax->id }}" />
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-2" style="text-align: right">
                <label style="margin-top: 10px;">{{trans('login.excise')}}</label>
            </div>
            <div class="col-lg-3">
                <input
                    type="number"
                    class="form-control tax_value"
                    placeholder="{{trans('login.excise_enter')}}"
                    min="0"
                    max="100"
                    step="1"
                    value="{{$tax ? $tax->price : ''}}"
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
                    class="form-control form_date tax_startdate"
                    style="width: 210px; padding: 0px 13px;"
                    readonly
                    value="{{ $tax->start_date }}"
                >
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-brand btn-edit-tax" onclick="edit_tax(this)">{{trans('login.change')}}</button>
                <button type="button" class="btn btn-danger btn-delete-tax" onclick="delete_tax(this)">削除する</button>
            </div>
        </div>
    </div>
@endforeach
