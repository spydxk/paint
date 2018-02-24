<?php

namespace Home\Controller;

use Think\Controller;

class PaintController extends PubController
{
    // public function show()
    // {
    //     $user_info                   = I('session.user_info');
    //     $user_info['introducername'] = M('User')->where('id=%d', $user_info['introducer'])->getField('name');
    //     $user_info['introducerpid']  = M('User')->where('id=%d', $user_info['introducer'])->getField('pid');
    //     $user_info['number']         = M('User')->where('introducer=%d', $user_info['id'])->count();
    //     $where['order_time']         = array(array('egt', strtotime(date('Y-01-01', time())), array('lt', strtotime(date('Y-01-01', time()) . '+1 year'))));
    //     $where['user_id']=$user_info['id'];
    //     $where['order_status']=1;
    //     $where['_logic']='AND';
    //     $user_info['all'] = M('Order')->where($where)->sum('money_all');
    //     $this->assign(array('user_info' => $user_info, 'tittle' => '分销中心'));
    //     $this->display();
    // }
    public function changestatus()
    {
        $user_info = $this->user_info;
        if ($user_info['category'] == 2) {
            $this->gotoindex('分销申请提交失败', U('Center/center'));
            exit();
        }
        $data['status'] = 1;
        $res            = M('User')->where('id=%d', $user_info['id'])->save($data);
        if ($res === false) {
            $this->gotoindex('分销申请提交失败', U('Center/center'));
            exit();
        } else {
            $this->gotoindex('分销申请已成功提交，待审核，7个工作日内会有专人为您服务', U('Center/center'));
            exit();
        }
    }
}
