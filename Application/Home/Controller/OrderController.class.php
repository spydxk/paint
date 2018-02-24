<?php

namespace Home\Controller;

use Think\Controller;

class OrderController extends PubController
{
    public function showlist()
    {
        $user_info = $this->user_info;
        $data      = M('Order')->where('user_id=%d', $user_info['id'])->select();
        $data      = jiai($data);
        $this->assign(array('data' => $data, 'tittle' => '订单列表'));
        $this->display();
    }
        public function moneylist()
    {
        $user_info = $this->user_info;
        $data      = M('Money')->where('user_id=%d', $user_info['id'])->select();
        $data      = jiai($data);
        $this->assign(array('data' => $data, 'tittle' => '流水记录'));
        $this->display();
    }
    public function showorder()
    {
        $id    = decoded(I('get.id'));
        $order = M('Order')->where('order_id=%d', $id)->select();
        $goods = M('Goods')->where('order_id=%d', $id)->select();
        $this->assign(array('order' => $order[0], 'goods' => $goods, 'tittle' => '订单明细'));
        $this->display();
    }
    public function doorder()
    {
        $user_info = $this->user_info;
        $get       = I('get.');
        foreach ($get as $key => $value) {
            $get[$key] = decoded($value);
        }
        if ($get['category'] == 1) {
            //确定订单
            $data['order_status'] = 1;
            $res                  = M('Order')->where('order_id=%d', $get['order_id'])->save($data); //修改订单状态
            $money_all            = M('Order')->where('order_id=%d', $get['order_id'])->getfield('money_all');
            $data['money']        = 0 - $money_all;
            $data['user_id']      = $user_info['id'];
            $data['time']         = time();
            $res                  = M('Money')->add($data); //添加流水记录
            $userdata['moneyall'] = $user_info['money_all'] + $data['money'];
            $rst                  = M('User')->where('id=%d', $user_info['id'])->save($userdata); //修改消费总额
        } else {
            //取消订单
            $data['order_status'] = 2;
            $res                  = M('Order')->where('order_id=%d', $get['order_id'])->save($data);
        }
        if ($res === false) {
            $this->gotourl('数据更新失败', U('Order/showorder', array('id' => encoded($get['order_id']))));
            exit();
        } else {
            $this->gotourl('数据更新成功', U('Order/showorder', array('id' => encoded($get['order_id']))));
            exit();
        }
    }
    public function dolist()
    {
        $get = I('get.');
        foreach ($get as $key => $value) {
            $get[$key] = decoded($value);
        }
       
    }
}
