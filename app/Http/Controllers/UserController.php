<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Exception;
use Hash;
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
        $errorMsg = [];
        $user_data['username'] = trim($request->username);
        $user_data['password'] = trim($request->password);
        $user_data['name'] = trim($request->name);
        $user_data['email'] = trim($request->email);
        $user_data['mobile'] = trim($request->mobile);

        if (empty($user_data['username'])) {
            $errorMsg[] = '請輸入姓名';
        }

        if (empty($user_data['password'])) {
            $errorMsg[] = '請輸入密碼';
        }

        if ($user_data['mobile'] == '') {
            $errorMsg[] = '請輸入電話';
        }

        if ($user_data['email'] == '1') {
            $errorMsg[] = '需輸入電子信箱';
        }

        // TODO 有時間補成這種驗證
        // $validate = $this->validate($request, [
        //     'username' => 'required|min:6|max:20',
        //     'password' => 'required|min:6|max:20',
        //     'email' => 'required|email',
        // ]);
        if (empty($errorMsg)) {

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
                $result['status'] = true;
                $result['token'] = $user->id;
                $result['msg'] = '登入成功';

                // TODO 要自動登入
                return response()->json($result);

            } catch (Exception $e) {
                // 失敗訊息
                $errorMsg[] = $e->getMessage();
                DB::rollBack();
            }
        }
        $result['msg'] = $errorMsg;
        return response()->json($result);
    }
}
