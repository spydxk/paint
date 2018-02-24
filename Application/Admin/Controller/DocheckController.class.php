<?php
/*******************************
分销申请
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class DocheckController extends PubController
{

    public function showlist()
    {
        $get = I('get.');
        unset($get['s']);
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
            if ($i >= 2) {
                $where['_logic'] = 'AND';
            }
            $this->assign('get', $get);
        }
        // echo I('get.category');
        $category =empty(I('get.category'))?'':decoded(I('get.category'));
        if (empty($category) || $category == 1) {
                        // echo "111";
            // dump($where);
            $category=1;
            $status            = 1;
            $where['status'] = array('eq',1);
            $data              = M('User')->where($where)->order('time desc')->select();
        } else {
            // echo "222";
            // dump($where);
            $status=2;
            $where['status'] = array("IN", array(3,4));
            $data = M('User')->where($where)->order('time desc')->select();
        }
        $data = jiai($data);
        $this->assign(array('data' => $data, 'status' => $status,'num'=>$num,'category'=>$category));
        $this->display();
    }
    public function checkit()
    {
        $get = I('get.');
        foreach ($get as $key => $value) {
            $get[$key] = decoded($value);
        }
        $get['time']=time();
        //通过 e_time修改审核时间 状态
        $row = M('User')->where('id=%d', $get['id'])->save($get);
        if ($row === false) {
            $this->gotourl('修改状态失败', U('Docheck/showlist'));
            exit();
        } else {
            $this->gotourl('修改状态成功', U('Docheck/showlist'));
            exit();
        }
    }
}
