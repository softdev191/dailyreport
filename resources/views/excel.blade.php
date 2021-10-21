<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sheet1</title>
    </head>
    <body>
    <table>
        <tbody>
            <tr>
                <td style="height: 46px"></td>
            </tr>
            <tr>
                @foreach ($spot as $key => $value)
                <td style="color: black;background: #D9E1F2;text-align: center;width: 10px;height: 46px;border: 1px solid #A6A6A6;font-weight:bold">
                    {{$key}}
                </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($spot as $key => $value)
                    <td style="color: black; text-align: center; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$value}}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($spot as $key => $value)
                    <td style="color: black; text-align: center; width: 20px; height: 46px; border: 1px solid #A6A6A6"></td>
                @endforeach
            </tr>
            <tr>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 61px; border: 1px solid #A6A6A6;font-weight:bold;">日付</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">人件費</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">建設車両</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">金額</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">建設機材</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">金額</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">処分</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">金額</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">その他</td>
                <td style="color: black;background: #D9E1F2;text-align: center;width: 20px;height: 46px; border: 1px solid #A6A6A6;font-weight:bold">金額</td>
            </tr>
        @for($i=0;$i<count($report);$i++)
            <tr style="vertical-align: middle;">
                <td style="text-align: center; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a1']}}</td>
                <td style="text-align: left; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a2']}} : {{$report[$i]['a3']}}</td>
                <td style="text-align: left; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a4']}}@if($report[$i]['a4'] != '') <br> @endif {{$report[$i]['a14']}}</td>
                <td style="text-align: right; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a5']}}</td>
                <td style="text-align: left; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a6']}}@if($report[$i]['a6'] != '') <br> @endif {{$report[$i]['a15']}}</td>
                <td style="text-align: right; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a7']}}</td>
                <td style="text-align: left; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a10']}}</td>
                <td style="text-align: right; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a11']}}</td>
                <td style="text-align: left; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a12']}}</td>
                <td style="text-align: right; width: 20px; height: 46px; border: 1px solid #A6A6A6">{{$report[$i]['a13']}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
    </body>
</html>
