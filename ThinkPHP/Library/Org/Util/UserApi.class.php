<?php
namespace Org\Util;
/**
* 
*/
class UserApi
{
	
	function __construct()
	{
		$this->user = M('user');
		$this->honor = M('honor');
		$this->myuserinfo = session('user_info');
		$this->speechscoreView = D('Home/speechscoreView');

		if(!$this->myuserinfo){
			header("location:".U('login/index'));
		}
	}



	/**
	 * [getUserAllHonorCount 获取某个用户所有的honor统计的结果]
	 * @return [type] [description]
	 */
	function getUserAllHonorCount($id){
		if(empty($id)) return ;
		$where['user_id'] = $id;
		return $this->honor->where($where)->field('type,count(*)')->group('type')->order('type asc')->select();
	}


	/**
	 * [getClubUpLevelCount 获取评分表中某个俱乐部一共晋级的次数]
	 * 条件：评分>60,俱乐部ID,
	 * @return [type] [description]
	 */
	function getClubUpLevelCount($id){
		if(empty($id)) return ;
		$where['speechscore.score'] = array("egt",60);
		$where['signup.club_id']=$id;
		return $this->speechscoreView->where($where)->count();

	}


}
	
?>