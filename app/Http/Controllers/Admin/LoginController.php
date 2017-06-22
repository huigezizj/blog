<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once "resources/org/code/Code.class.php";

class LoginController extends CommonController
{
    public function login() {

        if ($input=Input::all()) {
            $code=new \Code();

            if (strtoupper($input['code'])!=$code->get()){
                return back()->with('msg','验证码错误！');
            }
            $user=User::first();

            if ($user->user_name!=$input['user_name'] || Crypt::decrypt($user->user_pass)!=$input['user_password']) {
                return back()->with('msg','用户名或者密码错误！');
            }
            //登录成功
            session(['user'=>$user]);
            return redirect('admin');
//            dd(session('user'));

        }else{
            if (isset(session('user')->user_id)&& session('user')->user_id==1) {
                return redirect('admin');
            }
//            if () {
//            }
            return view('admin.login');
        }

    }

    public function quit() {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function code() {
        $code=new \Code();
        $code->num(4);
        $dis=$code->make();
        dd($dis);
    }
    public function crypt() {
        $dis=encrypt('123456');
        dd($dis);
    }
}
