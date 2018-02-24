<?php
/*******************************
    用户管理
    @author spy
    @company 梅州市交通技工学校
    @date 2016-12-1
********************************/
namespace Admin\Controller;
use Think\Controller;
class RoleController extends PubController {
	public function showlist(){	
		$ses=I('session.auserinfo');
		$sel_role=M('Role');
		$da_role=selrole($ses['role_id']);
		$data=jiai($da_role);
		$this->assign('da_role',$data);	
		$this->display();
	}
	public function addrole(){
		$ses=I('session.auserinfo');
		$da_t=M('Role')->where("role_id=%d",$ses['role_id'])->select();
		$arr1=array();
		$arr1=explode(',', $da_t[0]['role_auth_ids']);
		foreach ($arr1 as $key => $value) {
			$tem=M('Auth')->where('auth_id=%d',$value)->select();
			if(!empty($tem)&&($tem[0]['auth_pid']==0)){
				$da_r[]=$tem[0];
			}else if(!empty($tem)&&($tem[0]['auth_pid']!==0)){
				$da_r1[]=$tem[0];
			}
		}
		$this->assign('pauth_info',$da_r);
		$this->assign('sauth_info',$da_r1);
		if(!empty($_POST)){
			$po_da=I('post.');
			if(empty($po_da['role_name'])){
				echo "<script>alert('角色名称不能为空');history.go(-1);</script>";
    			exit();
			}
			$tem=M('Role')->where("role_name='%s'",$po_da['role_name'])->select();
			if(!empty($tem)){
				echo "<script>alert('角色名称已存在，请重新命名');history.go(-1);</script>";
    			exit();
			}
			$role = new \Admin\Model\RoleModel();
			$row=$role->save_dis($po_da['authname'],$po_da['sub'],$po_da['role_name'],$id,$ses['role_id']);
			if($row!=0){
			$this->success('添加数据成功',U('Role/showlist'));
			exit();
			}else{
				$this->error('添加数据失败');
				exit();
			}
		}
		$this->display();
	}
	public function distribute(){
		$id=I("get.role_id");
		if(!empty($_POST)){
			$po_da=I('post.');
			$role = new \Admin\Model\RoleModel();
			$row=$role->save_dis($po_da['authname'],'',$po_da['role_name'],$id);
			if($row!==false){
			$this->success('分配权限成功！',U('Role/showlist'));
			exit();
			}else{
				$this->error('分配权限失败或权限尚未改动！');
				exit();
			}
		}
		$sel_t=M('Role');
		$ses=I('session.auserinfo');
		$da_t=$sel_t->where("role_id=%d",$id)->select();
		$role_name=$da_t[0]['role_name'];
		$this->assign('role_name',$role_name);
		$auth_ids_arr=$da_t[0]['role_auth_ids'];
		$this->assign('auth_ids_arr',$auth_ids_arr);
		$arr=array();
		$arr=explode(',', $da_t[0]['role_auth_ids']);
		$this->assign('arr',$arr);

		$da_t=$sel_t->where("role_id=%d",$ses['role_id'])->select();
		$arr1=array();
		$arr1=explode(',', $da_t[0]['role_auth_ids']);
		foreach ($arr1 as $key => $value) {
			$tem=M('Auth')->where('auth_id=%d',$value)->select();
			if(!empty($tem)&&($tem[0]['auth_pid']==0)){
				$da_r[]=$tem[0];
			}else if(!empty($tem)&&($tem[0]['auth_pid']!==0)){
				$da_r1[]=$tem[0];
			}
		}
		$this->assign('pauth_info',$da_r);
		$this->assign('sauth_info',$da_r1);
		$this->display();
	}
	public function delete(){
		$id=I('get.role_id');
		$sel=M('Role');
		$row=$sel->where('role_id=%d',$id)->delete();
		if($row!==0){
			$this->success('删除角色成功！',U('Role/showlist'));
			}else{
				$this->error('删除角色失败！',U('Role/showlist'));
			}
	}

}
?>