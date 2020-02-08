<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Common;

class UserController extends Controller
{
    public function reg()
    {
        $url = "http://1905ppt.com/user/reg";
        $data = [
            'user_name' => 'zhangsan3',
            'user_email' => 'zhang2@qq.com',
            'user_tel'=>'123123323',
            'user_pwd'=>'ljx123',
            'user_pwd1'=>'ljx123'
        ];

        $response = Common::curlPost($url,$data);
        print_r($response);
    }

    public function login()
    {
        $login_info = [
            'user_name'=>'zhangsan3',
            'user_pwd'=>'ljx123'
        ];
        $url = "http://1905ppt.com/user/login";
        $response = Common::curlPost($url,$login_info);
        print_r($response);
    }

    public function getData()
    {
        $token = 'a773c9c56af7d56b9f18f51eeb510525';
        $uid = '8';
        $url = "http://1905ppt.com/user/token";
        $header = [
            'token:'.$token,
            'uid:'.$uid
        ];
        $response = Common::curlGet($url,$header);
        print_r($response);
    }


        public function sign()
    {
        $data = $_GET['data'];//传过来的数据
        $sign = $_GET['sign'];//传过来的签名
        $key = "1905";

        $check = md5($data.$key);

        if($check != $sign){
            echo '验签失败';die;
        }else{
            echo '验签成功';
        }
    }

        public function check2()
    {

        $key = "1905";      // 计算签名的key 与发送端 保持一致

        echo '<pre>';print_r($_POST);
        //接收数据 和 签名
        $json_data = $_POST['data'];
        $sign = $_POST['sign'];

        //计算签名
        $sign2 = md5($json_data.$key);
        echo "接收端计算的签名：".$sign2;echo "<br>";

        // 比较接收到的签名
        if($sign2==$sign){
            echo "验签成功";
        }else{
            echo "验签失败";
        }


    }

    public function key_sign()
    {
        $sign = $_GET['sign'];
//        $sign = 'asdsadsadasdsad';
        //字典排序1
        $data = $_GET['data'];
        print_r($_GET);


        //使用公钥验签
        $pub_key = storage_path('keys/pub.key');
        $pkeyid = openssl_pkey_get_public("file://" . $pub_key);
        $status = openssl_verify($data, base64_decode($sign), $pkeyid);
        var_dump($status);
        echo '<br>';

        if ($status) {
            echo '验签成功';
        } else {
            echo '验签失败';
        }
    }
}
