<?php

namespace Component;

class Wxgetuser
{
    protected $_appid;
    protected $_secret;
    public function __construct()
    {
        $this->appid     = "wx7c6ca3c218bf5fbc";
        $this->appsecret = "4e4c56683a144eb6f45e361b9124cb2c";
    }
    public function getuseropenid()
    {
        $appid  = $this->appid;
        $secret = $this->appsecret;
        // dump($appid);
        // exit();
        //第一步获取code
        $code = $_GET["code"];
        if (empty($code)) {
            $code = $this->get_code();
        }
        // dump($code);
        // exit();
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $ch            = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_token_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsoninfo = json_decode($output, true);
        // dump($jsoninfo);
        // exit();
        $getuserinfourl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $jsoninfo['access_token'] . '&openid=' . $jsoninfo['openid'] . '&lang=zh_CN';
        $ch             = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getuserinfourl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $userinfo = json_decode($output, true);
        return $userinfo;
    }
    public function get_code()
    {

        $geturl = urlencode($this->get_url());

        // dump($geturl);
        // dump($this->appid);
        // exit();
        $str = sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', $this->appid, $geturl);
        // dump($str);
        // exit();
        header('location:' . $str);
    }
    public function get_url()
    {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self     = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info    = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url   = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') .$relate_url;
    }
}
