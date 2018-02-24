<?php
/*******************************
管理员管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class ManagerController extends PubController
{
    public function add()
    {
        $id    = I('session.auserinfo');
        $da_ro = selrole($id['role_id']);
        $this->assign('da_ro', $da_ro);
        if (!empty($_POST)) {
            $po_da      = array();
            $po_da      = I('post.');
            $str_name   = '/^([0-9])(.+?)?/';
            $str_mg_pwd = '/^[0-9a-zA-Z][0-9a-zA-Z]{2,14}[0-9a-zA-Z]$/';
            if ($po_da['mg_name'] == '') {
                $this->error('用户名不能为空！', U('Manager/add'));
                exit();
            } else if ($_POST['mg_pwd'] == '') {
                $this->error('密码不能为空！', U('Manager/add'));
                exit();
            } else if (preg_match($str_name, $po_da['mg_name'])) {
                $this->error('用户名不能以数字开头！', U('Manager/add'));
                exit();
            } else if (!preg_match($str_mg_pwd, $po_da['mg_pwd'])) {
                $this->error('密码只能是6-16个长度！', U('Manager/add'));
                exit();
            }
            $goods = D('Manager');
            $data  = D('Manager')->where("mg_name='{$po_da['mg_name']}'")->select();
            // var_dump($data);
            // exit();
            if (!empty($data)) {
                $this->error('用户名已注册！', U('Manager/add'));
                exit();
            } else if ($po_da['mg_role_id'] == 0) {
                $this->error('请选择管理员的角色', U('Manager/add'));
                exit();
            } else {
                $pass             = md5($po_da['mg_pwd']);
                $da['mg_name']    = $po_da['mg_name'];
                $da['mg_pwd']     = $pass;
                $da['mg_pid']     = $id['mg_id'];
                $da['mg_role_id'] = $po_da['mg_role_id'];
                $da['mg_time']    = date("Y-m-d H:i:s", time());
                $goods->create();
                $rst = $goods->add($da);
                if ($rst > 0) {
                    $this->success('注册成功!', U('Manager/showlist'));
                    exit();
                } else {
                    $this->error('注册失败！请重新填写信息', U('Manager/showlist'));
                    exit();
                }
            }
        }
        $this->display();

    }
    public function getmg($id)
    {
        $tem = M('Manager')->field('mg.mg_id,mg.mg_name,mg.mg_role_id,ro.role_name,ro.role_leve')->join('as mg LEFT JOIN mb_role as ro on mg.mg_role_id = ro.role_id')->where("mg.mg_pid = %d", array($id))->select();
        if (!empty($tem)) {
            foreach ($tem as $key => $value) {
                $tem1 = $this->getmg($value['mg_id']);
                if ($tem1 == false) {
                    $man[] = $value;
                } else {
                    $man[] = $value;
                    foreach ($tem1 as $k2 => $v2) {
                        $man[] = $v2;
                    }
                }
            }
            return $man;
        } else {
            return false;
        }
    }
    public function showlist()
    {
        $ses   = I('session.auserinfo');
        $man   = $this->getmg($ses['mg_id']);
        $tem   = M('Manager')->field('mg.mg_id,mg.mg_name,mg.mg_role_id,ro.role_name,ro.role_leve')->join('as mg LEFT JOIN mb_role as ro on mg.mg_role_id = ro.role_id')->where("mg.mg_id = %d", array($ses['mg_id']))->select();
        $man[] = $tem[0];
        $man   = jiai($man);
        $this->assign('data', $man);
        $this->display();
    }

    public function modify()
    {
        $user = I('session.auserinfo');
        $id   = $user['mg_id'];
        $this->assign('mg_id', $id);
        $sel_mg = M('Manager');
        $da_mg  = $sel_mg->where('mg_id=%d', $id)->select();
        $this->assign('info', $da_mg);
        $this->display();
    }
    public function modadd()
    {
        $po_da           = I("post.");
        $po_da['mg_pwd'] = md5($po_da['mg_pwd']);
        $sesdata         = I('session.auserinfo');
        $pwd             = M('Manager')->where('mg_id=%d', $sesdata['mg_id'])->getField('mg_pwd');
        if (md5($po_da['old_pwd']) != $pwd) {
            echo "<script>alert('原密码输入有误，修改失败');history.go(-1);</script>";
            exit();
        } else if ($po_da['mg_pwd'] !== md5($po_da['new_pwd'])) {
            echo "<script>alert('新密码两次输入不一致，修改失败');history.go(-1);</script>";
            exit();
        } else if ($po_da['mg_pwd'] == $pwd) {
            echo "<script>alert('密码尚未改动，修改失败');history.go(-1);</script>";
            exit();
        }
        unset($po_da['old_pwd']);
        unset($po_da['new_pwd']);
        $row = M('Manager')->where('mg_id=%d', $po_da['mg_id'])->save($po_da);
        if ($row !== false) {
            $this->success('修改管理员信息成功！', U('Manager/modify'));
            exit();
        } else {
            $this->error('修改管理员信息失败！', U('Manager/modify'));
            exit();
        }
    }
    public function update()
    {
        $id  = I('get.id');
        $ses = I('session.auserinfo');
        $this->assign('mg_id', $id);
        $sel_mg = M('Manager');
        $da_mg  = $sel_mg->where('mg_id=%d', $id)->select();
        $this->assign('info', $da_mg);
        $da_ro = selrole($ses['role_leve']);
        $this->assign('da_ro', $da_ro);
        if (!empty($_POST)) {
            $po_da = array();
            $po_da = I("post.");
            $data  = M('Manager')->where('mg_id=%d', $po_da['mg_id'])->select();
            if ($data[0]['mg_pwd'] == $po_da['mg_pwd']) {
                unset($po_da['mg_pwd']);
            }
            if ($po_da['mg_pwd'] != '') {
                $po_da['mg_pwd'] = md5($po_da['mg_pwd']);
            }
            $po_da['mg_time'] = time();
            $row[]            = $sel_mg->where('mg_id=%d', $po_da['mg_id'])->save($po_da);
            if ($row !== 0) {
                $this->success('修改管理员信息成功！', U('Manager/showlist'));
                exit();
            } else {
                $this->error('修改管理员信息失败！', U('Manager/showlist'));
                exit();
            }
        }
        $this->display();
    }
    public function delete()
    {
        $id  = I('get.id');
        $sel = M('Manager');
        $row = $sel->where('mg_id=%d', $id)->delete();
        if ($row != false) {
            $this->success('删除管理员信息成功！', U('Manager/showlist'));
        } else {
            $this->error('删除管理员信息失败！', U('Manager/showlist'));
        }
    }
}
