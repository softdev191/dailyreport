<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Spot;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $auto_login = $request->session()->get('remember');

        if ($auto_login == 1) {
            if (Auth::attempt(['userID' => $request->session()->get('userID'), 'password' => $request->session()->get('password')])) {
                return redirect()->intended('/home');
            }
        }

        $data = [
            'auto_login' => $auto_login,
        ];
        return view('login', $data);
    }

    public function login(Request $request)
    {
        $exist = User::where('userID', $request->userID)->first();
        if ($exist && $exist->delete) {
            return redirect()->back()->withErrors([trans('login.login_error')]);
        }
        if (Auth::attempt(['userID' => $request->userID, 'password' => $request->password])) {
            if ($request->remember == 'on') {
                $request->session()->put('userID', $request->userID);
                $request->session()->put('password', $request->password);
                $request->session()->put('remember', 1);
            } else {
                $request->session()->put('remember', 0);
            }
            return redirect()->intended('/home');
        } else
            return redirect()->back()->withErrors([trans('login.login_error')]);
    }

    public function add_user(Request $request) {
        $user = User::find($request->id);
        if ($user) {
            return $user->update([
                "userID" => $request->userID,
                "name" => $request->name,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
        } else {
            $exist = User::where('userID', $request->userID)->where('delete', 0)->count();
            if ($exist > 0) {
                return [
                    'error' => '101',
                ];
            }
            return User::create([
                "userID" => $request->userID,
                "name" => $request->name,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
        }
    }

    public function get_user_info(Request $request) {
        return response()->json(User::find($request->id));
    }

    public function delete_user(Request $request) {
        $user = User::find($request->id);

        return $user->update([
            "delete" => 1,
        ]);
    }

    public function get_user_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;

        $user = User::where(['delete' => 0])
            ->orderBy('created_at', 'DESC')
            ->skip($offset)->take($limit)
            ->get();

        $totalFiltered = count(User::where(['delete' => 0])->get());

        $return_data = array();

        for ($idx = 0; $idx < count($user); $idx++) {
            $temp = array();

            $temp[0] = $user[$idx]->name;
            $temp[1] = $user[$idx]->userID;
            $temp[2] = $user[$idx]->role;
            $temp[3] = $user[$idx]->id == Auth::user()->id ? 1 : 0;
            $temp[4] = $user[$idx]->id;
            array_push($return_data, $temp);
        }


        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "memberCnt" => number_format(intval($totalFiltered)),
            "data" => $return_data
        );

        return response() ->json($json_data);
    }

    public function logout(Request $request)
    {
        Spot::where('cur_user_id', Auth::user()->id)->update(['cur_user_id' => 0]);
        Auth::logout();
        $request->session()->put('remember', 0);
        return redirect('/login');
    }
}
