<?php

namespace Home\Controller;

use Think\Controller;

class CenterController extends PubController
{
    //代买 代销

    public function center()
    {
        $user_info = $this->user_info;
        $one       = M('User')->where('introducer=%d', $user_info['id'])->select();
        $two       = 0;
        if (!empty($one)) {
            foreach ($one as $key => $value) {
                $two = (M('User')->where('introducer=%d', $value['id'])->count()) + $two;
            }
        }
        $user_info['num'] = $two + count($one);
        if ($user_info['category'] == 1) {
            $this->gotourl('您的用户类别禁止访问', U('Mycenter/center'));
            exit();
        }
        // $user_info          = $this->user_info;
        $user_info['money'] = M('Money')->where('user_id=%d', $user_info['id'])->sum('money');
        $user_info['all']   = M('Order')->where('user_id=%d AND order_status =%d', array($user_info['id'],1))->sum('money_all');
        /**************信息******************/
        $where['starttime'] = array('LT', time());
        $where['uptime']    = array('GT', time());
        $where['_logic']    = 'AND';
        $new                = M('New')->where($where)->select();
        if (!empty($new)) {
            foreach ($new as $key => $value) {
                $data = explode('<><>', $value['user_id']);
                if (!in_array($user_info['id'], $data)) {
                    $arr['user_id'] = $value['user_id'] . '<><>' . $user_info['id'];
                    M('New')->where('id=%d', $value['id'])->save($arr);
                    $new[$key]['id']      = encoded($value['id']);
                    $new[$key]['content'] = htmlspecialchars_decode($value['content']);
                    $newdata[]            = $new[$key];
                }
            }
            $newdata = json_encode($newdata);
        }
        /**************信息******************/
        /*******************未确定订单数目*****************/
        $status_num = I('session.status_num');
        if (!$status_num) {
            $num = M('Order')->where('order_status=%d AND user_id =%d', array(0, $user_info['id']))->count();
            session('status_num', true);
        }
        /****************************************/
        $this->assign(array('user_info' => $user_info, 'tittle' => '分销中心', 'new' => $newdata, 'num' => $num));
        $this->display();
    }
    public function signdown()
    {
        $user_info = $this->user_info;
        $tem       = M('User')->where('id=%d', $user_info['id'])->select();
        $nowday    = date('Y-m-d', time());
        if (!empty($tem[0]['signtime'])) {
            $lastday = date('Y-m-d', $tem[0]['signtime']);
        } else {
            $lastday = '1999-09-02';
        }
        $datetime1 = new \DateTime($lastday);
        $datetime2 = new \DateTime($nowday);
        $interval  = $datetime1->diff($datetime2);
        $allday    = $interval->format('%a');
        // dump($tem);
        // exit();
        if ($allday == 0) {
            $this->gotoindex('您今天已经签到，不能重复签到');
            exit();
        } else if ($allday == 1) {
            //连续签到 总积分=现有积分+连续签到次数*10
            $data['credits']    = $tem[0]['credits'] + $tem[0]['signcount'] * 10;
            $data['signtime']   = time();
            $data['signstatus'] = 2;
            $data['signcount']  = $tem[0]['signcount'] + 1;
            $row                = M('User')->where('id=%d', $user_info['id'])->save($data);
        } else if ($allday > 1) {
            if ($tem[0]['signstatus'] == 1) {
                $data['credits'] = $tem[0]['credits'] + 110;
            } else {
                $data['credits'] = $tem[0]['credits'] + 10;
            }
            $data['signtime']   = time();
            $data['signcount']  = 1; //如果不是连续签到，将次数置一
            $data['signstatus'] = 2;
            $row                = M('User')->where('id=%d', $user_info['id'])->save($data);
        }
        if ($row !== false) {
            if ($tem[0]['signstatus'] == 1) {
                $this->gotoindex('首次签到成功，恭喜您积分+110');
            } else {
                $this->gotoindex('签到成功，恭喜您积分+' . $tem[0]['signcount'] * 10);
            }
            exit();

        } else {
            $this->gotoindex('签到失败,请重试');
            exit();
        }
    }

    public function tomoney()
    {
        $post      = I('post.');
        $user_info = $this->user_info;
        if ($user_info['category'] == 1) {
            //贵宾会员
            $url = U('Mycenter/center');
        } else {
            //分销和代销
            $url = U('Center/center');
        }

        if ($user_info['credits'] < 30000) {
            $this->gotourl('抱歉哦！要30000积分+才能申请提现哦，你可参考首页如何赚积分，您最棒！', $url);
            exit();
        }

        if ($user_info['credits'] < $post['number']) {
            $this->gotourl('提现积分不能大于现有积分', $url);
            exit();
        }
        if (empty($post['number'])) {
            $this->gotourl('提现积分不能为空', $url);
            exit();
        } else if (!is_numeric($post['number'])) {
            $this->gotourl('提现积分必须为数字', $url);
            exit();
        }
        $post['all']     = $user_info['credits'] - $post['number'];
        $user['credits'] = $post['all'];
        $rst             = M('User')->where('id=%d', $user_info['id'])->save($user);
        if ($rst === false) {
            $this->gotourl('申请审核失败，请重试', $url);
            exit();
        }
        $post['user_id'] = $user_info['id'];
        $post['status']  = 0;
        $post['e_time']  = time();
        // dump($post);
        // exit();
        $res = M('Record')->add($post);
        if ($res === false) {
            $this->gotourl('申请审核失败，请重试', $url);
            exit();
        } else {
            $this->gotourl('恭喜您！提现申请已成功提交，财务专员将会与您核对收款信息，请留意！', $url);
            exit();
        }
    }
}
