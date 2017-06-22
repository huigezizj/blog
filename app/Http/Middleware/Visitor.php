<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Home\CommonController;
use Closure;
use Zhuzhichao\IpLocationZh\Ip;
use Illuminate\Support\Facades\Session;

class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip=CommonController::getIp();
        $addr=IP::find($ip);
        $addr['time']=time();

        //将访客记录进session
        $visitors = session('visitor');

        //ip+addr存入session
        if (isset($visitors)&&isset($visitors[$ip])) {

        }else{
            $visitors[$ip]=$addr;
            session(['visitor'=>$visitors]);
//            Session::save();
        }
        return $next($request);
    }
}
