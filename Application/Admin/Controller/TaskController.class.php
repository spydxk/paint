<?php
/*******************************
 * 任务管理
 * @author spy
 * @company 三级分销系统
 * @date 2018-1-2
 ********************************/

namespace Admin\Controller;

use Think\Controller;

class TaskController extends PubController
{

    public function showlist()
    {
        $id = check_input(decoded(I('get.id')));
        if (!empty($id)) {
            $user = M('Salesman')->where('id=%d', $id)->select();
            $data['user'] = $user[0];
            $data['task'] = M('Task')->where('user_id=%d', $id)->order('task_time desc')->select();
            $num = count($data['task']);
            $data['task'] = jiai($data['task']);
        }
        $this->assign(array('data' => $data, 'num' => $num));
        $this->display();
    }

    public function showtask()
    {
        $task_id = check_input(decoded(I('get.task_id')));
        if (!empty($task_id)) {
            $data = M('Daylog')->where('task_id=%d', $task_id)->order('daylog_time desc')->select();
            $status = M('Task')->where('task_id=%d', $task_id)->getField('task_status');
        }
        $this->assign(array('data' => $data, 'status' => $status, 'task_id' => $task_id));
        $this->display();
    }

    public function movetask()
    {
        $task_id = check_input(decoded(I('get.task_id')));
        if (!empty($task_id)) {
            $user = M('Task')->where('task_id=%d', $task_id)->select();
            $data = M('Salesman')->where('id<>%d', $user[0]['user_id'])->select();
            $name = M('Salesman')->where('id=%d', $user[0]['user_id'])->select();
        }
        $this->assign(array('data' => $data, 'name' => $name[0], 'task_id' => $task_id));
        $this->display();
    }

    public function movetaskdata()
    {
        $post = I('post.');
        if ($post['user_id'] == 2) {
            $this->gotoupurl('请您选择要迁移到的业务员名称', U('Task/movetask'));
            exit();
        }
        foreach ($post as $k => $v) {
            $post[$k] = check_input(decoded($v));
        }
        $pre_id=$post['pre_id'];
        unset($post['pre_id']);
        $res=M('Task')->where('user_id=%d AND task_id =%d',array($pre_id,$post['task_id']))->save($post);
        if($res==false){
            $this->gotopreurl('数据更新失败',U('Task/showlist'));
            exit();
        }else{
            $this->gotoupurl('数据更新成功',U('Task/showlist',array('id'=>encoded($post['user_id']))));
            exit();
        }
    }
    public function showreport(){
        $id=decoded(check_input(I('get.id')));
        if(!empty($id)){
            $get = I('get.');
            if (!empty($get)) {
                $i = 0;
                if (!empty($get['datemin']) && empty($get['datemax'])) {
                    $i++;
                    $where['rep.report_time'] = array('EGT', strtotime($get['datemin']));
                } else if (!empty($get['datemax']) && empty($get['datemin'])) {
                    $i++;
                    $where['rep.report_time'] = array('ELT', strtotime($get['datemax'] . ' 23:59:59'));
                } else if (!empty($get['datemax']) && !empty($get['datemin'])) {
                    $i++;
                    $where['rep.report_time'] = array('between', array(strtotime($get['datemin']), strtotime($get['datemax'] . ' 23:59:59')));
                }
                if (!empty($get['report_intro'])) {
                    $i++;
                    $where['rep.report_intro'] = array('like', '%' . $get['report_intro'] . '%');
                }
                if ($i >= 1) {
                    $where['_logic'] = 'AND';
                }
                $this->assign('get', $get);
            }
            $where['user_id']=$id;
            $num=M('Report')->join('as rep LEFT JOIN mb_renew as renew on rep.id=renew.report_id')->where($where)->order('rep.report_time')->count();
            $page = new \Component\Page($num, 20);
            $pag  = $page->fpage();
            $data=M('Report')->join('as rep LEFT JOIN mb_renew as renew on rep.id=renew.report_id')->where($where)->order('rep.report_time')->limit($page->limit)->select();
            $userinfo=M('Salesman')->where('id=%d',$id)->select();
            $data=jiai($data);
            $this->assign(array('data'=>$data,'userinfo'=>$userinfo[0],'num'=>$num,'page'=>$pag));
        }
        $this->display();
    }
    public function addrenew(){
        $id=check_input(I('get.id'));
        $report_id=decoded($id);
        if(!empty($report_id)){
            $renew=M('Renew')->where('report_id=%d',$report_id)->select();
        }
        $this->assign(array('id'=>$id,'renew'=>$renew[0]));
        $this->display();
    }
    public function adddrenewata(){
        $post=I('post.');
        foreach ($post as $k=>$v) {
            $post[$k]=check_input($v);
        }
        if(empty($post['renew_intro'])){
            $this->gotoupurl('请输入您的回复', U('Task/addrenew'));
            exit();
        }
        $post['report_id']=decoded($post['report_id']);
        $id=decoded($post['renew_id']);
        unset($post['renew_id']);
        $post['renew_time']=time();
        if(empty($id)) {
            $res = M('Renew')->add($post);
        }else{
            $res = M('Renew')->where('renew_id=%d',$id)->save($post);
        }
        if($res==false){
            $this->gotopreurl('数据更新失败',U('Task/showlist'));
            exit();
        }else{
            $this->gotoupurl('数据更新成功',U('Task/showlist',array('id'=>encoded($post['user_id']))));
            exit();
        }
    }
}
