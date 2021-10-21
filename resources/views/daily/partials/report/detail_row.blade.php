<tr class="item_content" data-value="{{$detail->id}}">
    <form autocomplete="off">
        <td class="work_select" style="width: 10%;min-width: 150px">
            <select class="form-control worker_select">
                <option value="0"></option>
                @foreach($worker as $item)
                    @if ($item->visible || $detail->worker_id == $item->id)
                        <option value="{{$item->id}}"
                            @if($detail->worker_id == $item->id) selected @endif
                            @if (!$item->visible) disabled @endif>
                            {{$item->name}}
                        </option>
                    @endif
                @endforeach
            </select>
            <select class="form-control worker_type_select">
                <option value="1" @if($detail->percentage == 1) selected @endif></option>
                <option value="0.5" @if($detail->percentage == 0.5) selected @endif>{{trans('login.night')}}</option>
            </select>
            <input type="number" class="hidden hidden_value" value="{{$detail->worker_value}}">
        </td>
        <td class="tool_select" style="width: 17%;min-width: 150px">
            <select class="form-control company_select company_select_vehicle">
                <option value="0"></option>
                @foreach($company as $item)
                    <option value="{{$item->id}}" @if($detail->trucks_company_id == $item->id) selected @endif>{{$item->name}}</option>
                @endforeach
            </select>
            <select class="form-control type_select type_select_vehicle" data-value="0">
                @if($detail->trucks_company_id > 0 && count($detail->arr_car_type) > 0)
                    <option value="0"></option>
                    @foreach($detail->arr_car_type as $item)
                        <option value="{{$item->id}}" @if($detail->trucks_type_id == $item->id) selected @endif>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <select class="form-control car_select">
                @if($detail->trucks_company_id > 0 && count($detail->arr_car_equip) > 0)
                    <option value="0"></option>
                    @foreach($detail->arr_car_equip as $item)
                        <option value="{{$item->id}}" @if($detail->trucks_tool_id == $item->id) selected @endif>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <input type="number" class="hidden hidden_value hidden_car_value" @if($detail->trucks_value != null) value="{{$detail->trucks_value}}" @else value="0" @endif>
        </td>
        <td style="width: 7%;min-width: 150px" class="car_value">{{number_format($detail->trucks_value)}}</td>
        <td class="tool_select" style="width: 17%;min-width: 150px">
            <select class="form-control company_select company_select_equip">
                <option value="0"></option>
                @foreach($company as $item)
                    <option value="{{$item->id}}" @if($detail->equipment_company_id == $item->id) selected @endif>{{$item->name}}</option>
                @endforeach
            </select>
            <select class="form-control type_select type_select_equip" data-value="1">
                @if($detail->equipment_company_id > 0 && count($detail->arr_tool_type) > 0)
                    <option value="0"></option>
                    @foreach($detail->arr_tool_type as $item)
                        <option value="{{$item->id}}" @if($detail->equipment_type_id == $item->id) selected @endif>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <select class="form-control equipment_select">
                @if($detail->equipment_company_id > 0 && count($detail->arr_tool_equip) > 0)
                    <option value="0"></option>
                    @foreach($detail->arr_tool_equip as $item)
                        <option value="{{$item->id}}" @if($detail->equipment_tool_id == $item->id) selected @endif>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <input type="number" class="hidden hidden_value hidden_equipment_value" @if($detail->equipment_value != null) value="{{$detail->equipment_value}}" @else value="0" @endif>
        </td>
        <td style="width: 7%;min-width: 150px" class="equipment_value">{{number_format($detail->equipment_value)}}</td>
        <td style="width: 7%;min-width: 150px"><input type="text" class="form-control disposal_name"  value="{{ $detail->disposal }}"></td>
        <td style="width: 7%;min-width: 150px">
            <label class="number-label">{{ is_numeric($detail->disposal_value) ? number_format($detail->disposal_value) : $detail->disposal_value }}</label>
            <input type="text" class="form-control disposal_value price" value="{{ is_numeric($detail->disposal_value) ? $detail->disposal_value : $detail->disposal_value }}">
        </td>
        <td style="width: 7%;min-width: 150px"><input type="text" class="form-control etc_name"  value="{{ $detail->etc }}"></td>
        <td style="width: 7%;min-width: 150px">
            <label class="number-label">{{ is_numeric($detail->etc_value) ? number_format($detail->etc_value) : $detail->etc_value }}</label>
            <input type="text" class="form-control etc_value price" value="{{ is_numeric($detail->etc_value) ? $detail->etc_value : $detail->etc_value }}"></td>
        <td style="width: 5%">
            <button type="button" class="btn btn-danger" onclick="delete_report_row(this)">{{trans('login.delete')}}</button>
        </td>
    </form>
</tr>
