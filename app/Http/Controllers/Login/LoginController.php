<?php

namespace App\Http\Controllers\Login;

use App\Model\RegisterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        header("Access-Control-Allow-Origin:http://www.hblogin.com");
        $account=$request->account;
        $password=$request->password;
//        $password1=$request->password1;
        $data =[
            'account'=>$account,
            'password'=>$password,
        ];
        $res =RegisterModel::insert($data);
//        dd($res);
        if($res){
            echo 0;;
        }else{
            echo 1;
        }
    }
    public function login(Request $request)
    {
        header("Access-Control-Allow-Origin:http://www.hblogin.com");
        $account=$request->account;
        $password=$request->password;
        $data =[
            'account'=>$account,
            'password'=>$password,
        ];
        $res =RegisterModel::where('account',$account)->first();
        $res1=json_encode($res);
        $pwd=($res['password']);
        if(empty($res)){
            //账号不存在
            echo 0;
        }else{
        //登录成功
        if($password==$pwd){
          file_put_contents('login.txt',$res1);
        //            session(['id'=>$res['id'],'account'=>$account]);
//            Redis::class('name','');
            echo 2;
        }else{
            echo 3;
        }
    }
    }
}
