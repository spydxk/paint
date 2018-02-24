<?php
/**
 * 获取已经指派的，
 * $data 二维数组
 */



/**
 * 获取已经指派的，
 * $data 二维数组
 */
function getOneByarray($data,$string){
	$result='';
	if(!is_array($data)) return ;

	foreach ($data as $key => $v) {
		
		if($v[$string]==1){
			$result=$v;
			break;
		}  
		
	}
	return $result;
}
function morecourse(){
	$ses=I('session.auserinfo');
	$str=array();
	foreach ($ses['class'] as $key => $value) {
		foreach ($value['course'] as $k => $v) {
			if(!in_array($v['id'], $str)){
				$cou['course'][]=$v;
				$str[]=$v['id'];
			}
		}
	}
	return $cou;
}
/**
 * [通过userid获取某条记录的某个字段]
 * @param  [string] $id   [description]
 * @param  [filed] $name [description]
 * @return [string]       [description]
 */
function getUserfieldById($id,$name){
	$m=M('user');
	$where['id']=$id;
	$res = $m->where($where)->field($name)->find();
	return $res[$name];
}


function setJsonData($data,$filed){

	//if(!is_array($data) || !is_array($field)) return; 
	//设置value初始化
	/*foreach ($field as $key => $value) {
		
		$a[$key] = 0;
	}*/
	$a[0] = 0;
	$a[1] = 0;
	$a[2] = 0;


	//目前不是动态条件变量
	foreach ($data as $key => $value) {
		if($value < 6){
			$a[0]=$a[0]+1;
		}elseif($value >=6 && $value<=11){
			$a[1]=$a[1]+1;
		}elseif($value == 12){
			$a[2]=$a[2]+1;
		}	
	}


	foreach ($filed as $key => $value) {
		$new['value'] = $a[$key];
		$new['name'] = $value;
		$array[]=$new;

	}
	
	return json_encode($array);
}

