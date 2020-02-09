<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function goods()
    {
        // echo 'client页面';
        echo '<hr>';
        $str=$_GET['str']??'';
        // $str=urldecode($str);
        $str=base64_decode($str);
        // dd($str);
        //解密
        $method='AES-256-CBC';
        $key='asdfuysdfhnjsdfsdbnj';
        $iv='RTHGHIHBJHJ22siw';
        $enc_data=openssl_decrypt($str, $method, $key, OPENSSL_RAW_DATA, $iv);
        echo '传输数据解密后>>>>>>'.$enc_data;
    }
    //对称加密
    public function good()
    {
        // echo 'client页面';
        echo '<hr>';
        $str=$_GET['str']??'';
        // $str=urldecode($str);
        $str=base64_decode($str);
        // dd($str);
        //解密
        $method='AES-256-CBC';
        $key='asdfuysdfhnjsdfsdbnj';
        $iv='RTHGHIHBJHJ22siw';
        $enc_data=openssl_decrypt($str, $method, $key, OPENSSL_RAW_DATA, $iv);
        echo '传输数据解密后>>>>>>';
        dump(json_decode($enc_data, true));
    }
    //非对称加密
    public function rsa()
    {
        $data=$_GET['data'];
        echo 'client接收到的数据';
        echo '<hr>';
        echo '接收到的原始数据：'.$data;
        echo '<hr>';
        $base=base64_decode($data);
        echo 'base64_decode：'.$base;
        echo '<hr>';
        //读取公钥解密问价
        $pub_key=file_get_contents(storage_path('keys/pub.key'));
        //对rsa加密 进行解密
        openssl_public_decrypt($base, $den_data, $pub_key);
        echo '解密后的数据：'.$den_data;
    }

    //验证签名接口
    public function sign()
    {
        //接收传输来的数据
        $data=$_GET;
        //取出签名
        $sign=$data['sign'];
        dump($sign);

        //将sign转换成原始的数据
        $sign=base64_decode($sign);
        echo $sign;
        echo '<hr>';
        //删除sign
        unset($data['sign']);
        // dump($data);
        //将数据字典是排序
        ksort($data);
        //循环接收过来的数据  转换为字符串
        $str="";
        foreach ($data as $k=>$v) {
            $str .= $k .'='.$v.'&';
        }
        //将字符串的最后一个&符号去掉
        $str=rtrim($str, '&');
        echo $str;
        //读取出公钥
        $public=file_get_contents(storage_path('keys/pub.key'));
        // echo $public;
        //验证传过来的签名是否一直   返回值为 0 1
        $r= openssl_verify($str, $sign, $public, OPENSSL_ALGO_SHA256);
        echo '<hr>';
        if ($r) {
            echo '验签成功';
        } else {
            echo '验签失败';
        }
    }

    public function sign2()
    {
        $data=$_GET;
        $sign_key="fijkfdfnmi";
        $sign=$data['sign'];
        unset($data['sign']);
        ksort($data);
        dump($data);
        echo $sign;
        echo '<hr>';
        $str="";
        foreach($data as $k=>$v){
            $str.=$k.'='.$v.'&';
        }
        $str=rtrim($str,'&');
        echo $str;
        echo '<hr>';
        $sign_jie=md5($str.$sign_key);
        echo $sign_jie;
        echo '<hr>';
        if($sign === $sign_jie){
            echo '验签成功';
        }else{
            echo '验签失败';
        }
    }

    public function check(){
        $data=request()->input('data');

        echo $data;
        echo '<hr>';
        $sign=request()->input('sign');
        echo $sign;
        $path=storage_path('keys/pub.key');
        //获取公钥
        $pkeyid=openssl_pkey_get_public("file://".$path);

        $v=openssl_verify($data,base64_decode($sign),$pkeyid,OPENSSL_ALGO_SHA256);

        if($v){
            echo '验签成功';
        }else{
            echo '验签失败';
        }
    }

    //对称加密
    public function aes(){
        $str='huangxiaobo1111';     //待加密的数据
        $method='AES-256-CBC';  //加密方式
        $key='sbhsfubsfdfqwijpjpsjasfnkoihogub';    //加密的密钥
        $iv='jingtdjopvrfhutd';       //必须为16位

        //加密函数进行加密
        $enc=openssl_encrypt($str,$method,$key,OPENSSL_RAW_DATA,$iv);
        //不可读模式转换成可读模式
        $str_base=base64_encode($enc);
        //转换为可传输数据类型
        $str_url=urlencode($str_base);
        $url='http://1905user.com/sign/aes?str='.$str_url;
        $g=file_get_contents($url);
        echo $g;
        // $d=openssl_decrypt($enc,$method,$key,OPENSSL_RAW_DATA,$iv);
        // echo $d;
    }

    public function rsa2(){
        $str=request()->input('str');
        $key=storage_path('keys/pub.key');
        $keys=openssl_pkey_get_public('file://'.$key);
        // dump($keys);
        $str=base64_decode($str);
        openssl_public_decrypt($str,$s,$keys);
        echo '解密后数据：'.$s;
    }



}