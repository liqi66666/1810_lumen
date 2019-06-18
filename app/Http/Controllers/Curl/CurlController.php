<?php

namespace App\Http\Controllers\Curl;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurlController extends Controller
{
//    public function curl1()
//{
//    //1 初始化
//    $curl=curl_init("https://www.baidu.com/");
//
//    //2设置参数
//    curl_setopt($curl,CURLOPT_RETURNTRANSFER,false);
//
//    //3执行会话
//    curl_exec($curl);
//
//    //4关闭会话
//    curl_close($curl);
//
//}
//    /*
//     * 获取微信access_token
//     * */
//    public function curl2()
//    {
//        $appid = 'wxdc4f5bb5d43d342d';
//        $appsecret = 'b6d055f437a70864937b62a8f9228b52';
//        //1初始化
//        $access_token='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
//        $curl = curl_init($access_token);
//
//        //2设置参数
//        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
//
//        //3执行会话
//        $data = curl_exec($curl);
//
//        //4结束会话
//        curl_close($curl);
//
//        //处理数据
//        echo $data;
//
//        $re =json_decode($data,true);
//        print_r($re);
//    }
////    /*
////     * 使用CURL实现POST请求
////     * */
//    public function curl3()
//    {
//        $post_data=[
//            'name'=>'zhangsan',
//            'pass'=> '1234',
//        ];
//
//        //1 初始化
//        $url = "http://www.liqi.com/curl/curl1";
//        $curl = curl_init($url);
//
//        //2 设置参数
//        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
//        curl_setopt($curl,CURLOPT_POST,true);
//        curl_setopt($curl,CURLOPT_POSTFIELDS,$post_data);
//
//        //3执行会话
//        curl_exec($curl);
//
//        //获取报错信息
//        $error = curl_errno($curl);
//
//        $error1 = curl_error($curl);
////        var_dump($error);
////        var_dump($error1);
//        //4关闭会话
//        curl_close($curl);
//    }

        public function encry1()
        {
          $enc_data = file_get_contents("php://input");
            echo $enc_data;
            $dec_data =base64_decode($enc_data);
            echo $dec_data;
        }
        public function encry2()
        {
            $method = 'AES-128-CBC';
            $key = 'password';
            $iv ='mmpmmpmmpmmpmmpm';
            $enc_data = base64_decode(file_get_contents("php://input"));
            echo 'ENC_DATA: '.$enc_data;
            $dec_data =openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
            echo 'DEC_DATA: '.$dec_data;

        }
    public function rsa1()
    {
        $enc_data = base64_decode(file_get_contents("php://input"));
        $pub_key = openssl_pkey_get_public("file://".storage_path("app/pub.key"));
        //var_dump($pub_key);echo 111;die;

        openssl_public_decrypt($enc_data,$dec_data,$pub_key);
        echo '解密数据: '.$dec_data;
    }
    public function rsa2()
    {
        $method = 'AES-128-CBC';
        $key = 'password';
        $iv = 'mmpmmpmmpmmpmmpm';
        $data1 = file_get_contents("php://input");
        $data =unserialize($data1);
       // dd($data);
        $str =$data['str'];
        $str1 =$data['str1'];
        $pub_key = openssl_pkey_get_public("file://".storage_path("app/pub.key"));
        $ok = openssl_verify($str,$str1,$pub_key);
//        echo 2222;die;
       //echo $ok;die;
        if($ok == 1){
            //解密数据
            $dec_data1 =openssl_decrypt($str,$method,$key,OPENSSL_RAW_DATA,$iv);
            echo "解密后数据：".$dec_data1;echo "<hr>";
            //返回数据
            $str2 = "liqi1234";
            $data = openssl_encrypt($str2,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
//            echo $data;die;
            echo "返回加密后数据：".$data;echo "<hr>";
            $pub_key = openssl_get_privatekey("file://".storage_path("app/priva.pem"));
//            var_dump($pub_key);die;
            openssl_sign($data,$signature,$pub_key);
            $data_info = [
                'str'=>$data,
                'str1'=>$signature,
            ];
            $data1=serialize($data_info);
//            echo $data1;die;
            $client =new Client();
            $url="http://www.lumen.com/curl/rsa3";
            $response = $client->request('POST',$url,[
                'body'=>$data1
            ]);
            echo $response->getBody();
        }else if($ok == 0){
            echo "验签失败";
        }else{
            echo "2123133";
        }

//        var_dump($dec_data);die;
//
//        echo $dce_data;

//        var_dump($or);die;
//        echo $or;die;
//        if($or == 1){
//            echo "成功了";
//        }else if($or == 0){
//            echo "失败了";
//        }else{
//            echo "解密数据:".$dec_data;
//        }
//        var_dump($or);
    }
    public function rsa3()
    {
        $method = 'AES-128-CBC';
        $key = 'password';
        $iv = 'mmpmmpmmpmmpmmpm';
        $data = file_get_contents("php://input");
        $data = unserialize($data);

        $str =$data['str'];
        $str1 =$data['str1'];
//        var_dump($str);
//        var_dump($str1);die;
        $pub_key = openssl_pkey_get_public("file://".storage_path("app/pub.key"));
        $ok = openssl_verify($str,$str1,$pub_key);
        if($ok ==1){
            $dec_data1 =openssl_decrypt($str,$method,$key,OPENSSL_RAW_DATA,$iv);
            echo "返回解密后数据：".$dec_data1;echo "<hr>";
        }else if($ok ==0)
        {
            echo "验签失败";
        }
    }
}