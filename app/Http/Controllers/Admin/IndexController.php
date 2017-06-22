<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index(){
        return view('admin.index');
    }

    public function info() {
        return view('admin.info');
    }

    public function pass() {

        if (!$input = Input::all()) {
            return view('admin.pass');
        }else{


            $rules=[
                'password'=>'required|between:6,20|confirmed',
            ];
            $message=[
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码长度在6-20位之间！',
                'password.confirmed'=>'新密码不匹配！',
            ];
            $validator=\Validator::make($input,$rules,$message);
            if ($validator->passes()) {
                $user = User::first();
                $_password=\Crypt::decrypt($user->user_pass);
                if ($input['password_o'] != $_password) {
                    return '原密码错误！';
                }
                $user->user_pass=Crypt::encrypt($input['password']);
                $user->update();
                return 1;
            }
            return $validator->errors()->first();
        }
        exit;
    }
}
