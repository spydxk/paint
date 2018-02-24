<?php
	class TpPay{
		//付款方式
		const PAYWAY_HDFH=0;//货到付款
		const PAYWAY_MONEY=1;//零钱支付
		const PAYWAY_WX=2;//微信支付
		const PAYWAY_ALIPAY_M=3;//支付宝手机
		const PAYWAY_WX_QRCODE=4;//微信扫码
		const PAYWAY_ALIPAY_DIRECT=5;//支付即时到账
		//订单类型
		const PAYTYPE_PRODUCT=1;//商品
		const PAYTYPE_PAYIN=2;//充值
		const PAYTYPE_KDDJ=3;//快递代寄

		public static function getPayWay($id){
			switch ($id) {
				case TpPay::PAYWAY_HDFH:
					$str='货到付款';
					break;
				case TpPay::PAYWAY_MONEY:
					$str='零钱支付';
					break;
				case TpPay::PAYWAY_WX:
					$str='微信支付';
					break;
				case TpPay::PAYWAY_ALIPAY_M:
					$str='支付宝手机';
					break;
				case TpPay::PAYWAY_WX_QRCODE:
					$str='微信扫码';
					break;
				case TpPay::PAYWAY_ALIPAY_DIRECT:
					$str='支付即时到账';
					break;
				default:
					$str='未知';
					break;
			}
			return $str;
		}
		/***********************************
		function
			满减活动
		param
			money => 价格
			extra => 备注
		return
			array
				money => 价格
				extra => 备注
		************************************/
		public static function manjian($money,$extra){
			return array('money'=>$money,'extra'=>$extra);
			if($money>=30){
				$money-=6;
				$extra='(满30减6) '.$extra;
			}else if($money>=20){
				$money-=3;
				$extra='(满20减3) '.$extra;
			}else if($money>=10){
				$money-=1;
				$extra='(满10减1) '.$extra;
			}
			return array('money'=>$money,'extra'=>$extra);
		}

		

		/*充值优惠活动*/
		public static function getPayInMoney($money){
			$money=sprintf("%.2f",$money);
			// switch ($money) {
			// 	case $money>=200:
			// 		$money=$money+30;
			// 		break;
			// 	case $money>=100:
			// 		$money=$money+15;
			// 		break;
			// 	case $money>=50:
			// 		$money=$money+5;
			// 		break;
			// 	default:
			// 		break;
			// }
			return $money;
		}
		/**********************************************
			function
				生成临时订单
			param
				ss =>  订单数组
				openId => 用户在支付平台中唯一标识
				cid => 支付平台的类型
			return
				array
					code => error or success
					toid => 临时订单ID
					type => 购物 or 充值
		***********************************************/
		public static function createOrder($ss,$openId=1){
			//清空临时订单(待优化)
			$delCond['expire']=array('lt',time());
			M('Tmporder')->where($delCond)->delete();
			//订单过期时间
			$expire=6000;
			//加入临时订单池
			if(!$ss['did']){
				$ss['did']=session("did");
			}
			$money=sprintf("%.2f",$ss['money']);
			$extra=$ss['extra'];
			//会员打折
			if($ss['type']==TpPay::PAYTYPE_PRODUCT){
				TpPay::vipDiscount($ss['uid'],$money,$extra);
				$map['product']=addslashes(json_encode($ss['product']));
			}else{
				$map['product']='';
			}

			$map['expire']=time()+$expire;
			$map['openid']=$openId;
			$map['uid']=$ss['uid'];
			$map['did']=$ss['did'];
			$map['money']=$money;

			$map['type']=$ss['type'];
			$map['way']=$ss['way'];
			$map['extra']=$extra;
			$map['st']=$ss['st'];
			$map['rp']=$ss['rp'];
			$map['addr']=$ss['addr'];
			$map['doid']=$ss['doid'];
			$map['oid']=$ss['oid'];
			$map['orderid']='0';
			
			$toid=M('Tmporder')->add($map);
			//应付金额
			$ret['money']=$money;

			$ret['code']='success';
			$ret['toid']=$toid;
			$ret['type']=$ss['type'];
			return $ret;
		}
		/**********************************************
				会员内部打折系统
		***********************************************/
		public static function vipDiscount($uid,&$money,&$extra){
			$discount=0.8;//8折
			if(TpPay::isVip($uid)){
				$money*=$discount;
				$money=sprintf("%.2f",$money);
				$extra="(会员打".($discount*10)."折) ".$extra;
			}
		}
		public static function isVip($uid){
			//vip列表
			$vips=array(
				'13750528354',
				'15914914106',/*老板娘*/
				'15914913830',/*袭哥*/
				'13750506897',/*勇哥*/
				'13750528409',/*金灿*/
				'18813972378',/*叶敏*/
				'18813973879',/*志铭*/
				'18813972184',/*大鹏*/
				'18813976524',/*向芳*/
				'18814382648',/*黄思允*/
				'18814383235',/*英俊*/
				'18813973836',/*上鑫*/
				'13824591202'/*绮哥*/);
			$tmp=M("User")->find($uid);
			if(!$tmp){
				return false;
			}
			$tel=$tmp['tel'];
			return in_array($tel,$vips);
		}
		/**********************************************
		
			function
				处理临时订单
			param
				tmporder=>数据库存tmporder(临时订单)数组
			return
				订单号ID/flase/true
		***********************************************/
		public static function dealOrder($tmporder){
			if(!$tmporder){
				return false;
			}
			if($tmporder['type']==TpPay::PAYTYPE_PRODUCT){
				$tmporder['product']=json_decode(stripslashes($tmporder['product']),true);
				M("Tmporder")->delete($tmporder['id']);
				return TpPay::payDeal($tmporder);
			}else if($tmporder['type']==TpPay::PAYTYPE_PAYIN){
				myLog("***************dealOrder-payin*********************");
				myLog("tmporderid=>".$tmporder['id']);
				M("Tmporder")->delete($tmporder['id']);

				$money=TpPay::getPayInMoney($tmporder['money']);
				myLog("money=>".$money);
				$user=M('User')->find($tmporder['uid']);
				if(!$user){
					return false;
				}
				myLog("userid=>".$user['id']);
				myLog("usermoney1=>".$user['money']);
				$user['money']+=$money;
				M('User')->save($user);
				myLog("usermoney2=>".$user['money']);
				//充值记录
				$map['uid']=$user['id'];
				$map['money']=$money;
				$map['orderid']=$tmporder['orderid'];
				$map['payway']=$tmporder['way'];
				$map['date']=date('Y.m.d H:i:s');
				M('Rechargerecord')->add($map);

				myLog("***************dealOrder-payin*********************");
				return true;
			}else if($tmporder['type']==TpPay::PAYTYPE_KDDJ){
				$oid=$tmporder['oid'];
				$order=M("kd_send_order")->find($oid);
				if($order){
					$order['status']=3;
					$order['orderid']=$tmporder['orderid'];
					M("kd_send_order")->save($order);
				}
				M("Tmporder")->delete($tmporder['id']);
			}
		}
		/**********************************************
			function
				支付订单
			param
				aid => 地址ID
				send_time => 发货时间
				way => 付款方式
				rp => 红包ID，0则代表未使用
				uid => 用户ID
				gwc => 付款购物车列表
				did => 地区ID
				extra =>备注
			return
				订单号ID
				
		***********************************************/
		public static function payDeal($tmporder){
			$useless=RedpapperModel::$STATE_USELESS;//红包不能使用
			$DFH=GwcModel::$TYPE_WAIT_SEND;//商品待发货状态
			//从购物车中获取货物
			$sum=$tmporder['money'];//商品价格
			
			//更改购物车状态为待发货
			$gwc=$tmporder['product'];
			$oid=$tmporder['oid'];
			//如果 是总部购买
			if($gwc){
				/***********添加打印积分**********/
				// if($gwc[$i]['pid']==GwcModel::PID_PRINTER_ONLINE){
				// 	D('Points')->addPoints($tmporder['uid'],PointsModel::$CID_PRINT_BY_OTHER);
				// }

				for($i=0;$i<count($gwc);$i++){
					//如果是抢购
					if($gwc[$i]['ptype']==GwcModel::PTYPE_LXQG){
						$lxqg=M('Lxqg')->find($gwc[$i]['pid']);
						if(!$lxqg){
							continue;
						}
						$lxqg['kc']-=$gwc[$i]['num'];
						M('Lxqg')->save($lxqg);
						//添加记录
						D('Lxqgrecord')->addRecord($gwc[$i]['pid'],$gwc[$i]['uid'],$gwc[$i]['num']);

						$gwc[$i]['pid']=$lxqg['pid'];
					}
					//产品销量+,库存-
					if($gwc[$i]['pid']>0){
						$product=M("Product")->find($gwc[$i]['pid']);
						if($product){
							$product['xl']+=$gwc[$i]['num'];
							$product['kc']-=$gwc[$i]['num'];
							if($product['kc']<0){
								myLog('kc lt 0 num=>'.$product['kc'].',oid=>'.$oid);
								$product['kc']=0;
							}
							M('Product')->save($product);
						}
					}
				}
			}else{
				//产品销量+,库存-
				$lz_gwc=M("Lz_gwc")->where(array('oid'=>$oid))->select();
				if($lz_gwc){
					for($i=0;$i<count($lz_gwc);$i++){
						$pro=M("Product")->find($lz_gwc[$i]['pid']);
						if($pro){
							$pro['xl']+=$lz_gwc[$i]['num'];
							M("Product")->save($pro);

							$lz_pro=M("Lz_product")->where(array("pid"=>$pro['id'],'doid'=>$lz_gwc[$i]['doid']))->find();
							if($lz_pro){
								$lz_pro['kc']-=$lz_gwc[$i]['num'];
								if($lz_pro['kc']<0){
									
									myLog('kc lt 0 num=>'.$lz_pro['kc'].',oid=>'.$oid);
									$lz_pro['kc']=0;
								}
								M('Lz_product')->save($lz_pro);
							}
						}
					}
				}
			}
			//更新订单信息
			$map=M('Dfh')->find($oid);

			$map['date']=date('Y.m.d H:i:s');
			$map['type']=$DFH;
			$map['orderid']=$tmporder['orderid'];

			$map['sum']=$tmporder['money'];
			$map['addr']=$tmporder['addr'];
            $map['way']=$tmporder['way'];
            $activity_flag = session("PAYIN_ACTIVITY_FLAG");
            if($activity_flag) {
                session("PAYIN_ACTIVITY_FLAG", null);
                $map['way']="充值免单";
            }
			$map['doid']=$tmporder['doid'];
			$map['extra'].=htmlspecialchars(trim($tmporder['extra']));
			M('Dfh')->save($map);
	
			//如果使用红包成功,则将红包设为已使用
			if($tmporder['rp']){
				$rpobj=M('Redpapper')->find($tmporder['rp']);
				$rpobj['state']=$useless;
				$rpobj['oid']=$oid;
				M('Redpapper')->save($rpobj);
			}
			return $oid;
		}
	}
?>