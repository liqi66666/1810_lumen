<?php

namespace App\Http\Controllers\User;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * 登陆
     */
    public function login(Request $request)
    {
        $u_name = $request->input('u_name');
        $u_pwd = $request->input('u_pwd');

        $data =[
            'u_name'=>$u_name,
            'u_pwd'=>$u_pwd,
        ];
        $res =UserModel::where(['u_name' => $data['u_name'], 'u_pwd' => $data['u_pwd']])->first();
        //var_dump($res);
        if($res) {
            //密码错误
          if($u_pwd==$res->u_pwd){
              echo "登录正确";
          }else{
              echo "密码错误";
          }
        }else{
            //登录成功
            echo "密码错误";
        }

    }
    /**
     * 注册
     */
    public function reg(Request $request)
    {
     $u_name =$request->input('u_name');
     $u_pwd =$request->input('u_pwd');
     $u_pwd1 =$request->input('u_pwd1');
        $data =[
            'u_name'=>$u_name,
            'u_pwd'=>$u_pwd,
            'u_pwd1'=>$u_pwd1,
        ];
       $res =UserModel::insert($data);
    }
    /*
     * 修改密码
     * */
    public function update(Request $request)
    {
        $u_name = $request->input('u_name');
        $u_pwd = $request->input('u_pwd');
        $u_pwd1 = $request->input('u_pwd1');
        $data =[
            'u_pwd'=>$u_pwd1,
        ];
        $res =UserModel::where('u_name',$u_name)->select('u_pwd')->first();
        if($res){
          if($u_pwd==$res->u_pwd){
              $res =UserModel::where('u_name',$u_name)->update($data);
              echo "修改成功";
          }else{
              echo "密码错误";
          }
        }else{
                echo "修改失败";
        }
    }
}
