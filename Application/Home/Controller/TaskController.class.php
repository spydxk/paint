<?php

namespace Home\Controller;

use Think\Controller;

class TaskController extends PubTaskController
{
    //任务列表
    public function showlist()
    {
        $user_info = $this->user_info;
        $data = M('Task')->where('user_id=%d', $user_info['id'])->order('task_time desc')->select();
        $data = jiai($data);
        $this->assign(array('data' => $data, 'tittle' => '任务列表'));
        $this->display();
    }

    //添加任务
    public function addtask()
    {
        $this->assign(array('tittle' => '添加任务'));
        $this->display();
    }

    //添加任务处理数据
    public function addtaskdata()
    {
        $post = I('post.');
        $user_info = $this->user_info;
        foreach ($post as $k => $v) {
            $post[$k] = check_input($v);
        }
        $str_tel = '/^1[3|4|5|7|8|][0-9]{8}[0-9]$/';
        if (empty($post['task_user']) || empty($post['task_address']) || empty($post['task_phone']) || empty($post['task_intro'])) {
            $this->gotopreurl('存在信息不能为空');
            exit();
        }
        if (preg_match($str_tel, $post['task_phone']) == 0) {
            $this->gotopreurl('请输入有效的手机号码！');
            exit();
        }
        $post['user_id'] = $user_info['id'];
        $post['task_time'] = time();
        $post['task_status'] = 1;
        $row = M('Task')->add($post);
        if ($row == false) {
            $this->gotourl('添加任务失败，请您刷新重试', U('Task/showlist'));
            exit();
        } else {
            $this->gotourl('添加任务成功', U('Task/showlist'));
            exit();
        }
    }

    //展示日志
    public function showtask()
    {
        $id = check_input(decoded(I('get.task_id')));
        if (!empty($id)) {
            $data = M('Task')->where('task_id=%d', $id)->select();
            if (!empty($data)) {
                $data[0]['data'] = M('Daylog')->where('task_id=%d', $data[0]['task_id'])->order('daylog_time desc')->select();
            }
        }
        $this->assign(array('data' => $data[0], 'tittle' => '日志'));
        $this->display();
    }

    //添加日志
    public function adddaylog()
    {
        $task_id = I('get.task_id');
        $this->assign(array('tittle' => '写日志', 'task_id' => $task_id));
        $this->display();
    }

    //添加日志数据
    public function adddaylogdata()
    {
        $post = I('post.');
        foreach ($post as $k => $v) {
            $post[$k] = check_input($v);
        }
        if (empty($post['daylog_intro'])) {
            $this->gotopreurl('请输入日志内容');
            exit();
        }
        $day['daylog_intro'] = $post['daylog_intro'];
        $day['task_id'] = decoded($post['task_id']);
        $day['daylog_time'] = time();
        $day['daylog_status'] = decoded($post['task_status']);
        $task['task_status'] = decoded($post['task_status']);
        $task['task_fretime'] = time();
        $tasksql = M('Task');
        $tasksql->startTrans(); //开启事务
        $row = $tasksql->where('task_id=%d', $day['task_id'])->save($task);
        if ($row == false) {
            $this->gotopreurl('添加日志失败，请您刷新重试');
            exit();
        }
        $row = M('Daylog')->add($day);
        if ($row == false) {
            $tasksql->rollback(); //如果order添加失败事物回滚
            $this->gotopreurl('添加日志失败，请您刷新重试');
            exit();
        }
        $tasksql->commit();
        // 如果allAdded为真则两条数据都成功；那么 commit事物提交
        $this->gotourl('添加日志成功', U('Task/showtask', array('task_id' => encoded($day['task_id']))));
        exit();
    }

    public function gotomyindex()
    {
        //openid为空
//        if (is_weixin()) {
//            $openid = I('session.openid');
//            if (empty($openid)) {
//                $wx = new \Component\Wxgetuser();
//                $openid = $wx->getuseropenid();
//                if (isset($openid['errcode'])) {
//                    $this->gotopreurl('获取用户个人信息失败，请重试');
//                    exit();
//                } else {
//                    session('openid', $openid);
//                }
//            }
//            $tem = M('User')->where("openid='%s'", $openid['openid'])->select();
//        }
//        //获取用户信息
//        if ($tem[0]['category'] == 1) {
            //贵宾会员
            header("Location: ".U('Login/login'));
//            exit();
//        } else {
//            header("Location: ".U('Center/center'));
//            exit();
//        }
    }
}
