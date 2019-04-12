<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use DB;
use Exception;
use Hash;
// use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function registerUser(Request $request)
    {
        // dd($request->all());
        $result = [
            'status' => false,
            'token' => '',
            'msg' => '',
        ];

        $user_data = [];
        $user_data['username'] = trim($request->username);
        $user_data['password'] = trim($request->password);
        $user_data['name'] = trim($request->name);
        $user_data['email'] = trim($request->email);
        $user_data['mobile'] = trim($request->mobile);

        try {
            $validate = $this->validate($request, [
                'username' => 'required|min:6|max:20|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
                'password' => ['required', 'regex:/(^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$)/u', 'min:6', 'max:20'],
                'email' => 'required|email',
            ], [
                'username.required' => '請輸入姓名',
                'password.required' => '請輸入密碼',
                'mobile.required' => '請輸入電話',
                'email.required' => '需輸入電子信箱',
                'email' => '信箱格式錯誤',
                'password.regex' => "密碼格式錯誤",
            ]);

            try {
                $isUserExist = User::where('username', $user_data['username'])
                    ->where('status', '1')
                    ->exists();
                if ($isUserExist) {
                    throw new Exception('已有此會員');
                }

                DB::beginTransaction();
                $user_data['password'] = Hash::make($user_data['password']);
                $user = User::create($user_data);
                DB::commit();

                // 要自動登入
                return app('App\Http\Controllers\LoginController')->loginProcess($request);

                // $result['status'] = true;
                // $result['token'] = $user->id;
                // $result['msg'] = '登入成功';
                // return response()->json($result);

            } catch (Exception $e) {
                // 失敗訊息
                $result['msg'] = $e->getMessage();
                DB::rollBack();
            }

        } catch (Exception $e) {
            // 失敗訊息
            $result['msg'] = $e->getMessage();
            $result['errors'] = $e->errors();
        }

        return response()->json($result);
    }
}
