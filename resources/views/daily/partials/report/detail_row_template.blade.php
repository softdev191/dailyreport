<tr class="item_content light-border" data-value="0">
    <form autocomplete="off">
        <td class="work_select" style="width: 10%;min-width: 150px">
            <select class="form-control worker_select" onchange="check_all_empty(this)">
                <option value="0"></option>
                @foreach($worker as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <select class="form-control worker_type_select" onchange="check_all_empty(this)">
                <option value="1"></option>
                <option value="0.5">{{trans('login.night')}}</option>
            </select>
            <input type="number" class="hidden hidden_value" value="0">
        </td>
        <td class="tool_select" style="width: 17%;min-width: 150px">
            <select class="form-control company_select company_select_vehicle" onchange="check_all_empty(this)">
                <option value="0"></option>
                @foreach($company as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <select class="form-control type_select type_select_vehicle" data-value="0" onchange="check_all_empty(this)"></select>
            <select class="form-control car_select" onchange="check_all_empty(this)"></select>
            <input type="number" class="hidden hidden_value hidden_car_value" value="0">
        </td>
        <td style="width: 7%;min-width: 150px" class="car_value"></td>
        <td class="tool_select" style="width: 17%;min-width: 150px">
            <select class="form-control company_select company_select_equip" onchange="check_all_empty(this)">
                <option value="0"></option>
                @foreach($company as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <select class="form-control type_select type_select_equip" data-value="1" onchange="check_all_empty(this)"></select>
            <select class="form-control equipment_select" onchange="check_all_empty(this)"></select>
            <input type="number" class="hidden hidden_value hidden_equipment_value" value="0">
        </td>
        <td style="width: 7%;min-width: 150px" class="equipment_value"></td>
        <td style="width: 7%;min-width: 150px"><input type="text" class="form-control disposal_name" onchange="check_all_empty(this)"></td>
        <td style="width: 7%;min-width: 150px">
            <label class="number-label">&nbsp;</label>
            <input type="text" class="form-control disposal_value price" onchange="check_all_empty(this)">
        </td>
        <td style="width: 7%;min-width: 150px"><input type="text" class="form-control etc_name" onchange="check_all_empty(this)"></td>
        <td style="width: 7%;min-width: 150px">
            <label class="number-label">&nbsp;</label>
            <input type="text" class="form-control etc_value price" onchange="check_all_empty(this)">
        </td>
        <td style="width: 5%">
            <button type="button" class="btn btn-danger" onclick="delete_report_row(this)">{{trans('login.delete')}}</button>
        </td>
    </form>
</tr>
<script>
    function check_all_empty(that) {
        var parent = $(that).closest('.item_content');
        var item = {};
        item.worker_id = $(parent).find('.worker_select').val();
        item.car_company_id = $(parent).find('.company_select_vehicle').val();
        item.car_type_id = $(parent).find('.type_select_vehicle').val();
        item.car_eqiup_id = $(parent).find('.car_select').val();
        item.tool_company_id = $(parent).find('.company_select_equip').val();
        item.tool_type_id = $(parent).find('.type_select_equip').val();
        item.tool_eqiup_id = $(parent).find('.equipment_select').val();
        item.disposal_name = $(parent).find('.disposal_name').val();
        item.disposal_value = $(parent).find('.disposal_value').val();
        item.etc_name = $(parent).find('.etc_name').val();
        item.etc_value = $(parent).find('.etc_value').val();
        var isEmpty = true;
        for (const [key, value] of Object.entries(item)) {
            isEmpty = isEmpty && (value == null || value == '' || value == 0);
        }
        if (isEmpty) {
            $(parent).addClass('light-border');
        } else {
            $(parent).removeClass('light-border');
        }
    }
</script>
