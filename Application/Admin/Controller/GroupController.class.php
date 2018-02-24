<?php
/*
*@author    spy
*@date      2017/12/27 14:43
*@describe  业务员管理
*/

namespace Admin\Controller;

use Think\Controller;

class GroupController extends PubController
{
    //业务员列表
    public function showlist()
    {
        $get = I('get.');
        if (!empty($get)) {
            $i = 0;
            if (!empty($get['datemin']) && empty($get['datemax'])) {
                $i++;
                $where['time'] = array('EGT', strtotime($get['datemin']));
            } else if (!empty($get['datemax']) && empty($get['datemin'])) {
                $i++;
                $where['time'] = array('ELT', strtotime($get['datemax'] . ' 23:59:59'));
            } else if (!empty($get['datemax']) && !empty($get['datemin'])) {
                $i++;
                $where['time'] = array('between', array(strtotime($get['datemin']), strtotime($get['datemax'] . ' 23:59:59')));
            }
            if (!empty($get['name'])) {
                $i++;
                $where['name'] = array('like', '%' . $get['name'] . '%');
            }
            if (!empty($get['iphone'])) {
                $i++;
                $where['iphone'] = array('like', '%' . $get['iphone'] . '%');
            }
            if ($i >= 2) {
                $where['_logic'] = 'AND';
            }
            $this->assign('get', $get);
        }
        $num = M('Salesman')->where($where)->count();
        $page = new \Component\Page($num, 20);
        $pag = $page->fpage();
        $data = M('Salesman')->where($where)->limit($page->limit)->order('time desc')->select();
        foreach ($data as $k => $v) {
            $data[$k]['taskall'] = M('Task')->where('user_id=%d', $v['id'])->count();
            $data[$k]['tasking'] = M('Task')->where('user_id=%d AND task_status=%d', array($v['id'], 1))->count();
        }
        $data = jiai($data);
        $this->assign(array('data' => $data, 'num' => $num, 'page' => $pag));
        $this->display();
    }

    //展示添加业务员页面
    public function add()
    {
        $id = decoded(I('get.id'));
        if (!empty($id)) {
            $info = M('Salesman')->where('id=%d', $id)->select();
            $this->assign(array('info' => $info));
        }
        $this->display();
    }

    //添加或修改业务员数据
    public function adddata()
    {
        $post = I('post.');
        foreach ($post as $ke => $va) {
            $post[$ke] = check_input($va);
            if (empty($va)) {
                $this->gotourl('存在数据不能为空', U('Group/add'));
            }
        }
        $str_tel = '/^1[3|4|5|7|8|][0-9]{8}[0-9]$/';
        if (preg_match($str_tel, $post['iphone']) == 0) {
            $this->gotourl('请输入有效的手机号码！', U('Group/add'));
            exit();
        }
        $post['time'] = time();
        $id = decoded($post['id']);
        unset($post['id']);
        if (empty($id)) {
            $tem = M('Salesman')->where("iphone='%s'", $post['iphone'])->select();
            if (!empty($tem)) {
                $this->gotourl('账号已存在！', U('Group/add'));
                exit();
            }
            $post['password'] = md5($post['password']);
            $row = M('Salesman')->add($post);
        } else {
            $tem = M('Salesman')->where('id=%d', $id)->select();
            if ($tem[0]['password'] == $post['password']) {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $row = M('Salesman')->where('id=%d', $id)->save($post);
        }
        if ($row == false) {
            $this->gotoupurl('数据更新失败，请重试', U('Group/showlist'));
            exit();
        } else {
            $this->gotoupurl('数据更新成功', U('Group/showlist'));
            exit();
        }
    }

    //删除业务员
    public function delman()
    {
        $id = decoded(I('get.id'));
        if (!empty($id)) {
            $row = M('Salesman')->where('id=%d', $id)->delete();
            if ($row == false) {
                $this->gotoupurl('数据更新失败，请重试', U('Group/showlist'));
                exit();
            } else {
                $this->gotoupurl('数据更新成功', U('Group/showlist'));
                exit();
            }
        }
    }
}