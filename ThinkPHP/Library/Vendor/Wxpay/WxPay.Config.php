<?php
/**
* 	配置账号信息
*/
class WxPayConfig
{
	//=======【基本信息设置】=====================================
	//
	/**
	 * 
	 * 微信公众号信息配置
	 * APPID：绑定支付的APPID（必须配置）
	 * MCHID：商户号（必须配置）
	 * KEY：商户支付密钥，参考开户邮件设置（必须配置）
	 * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置）
	 * @var string
	 */
	const APPID = 'wxa3611739763adff4';
	const MCHID = '1397822102';
	const KEY = 'ce2381056b6dcefb5c2a34cfd67ce366';
	const APPSECRET = 'ce2381056b6dcefb5c2a34cfd67ce366';
	// 楼下购公共号配置信息
	// const APPID = 'wx4a8702c3aaa36bd7';
	// //受理商ID，身份标识
	// const MCHID = '1397660502';
	// //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	// const KEY = 'rmtiu8soh6wz1x2lbn035kayd7gjvf9cq4ep';
	// //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	// const APPSECRET = 'f98bf531d6b1b4be0944667b1a7068bf ';
	
	//=======【证书路径设置】=====================================
	/**
	 * 
	 * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要）
	 * @var path
	 */
	// const SSLCERT_PATH = './apiclient_cert.pem';
	// const SSLKEY_PATH = './apiclient_key.pem';
	
	//=======【curl代理设置】===================================
	/**
	 * 
	 * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
	 * 默认0.0.0.0和0，此时不开启代理（如有需要才设置）
	 * @var unknown_type
	 */
	const CURL_PROXY_HOST = "0.0.0.0";
	const CURL_PROXY_PORT = 0;
	
	//=======【上报信息配置】===================================
	/**
	 * 
	 * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
	 * @var int
	 */
	const REPORT_LEVENL = 1;
}
