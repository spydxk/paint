<?php
/*******************************
用户管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class CradController extends PubController
{

    public function showlist()
    {
        $get = I('get.');
        unset($get['s']);
        // dump($get);
        // exit()
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
        // dump($where);
        $num  = M('User')->where($where)->count();
        $page = new \Component\Page($num, 20);
        $pag  = $page->fpage();
        $data = M('User')->where($where)->limit($page->limit)->order('time desc')->select();
        foreach ($data as $key => $value) {
            $data[$key]['secondnum'] = $this->showsecondcount($value['id']);
            $data[$key]['thirdnum']  = $this->showthirdcount($value['id']);
            $data[$key]['money']     = $value['credits'] / 100.00;
            $tem                     = M('User')->where('id=%d', $value['introducer'])->select();
            if (!empty($tem)) {
                $data[$key]['secondpid']     = $tem[0]['pid'];
                $data[$key]['introducer']    = $tem[0]['name'];
                $data[$key]['introducerpid'] = $tem[0]['pid'];
                $tem1                        = M('User')->where('id=%d', $tem[0]['introducer'])->getField('pid');
                if (!empty($tem1)) {
                    $data[$key]['thirdpid'] = $tem1;
                } else {
                    $data[$key]['thirdpid'] = '无上级';
                }
            }
        }
        $data = jiai($data);
        $this->assign(array('data' => $data, 'num' => $num, 'page' => $pag));
        $this->display();
    }
    public function record()
    {
        $id                = decoded(I('get.id'));
        $data              = M('User')->where('id=%d', $id)->select();
        $data[0]['record'] = M('Record')->where('user_id=%d', $id)->order('e_time desc')->select();
        $data[0]['record'] = jiai($data[0]['record']);
        $this->assign(array('data' => $data[0]));
        $this->display();
    }
    public function money()
    {
        $status = decoded(I('get.status'));
        $get    = I('get.');
        if (!empty($get)) {
            $i = 0;
            if (!empty($get['datemin']) && empty($get['datemax'])) {
                $i++;
                $where['e_time'] = array('EGT', strtotime($get['datemin']));
            } else if (!empty($get['datemax']) && empty($get['datemin'])) {
                $i++;
                $where['e_time'] = array('ELT', strtotime($get['datemax'] . ' 23:59:59'));
            } else if (!empty($get['datemax']) && !empty($get['datemin'])) {
                $i++;
                $where['e_time'] = array('between', array(strtotime($get['datemin']), strtotime($get['datemax'] . ' 23:59:59')));
            }
            if (!empty($get['name'])) {
                $i++;
                $where['name'] = array('like', '%' . $get['name'] . '%');
            }
            if ($get['category'] !=0) {
                $i++;
                $where['category'] = $get['category'];
            }
            if ($i >= 2) {
                $where['_logic'] = 'AND';
            }
            $this->assign('get', $get);
        }
        // dump($where);
        if (!empty($status)) {
            $where['re.status'] = array('in', array(1, 2));
            $data               = M('Record')->join('as re LEFT JOIN mb_user as us on us.id=re .user_id')->where($where)->order('e_time desc')->select();
        } else {
            $where['re.status'] = array('in', array(0));
            $status             = 0;
            $data               = M('Record')->join('as re LEFT JOIN mb_user as us on us.id=re .user_id')->where($where)->order('e_time desc')->select();
        }
        foreach ($data as $key => $value) {
            $data[$key]['money'] = $value['number'] / 100.00;
        }
        $data = jiai($data);
        $this->assign(array('data' => $data, 'status' => $status));
        $this->display();
    }
    //提交申请兑换即刻扣除积分，通过就改状态，不通过返回积分即改状态 0未审核 1通过
    public function movestatus()
    {
        $get = I('get.');
        foreach ($get as $key => $value) {
            $get[$key] = decoded($value);
        }
        //通过 e_time修改审核时间 状态
        if ($get['category'] == 1) {
            $data['status'] = 1;
            $data['r_time'] = time();
            $row            = M('Record')->where('re_id=%d', $get['re_id'])->save($data);
        } else if ($get['category'] == 2) {
            $tem                 = M('User')->where('id=%d', $get['user_id'])->select();
            $temtwo              = M('Record')->where('re_id=%d', $get['re_id'])->select();
            $data_one['credits'] = $tem[0]['credits'] + $temtwo[0]['number']; //返回积分
            $data_one['all']     = $tem[0]['all'] - $temtwo[0]['number']; //减少交易额
            $res                 = M('User')->where('id=%d', $get['user_id'])->save($data_one);
            if ($res === false) {
                $this->showerror('修改状态失败');
                exit();
            }
            $data['status'] = 2;
            $data['r_time'] = time();
            $row            = M('Record')->where('re_id=%d', $get['re_id'])->save($data);
        }
        if ($row === false) {
            $this->gotourl('修改状态失败', U('Crad/money'));
            exit();
        } else {
            $this->gotourl('修改状态成功', U('Crad/money'));
            exit();
        }
    }
    public function addcrad()
    {
        $id        = decoded(I('get.id'));
        $user_info = M('User')->where('id=%d', $id)->select();
        $this->assign(array('user_info' => $user_info[0]));
        $this->display();
    }
    public function addcraddata()
    {
        $post = I('post.');
        $id   = decoded($post['user_id']);
        if (!empty($id)) {
            $tem = M('User')->where('id=%d', $id)->select();
            if (!empty($tem)) {
                $user_info = $tem[0];
                //添加积分
                //第一为一级添加
                if (!empty($user_info)) {
                    $oneuser = M('User')->where('id=%d', $user_info['introducer'])->select();
                    if (!empty($oneuser)) {
                        $data_self['credits'] = $oneuser[0]['credits'] + (int) ($post['money'] / ($oneuser[0]['one']));
                        $res                  = M('User')->where('id=%d', $oneuser[0]['id'])->save($data_self);
                        if ($res === false) {
                            $this->gotopreurl('数据更新失败', U('Crad/showlist'));
                            exit();
                        }
                    }
                    //第二为二级添加
                    if (!empty($oneuser)) {
                        $twouser = M('User')->where('id=%d', $oneuser[0]['introducer'])->select();
                        if (!empty($twouser)) {
                            $data_two['credits'] = $twouser[0]['credits'] + (int) ($post['money'] / ($twouser[0]['second']));
                            $res                 = M('User')->where('id=%d', $twouser[0]['id'])->save($data_two);
                            if ($res === false) {
                                // $data['order_status'] = 0;
                                // M('Order')->where('order_id=%d', $get['order_id'])->save($data); //恢复订单状态
                                $data_self['credits'] = $oneuser[0]['credits'];
                                $res                  = M('User')->where('id=%d', $oneuser[0]['id'])->save($data_self); //恢复第一级
                                $this->gotopreurl('数据更新失败', U('Crad/showlist'));
                                exit();
                            }
                        }
                    }
                    //为第三级添加
                    if (!empty($twouser)) {
                        $thirduser = M('User')->where('id=%d', $twouser[0]['introducer'])->select();
                        if (!empty($thirduser)) {
                            $data_third['credits'] = $thirduser[0]['credits'] + (int) ($post['money'] / ($thirduser[0]['third']));
                            $res                   = M('User')->where('id=%d', $thirduser[0]['id'])->save($data_third);
                            if ($res === false) {
                                // $data['order_status'] = 0;
                                // M('Order')->where('order_id=%d', $get['order_id'])->save($data); //恢复订单状态
                                $data_self['credits'] = $oneuser[0]['credits'];
                                M('User')->where('id=%d', $user_info['id'])->save($data_self); //恢复第一级
                                $data_two['credits'] = $twouser[0]['credits'];
                                M('User')->where('id=%d', $twouser[0]['id'])->save($data_two); //恢复第二级
                                $this->gotopreurl('数据更新失败', U('Crad/showlist'));
                                exit();
                            }
                        }
                    }
                    $this->gotopreurl('数据更新成功', U('Crad/showlist'));
                    exit();
                } else {
                    $this->gotopreurl('获取个人信息失败，请重试', U('Crad/showlist'));
                    exit();
                }
            }
        }
    }
}
