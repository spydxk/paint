<?php

namespace Admin\Model;
use Think\Model;

class RoleModel extends Model{
	function save_dis($auth,$sub,$role,$role_id,$rolid){
		$str=implode(',', $auth);
		$ac_str='';
		foreach ($auth as $key => $value) {
			$sel_ac=M('Auth');
			$con_ac=$sel_ac->where('auth_id=%d',$value)->select();
			if(!empty($con_ac[0]['auth_c'])&&!empty($con_ac[0]['auth_a'])){
				$ac_str.=$con_ac[0]['auth_c'].'-'.$con_ac[0]['auth_a'].',';
			}
		}

		$ac_str=rtrim($ac_str,',');
		$data['role_auth_ids']=$str;
		$data['role_auth_ac']=$ac_str;
		$sel_ro=M('Role');
		if(!empty($sub)){
		$data['role_leve']=$rolid;
			$data['role_name']=$role;
			$row=$sel_ro->add($data);
		}else{
			$data['role_name']=$role;
		$row=$sel_ro->where('role_id=%d',$role_id)->save($data);
		}
		return $row;
	}
}
