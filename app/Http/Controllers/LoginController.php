<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function loginProcess(Request $request)
    {
        $result = [
            'status' => false,
            'token' => '',
            'msg' => '',
        ];

        try {

            $user = User::where([
                'username' => $request->input('username'),
                'status' => '1',
            ])->first();

            if (empty($user)) {
                $result['msg'] = '查無此帳號';
                throw new Exception($result['msg']);
            }

            // 比對密碼
            if (!Hash::check($request->input('password'), $user['password'])) {
                $result['msg'] = '密碼錯誤';
                throw new Exception($result['msg']);
            }

            //塞入使用者其他資訊
            $staff = $user->only(['username', 'id']);

            session()->put('user', $user);
            $result['status'] = true;
            $result['msg'] = '登入成功';

        } catch (Exception $e) {
            return response()->json($result);

        }
        return response()->json($result);

    }
}
