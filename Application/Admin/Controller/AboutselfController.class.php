<?php
/*******************************
用户管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class AboutselfController extends PubController
{

    public function showpage()
    {
       $data=M('Self')->order('time desc')->limit(1)->select();
       $this->assign(array('data'=>$data[0]));
       $this->display();
    }
    public function adddata(){
        $post=I('post.');
        $post['id']=decoded($post['id']);
        $post['time']=time();
        if(empty($post['id'])){
            unset($post['id']);
            $res=M('Self')->add($post);
        }else{
            $res=M('Self')->where('id=%d',$post['id'])->save($post);
        }
        if($res==false){
            $this->gotourl('数据更新失败',U('Aboutself/showpage'));
            exit();
        }else{
           $this->gotourl('数据更新成功',U('Aboutself/showpage'));
            exit();
        }
    }
  
}
