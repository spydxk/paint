<?php
namespace org\Dbapi;
/**
* 
*/
class UserApi
{
	
	function __construct(argument)
	{
		$this->user = M('user');
		$this->honor = M('honor');
		$this->myuserinfo = session('user_info');

		if(!$this->myuserinfo){
			header("location:".U('login/index'));
		}
	}

	function getAllBestzhichiByid($id){
		$where['user_id']=$id;
		return $this->honor->where($where)->count();
	}
}
	
?>