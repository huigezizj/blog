<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload() {
        $file=Input::file('Filedata');
        if ($file->isvalid()) {

            $extension=$file->getClientOriginalExtension();//后缀
            $newName=date('YmdHis',time()).mt_rand(000,999).'.'.$extension;
            $path=$file->move(base_path().'/uploads',$newName);
            $filepath= 'uploads/'.$newName;
            return  $filepath;
        }
    }
}
