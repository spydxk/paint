<?php
/*******************************
用户登录管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class UsermanageController extends Controller
{
    public function login()
    {
        $this->display();
    }
    public function doLoginout()
    {
        session('auserinfo', null);
        $this->gotourl('退出成功！', U('Usermanage/login'));
        exit();
    }
    public function dologin()
    {
        $sel  = M('Manager');
        $post = I('post.');
        if ($post['username'] == '') {
            $this->gotopreurl('用户名不能为空！', U('Usermanage/login'));
            exit();
        } else if ($post['password'] == '') {
            $this->gotopreurl('密码不能为空！', U('Usermanage/login'));
            exit();
        } else if ($post['captcha'] == '') {
            $this->gotopreurl('验证码不能为空！', U('Usermanage/login'));
            exit();
        }
        $verify    = new \Think\Verify();
        $img_check = $verify->check($post['captcha']);
        if (!$img_check['status']) {
            $this->gotourl('验证码不正确，请核对后登录', U('Usermanage/login'));
            exit();
        } else {
            $row = $sel->join("as mg LEFT JOIN mb_role as ro on mg.mg_role_id = ro.role_id")->where("mg.mg_name='%s'", $post['username'])->select();
            session('auserinfo', $row[0]);
            if ($row[0] == '') {
                $this->gotopreurl('用户名不存在，请您重新输入！', U('Usermanage/login'));
                exit();
            } else {
                if ($row[0]['mg_pwd'] != md5($post['password'])) {
                    $this->gotopreurl('密码输入有误，请您重新输入', U('Usermanage/login'));
                    exit();
                } else {
                    $this->gotourl('欢迎登陆金聚云ZY2.02营销管理系统！', U('Index/index'));
                    exit();
                }
            }
        }
    }
    public function gotourl($note, $url)
    {
        header('Content-Type:text/html;charset=utf8');
        echo "<script  charset='gb2312' language='JavaScript' type='text/javascript'> alert('" . $note . "');self.location='" . $url . "';</script>";
        exit();
    }
    public function gotopreurl($note, $url)
    {
        header('Content-Type:text/html;charset=utf8');
        echo "<script  charset='gb2312' language='JavaScript' type='text/javascript'> alert('" . $note . "');parent.history.go(-1);var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);</script> ";
        exit();
    }
    public function img()
    {
        $config = array(
            'fontSize' => 15, // 验证码字体大小(px)
            'imageH'   => 30, // 验证码图片高度
            'imageW'   => 120, // 验证码图片宽度
            'length'   => 4, // 验证码位数
            'fontttf'  => '5.ttf', // 验证码字体，不设置随机获取
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
    }
}
