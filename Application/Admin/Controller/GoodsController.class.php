<?php
/*******************************
用户管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class GoodsController extends PubController
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
            if ($get['category'] != 0) {
                $i++;
                $where['category'] = $get['category'];
            } else {
                $where['category'] = array("IN", array(2, 3));
            }
            if ($i >= 2) {
                $where['_logic'] = 'AND';
            }
            $this->assign('get', $get);
        } else {
            $where['category'] = array("IN", array(2, 3));
        }
        // dump($where);
        $num  = M('User')->where($where)->count();
        $page = new \Component\Page($num, 20);
        $pag  = $page->fpage();
        $data = M('User')->where($where)->limit($page->limit)->order('time desc')->select();
        foreach ($data as $key => $value) {
            $order = M('Order')->where('user_id=%d', $value['id'])->order('order_time desc')->select();
            if (!empty($order)) {
                $data[$key]['order_status']   = 1;
                $data[$key]['order_mosttime'] = $order[0]['order_time'];
                $data[$key]['ord_num']        = M('Order')->where('user_id=%d', $value['id'])->count();
            } else {
                $data[$key]['order_status'] = 0;
            }
        }
        $data = jiai($data);
        $this->assign(array('data' => $data, 'num' => $num, 'page' => $pag));
        $this->display();
    }
    public function showorder()
    {
        $id   = decoded(I('get.id'));
        $user = M('User')->where('id=%d', $id)->select();
        $data = M('Order')->where('user_id=%d', $id)->select();
        $data = jiai($data);
        $this->assign(array('user' => $user[0], 'data' => $data));
        $this->display();
    }
    public function showe()
    {
        $id    = decoded(I('get.id'));
        $order = M('Order')->where('order_id=%d', $id)->select();
        $goods = M('Goods')->where('order_id=%d', $order[0]['order_id'])->select();
        // dump($goods);
        $this->assign(array('order' => $order[0], 'goods' => $goods));
        $this->display();
    }
    public function addorder()
    {
        $id   = decoded(I('get.id'));
        $data = M('User')->where('id=%d', $id)->select();
        $this->assign(array('data' => $data[0]));
        $this->display();
    }
    public function addorderdata()
    {
        $post = I('post.');
        if ($post['addtime'] == '') {
            $this->showerror('请选择交易日期');
            exit();
        }
        if ($post['gressname'] == '') {
            $this->showerror('请填写客户名称');
            exit();
        }
        if ($post['order_iphone'] == '') {
            $this->showerror('请填写联系电话');
            exit();
        }
        if ($post['order_address'] == '') {
            $this->showerror('请填写地址');
            exit();
        }
        if ($post['order_user'] == '') {
            $this->showerror('请填写开单人');
            exit();
        }
        if ($post['delivery_user'] == '') {
            $this->showerror('请填写送货人');
            exit();
        }
        if ($post['consignee'] == '') {
            $this->showerror('请填写收货人');
            exit();
        }
        if ($post['money_all'] == '') {
            $this->showerror('请填写货单总额');
            exit();
        }
        if (!(preg_match('/^\d+$/i', $post['money_all']))) {
            $this->showerror('货单总额必须为数字');
            exit();
        }
        $arr                 = array_chunk($post, 7, ture);
        $order               = array_merge(reset($arr), end($arr));
        $order['user_id']    = decoded($post['user_id']);
        $order['order_time'] = time();
        $res                 = M('Order')->add($order);
        if ($res === false) {
            $this->showerror('添加货单失败，请重试');
            exit();
        }
        unset($arr[0]);
        array_pop($arr);
        foreach ($arr as $key => $value) {
            $arr[$key] = array_values($value);
        }
        foreach ($arr as $k => $value) {
            $data['goods_name']  = $value[0];
            $data['goods_type']  = $value[1];
            $data['goods_num']   = $value[2];
            $data['goods_unit']  = $value[3];
            $data['goods_price'] = $value[4];
            $data['goods_all']   = $value[5];
            $data['notes']       = $value[6];
            $data['order_id']    = $res;
            $rst[]               = M('Goods')->add($data);
        }

        foreach ($rst as $key => $value) {
            if ($value === false) {
                foreach ($rst as $k => $v) {
                    M('Goods')->where('goods_id=%d', $v)->delete();
                }
                $this->gotopreurl('添加货单失败，请重试', U('Goods/showlist'));
                exit();
            }
        }
        $this->gotopreurl('添加货单成功', U('Goods/showlist'));
        exit();
    }
    public function addmon()
    {
        $user_id = I('get.user_id');
        $this->assign(array('user_id' => $user_id));
        $this->display();
    }
    //添加流水
    public function addmondata()
    {
        $post            = I('post.');
        $post['user_id'] = decoded($post['user_id']);
        $post['time']    = time();
        $row             = M('Money')->add($post);
        if ($row === false) {
            $this->gotopreurl('添加流水失败', U('Goods/showlist'));
            exit();
        } else {
            $this->gotopreurl('添加流水成功', U('Goods/showlist'));
            exit();
        }
    }
}
