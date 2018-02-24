<?php
	class Login{
		//默认头像(男)
		public static $DEFAULT_HEAD_MALE='../images/default_head_male.png';
		//默认头像(女)
		public static $DEFAULT_HEAD_FEMALE='../images/default_head_female.png';
		//默认账号名
		public static $DEFAULT_TEL='tourist';
		//默认记住登陆时间(7天)
		public static $COOKIE_LOGIN_RECORD_TIME=604800;
		public static $COOKIE_FLAG_LG_RECORD='flag_lg_record';

		/**************************************************
				清除无效用户

				频率 => 每次登陆后台执行一次(有待改进)

				无效用户=> 1.没有绑定微信
						   2.没有绑定手机
						   3.超过cookie记录时间(7天)都没有登陆过
		
		**************************************************/
		public static function clearUselessUser(){
			//查找出没有绑定微信而且没有绑定手机号的用户
			$sql="select * from user where tel='".Login::$DEFAULT_TEL."' and id not in (select uid from tp)";
			$users=M()->query($sql);
			for($i=0;$i<count($users);$i++){
				//如果超过cookie记录时间都没有登陆过就清除
				if($users[$i]['lastlogintime']+Login::$COOKIE_LOGIN_RECORD_TIME<time()){
					M('User')->delete($users[$i]['id']);
					M('Sq_userinfo')->where(array('uid'=>$users[$i]['id']))->delete();
				}
			}
			myLog('=========================clearUselessUser================================');
		}
		//自动注册
		public static function autoRegister(){
			$wcInfo=null;
			if(is_weixin()){
				$wcInfo=Login::getWCInfo();
			}
			//验证有没有绑定
			if($wcInfo){
				$cond['openid']=$wcInfo['openid'];
	            $cond['cid']=UserModel::$CID_WECHAT;//微信登陆
	            $tp=M('Tp')->where($cond)->find();
	            if($tp){
	            	return Login::logDeal($tp['uid']);
	            }
			}
			$uid=Login::anonymousReg();
			if($wcInfo){
				Login::anonymousBindOpenId($uid,$wcInfo);
			}
			return Login::logDeal($uid);
		}
		//匿名注册
		public static function anonymousReg(){
			//user
			$user['tel']=Login::$DEFAULT_TEL;
			$uid=M('User')->add($user);
			//sq_userinfo
			$userinfo['uid']=$uid;
			$userinfo['nickname']='游客';
			$userinfo['sex']='男';
			$userinfo['date']=date('Y.m.d H:i:s');
			$userinfo['image']=Login::$DEFAULT_HEAD_MALE;
			$userinfo['lastlogintime']=time();
			M('Sq_userinfo')->add($userinfo);

			return $uid;
		}
		/*匿名用户绑定微信*/
		public static function anonymousBindOpenId($uid,$info){
			$userinfo=M('Sq_userinfo')->where(array('uid'=>$uid))->find();
			if(!$userinfo){
				return;
			}
			$tp['cid']=UserModel::$CID_WECHAT;
			$tp['uid']=$uid;
			$tp['openid']=$info['openid'];
			M('Tp')->add($tp);
			//更新匿名信息
			$userinfo['nickname']=$info['nickname'];
			if($info['sex']==1){
				$sex='男';
				$userinfo['image']=Login::$DEFAULT_HEAD_MALE;
			}else{
				$sex='女';
				$userinfo['image']=Login::$DEFAULT_HEAD_FEMALE;
			}
			$userinfo['sex']=$sex;
			//$userinfo['image']=$info['headimgurl'];
			M('Sq_userinfo')->save($userinfo);
		}
		/*匿名用户绑定手机*/
		public static function anonymousBindPhone($uid,$tel){
			$tel=trim($tel);
			$user=M('User')->find($uid);
			//用户不存在
			if(!$user){
				return;
			}
			//用户不是匿名用户
			if($user['tel']!=Login::$DEFAULT_TEL){
				return;
			}
			//手机已经被绑定
			$tUser=M('User')->where(array('tel'=>$tel))->find();
			if($tUser){
				return;
			}
			$user['tel']=$tel;
			M('User')->save($user);
			//注册送6块钱红包
	        Login::registerFuli($uid);
            return $uid;
		}
		/*微信更换绑定手机*/
		public static function bindUsedPhone($uid,$tel){

			$tel=trim($tel);
			$user=M('User')->find($uid);
			//用户不存在
			if(!$user){
				return false;
			}
			//用户不是匿名用户
			// if($user['tel']!=Login::$DEFAULT_TEL){
			// 	return false;
			// }
			$tp=M("Tp")->where(array('uid'=>$uid))->find();

			if(!$tp){
				return false;
			}

			$oUser=M('User')->where(array('tel'=>$tel))->find();
			if(!$oUser){
				return false;
			}
			//删除旧用户绑定
			$tp['uid']=$oUser['id'];
			M("Tp")->save($tp);
			M("Sq_userinfo")->where(array('uid'=>$uid))->delete();
			M("User")->delete($uid);
			M("Tp")->where(array('uid'=>$oUser['id']))->delete();
			
			return $oUser['id'];
		}
		/*获取微信openid等信息*/
		public static function getWCInfo(){
			import('ORG.Util.WcWebLogin');
        	$wc=new WcWebLogin();
        	//获取微信验证的code
        	if(!isset($_GET['code'])){
	            $url="http://".$_SERVER['HTTP_HOST'].__SELF__;
	            $toUrl=$wc->get_authorize_url($url);
	            header("location:$toUrl");
	            exit();
	        }else{
	        	$ac=$wc->get_access_token($_GET['code']);
	            if(!$ac){
	                return false;
	            }
	           
                $info=$wc->get_user_info($ac['access_token'], $ac['openid']);
                if(!$info){
                    return false;
                }
                return $info;
			}
		}
		/*
		注册处理
			$uid  用户ID
			return 0.空字符串
					1.跳转的Url
		*/
		public static function logDeal($uid){
			$user=M('User')->find($uid);
			if(!$user){
				return;
			}
			//更新上次登陆时间
			$user['lastlogintime']=time();
			M('User')->save($user);
			
			//cookie记住登陆
	        cookie(Login::$COOKIE_FLAG_LG_RECORD,$uid,Login::$COOKIE_LOGIN_RECORD_TIME);
	       

	        session("user",$uid);
	        session("userbase",$user);
	        session("userinfo",M('Sq_userinfo')->where(array('uid'=>$uid))->find());
	      	
	        $url=session("loginToUrl");
	        //登陆后的跳转地址
	        if(!$url){
	            $url='__APP__/User/index.html';//个人中心地址
	        }
	        session("loginToUrl",null);
	        return $url;
		}
		//注册福利
		public static function registerFuli($userid){
	        $money=6;//6元红包
	        $usemoney=30;//满30可用
	        $title='注册送红包';
	        $exp=3;//3天后过期
	        //第一次注册显示红包的Flag
	        session("firsthb",1);
	        D('Redpapper')->addRP($userid,$money,$usemoney,$exp,$title);
	    }

	}
?>