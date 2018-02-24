<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends PubController
{
    public function index()
    {
        $sel      = M('Manager');
        $sel_au   = M('Auth');
        $auserinfo = I('session.auserinfo');
        $da_id    = $sel->where("mg_id=%d", array($auserinfo['mg_id']))->select();
        $this->assign('user', $da_id);
        $sel_rid = M('Role');
        $da_rid  = $sel_rid->where("role_id=%d", $da_id[0]['mg_role_id'])->select();
        $this->assign('role', $da_rid[0]['role_name']);
        $rol                   = $da_rid[0]['role_auth_ids'];
        $sel_le                = M('Auth');
        $da_leid['auth_id']    = array('in', $rol);
        $da_leid['auth_level'] = 0;
        $da_leid['_logic']     = 'and';
        $da_con1               = $sel_le->where($da_leid)->order('auth_id asc')->select();
        $da_leid['auth_level'] = 1;
        $da_con2               = $sel_le->where($da_leid)->order('auth_id asc')->select();
        $this->assign('da_con1', $da_con1);
        $this->assign('da_con2', $da_con2);
        $this->assign('auserinfo',$auserinfo);
        $this->display();
    }
    public function mydesktop()
    {
        $admin    = M('Manager');
        $auserinfo = I('session.auserinfo');
        if ($_SERVER['REMOTE_ADDR']) {
            $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
            $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $cip = getenv("HTTP_CLIENT_IP");
        } else {
            $cip = "unknown";
        }
        $auserinfo['ip']=$cip;
        $auserinfo['time']=time();
        $this->assign('user', $auserinfo);
        $this->display();
    }
}
