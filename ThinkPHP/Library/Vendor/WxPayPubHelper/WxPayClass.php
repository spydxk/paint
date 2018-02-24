<?php

/**
 * 必须引入WxPayPubHelper.php作为基础类
 * 新建一个微信支付类，可获取openid信息,支付签名，异步加载
 * 2016-10-24 22:59:33
 * xgh
 */
include_once("WxPayPubHelper.php");


class WxPayClass
{
	function __construct() {
			$this->appid 		= WxPayConf_pub::APPID;
			$this->appsecret 	= WxPayConf_pub::APPSECRET;
			//设置SESSION保存OPENID的键名
			$this->wxopenid 	= 'wxopenid';
			//开启SESSION
			session_start();
		}

	


	/**
	 * [getOpenidInfo openid获取与处理]
	 * @return [type] [description]
	 */
	function getOpenidInfo(){
		 //若不存在SESSION('wx_openid');
        
		if(!$this->wxopenid) exit('wxopenid set error');
 
		$session=$_SESSION[$this->wxopenid];

        if(!$session){
             $getcode=$_GET['code'];

             if(!$getcode){
                $this->get_code();exit();
             }

              $openid=$this->wx_getopenid_bycode($getcode);

            
              $_SESSION[$this->wxopenid]=$openid;
              
        }else{
              $openid = $_SESSION[$this->wxopenid];
        }
        return $openid;
	}

	/**
	 * [pay 支付页面获取微信许可]
	 * @param  [type] $title      [支付显示标题内容]
	 * @param  [type] $total      [金额]
	 * @param  [type] $notify_url [异步加载地址]
	 * @return [type]             [许可认证对象]
	 */
	function pay($title = "无标题",$total = "1000" ,$notify_url,$product_id = null){

        header("Content-type:text/html;charset=utf-8");

        if(empty($notify_url)) exit('notify_url is empty');

        $session = $_SESSION['user_info'];

        if(!$session) exit("该账户还没登录");
        $getopenid=$this->getOpenidInfo();
    
          //使用jsapi接口
        $jsApi = new JsApi_pub();
      
        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
      
        $openid=$getopenid['openid'];
        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();
      
        $total=$total?$total:1;
        $total =number_format($total,2)*100;
        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $order_id_create=$this->create_trace_no();
        $unifiedOrder->setParameter("openid",$openid);//商品描述
        $unifiedOrder->setParameter("body",$title);//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();

      //  $out_trade_no = C('WxPayConf_pub.APPID').$timeStamp;
        $unifiedOrder->setParameter("out_trade_no",$order_id_create);//商户订单号
        $unifiedOrder->setParameter("total_fee",$total);//总金额
        $unifiedOrder->setParameter("notify_url",$notify_url);//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        //$unifiedorder->setParameter("attach","test");
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        $unifiedOrder->setParameter("attach",$session['id']);//附加数据
       // $unifiedOrder->setParameter("product_id",2);//商品ID
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
       // $unifiedOrder->setParameter("goods_tag","2");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识

       
        $prepay_id = $unifiedOrder->getPrepayId();
        //var_dump($prepay_id);
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);
        //将unified和jsapi获取的值作为参数
        $jsApiParameters['jsapi'] = $jsApi->getParameters();
        $jsApiParameters['unifiedOrder']=$unifiedOrder;

        return $jsApiParameters;
}

	/**
	 * [notify 异步返回结果]
	 * @return [obj] [notify]
	 */
	function notify(){
	        
	        //使用通用通知接口
	        $notify = new Notify_pub();
	        
	        //存储微信的回调
	        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
	        $notify->saveData($xml);
	        
	        //验证签名，并回应微信。
	        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
	        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
	        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
	        if($notify->checkSign() == FALSE){
	            $notify->setReturnParameter("return_code","FAIL");//返回状态码
	            $notify->setReturnParameter("return_msg","签名失败");//返回信息
	        }else{
	             
	            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
	        }
	        $returnXml = $notify->returnXml();
	        echo $returnXml;
	        return $notify;        
	}


	/**
	 * [get_url 获取将当前的URL]
	 * @return [String] [URL]
	 */
	function get_url() {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
    }

    /**
     * [get_code 重定向获取code]
     * @void [type] [description]
     */
    function get_code(){

   	 	$geturl=urlencode($this->get_url());

     	$str=sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect',$this->appid,$geturl);

    	header('location:'.$str);
	}

	function wx_getopenid_bycode($code){
    
    //获取ACCESST_token和openid
     $url = sprintf("https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code",$this->appid,$this->appsecret,$code);
     $res = file_get_contents($url);
     $res = json_decode($res, true);

     //通过获取的信息进行获取Openid信息


     if(!$res['errcode'] && $res){
        $ac_op_url=sprintf("https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN",$res['access_token'],$res['openid']);

        $ac_openid_res = file_get_contents($ac_op_url);
        $final_res = json_decode($ac_openid_res, true);
       
        if(!$final_res['errcode']){
           return $final_res;
         }else{
            exit("拉取用户信息失败");
         }
       
     }

     exit("openid get error");
 }

 function create_trace_no($length = 4) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }

    $str.=time();

    return $str;
  }



}


?>
