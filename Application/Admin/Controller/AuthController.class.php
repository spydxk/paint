<?php
/*******************************
权限管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class AuthController extends PubController
{
    public function showlist()
    {
        $con_da = array();
        $con_da = $this->cha();
        $i      = 1;
        foreach ($con_da as $key => $value) {
            $con_da[$key]['id'] = $i;
            $i++;
        }
        $this->assign('info', $con_da);
        $this->display();
    }
    public function delete()
    {
        $id    = I("get.id");
        $de_au = M('Auth');
        $row   = $de_au->where('auth_id=%d', $id)->delete();
        if ($row !== 0) {
            $this->success('删除权限成功！', U('Auth/showlist'));
        } else {
            $this->error('删除权限失败！');
        }
    }
    public function modif()
    {
        $id     = I('get.id');
        $de_au  = M('Auth');
        $con_da = $this->cha();
        $this->assign('info', $con_da);
        $de_con = $de_au->where('auth_id=%d', $id)->select();
        $this->assign('de_con', $de_con);
        $this->display();
    }
    public function add()
    {
        if (!empty($_POST)) {
            $po_da  = I('post.');
            $sel_ad = M('Auth');
            if (!empty($po_da['modif'])) {
                $row_de = $sel_ad->where('auth_id=%d', $po_da['auth_id'])->delete();
            }
            if ($po_da['auth_pid'] !== '0') {
                $row                 = $sel_ad->add($po_da);
                $po_da['auth_path']  = $po_da['auth_pid'] . '-' . $row;
                $po_da['auth_level'] = 1;
                $rest                 = $sel_ad->where('auth_id=%d', $row)->save($po_da);
            } else {
                $row                 = $sel_ad->add($po_da);
                $po_da['auth_path']  = $row;
                $po_da['auth_level'] = 0;
                $rest                 = $sel_ad->where('auth_id=%d', $row)->save($po_da);
            }
            if (!empty($po_da['modif'])) {
                if ($rest !== false) {
                    $this->success('修改权限成功', U('Auth/showlist'));
                    exit();
                } else {
                    $this->error('修改权限失败');
                    exit();
                }
            } else {
                if ($rest !== false) {
                    $tem                   = M('Role')->where('role_id=%d', 1)->select();
                    $data['role_auth_ids'] = $tem[0]['role_auth_ids'] .','. $row;
                    $data['role_auth_ac']  = $tem[0]['role_auth_ac'] . ',' . $po_da['auth_c'] . '-' . $po_da['auth_a'];
                    $res                   = M('Role')->where('role_id=%d', 1)->save($data);
                    if ($res!==false) {
                        $this->success('添加权限成功', U('Auth/showlist'));
                        exit();
                    }
                } else {
                    $this->error('添加权限失败');
                    exit();
                }
            }
        } else {
            $info = array();
            $info = $this->cha();
            $this->assign('for_con', $info);
            $this->display();
        }
    }
    public function cha()
    {
        $sel_id = M('Auth');
        $con_da = $sel_id->order('auth_path asc')->select();
        foreach ($con_da as $key => $value) {
            if ($value['auth_level'] == 1) {
                $con_da[$key]['auth_name'] = str_replace($value['auth_name'], '--', $value[auth_name]) . $value['auth_name'];
            }
        }
        return $con_da;
    }
}
