<?php
/**
 * @author spy
 * @date 2017-9-19
 * @type 注册页面
 */

namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller
{
    //注册展示页
    public function login()
    {
        $id=I('session.status');
        if (is_weixin()) {
            $wx = new \Component\Wxgetuser();
            $openid = I('session.openid');
            if (empty($openid)) {
                $openid = $wx->getuseropenid();
                if (isset($openid['errcode'])) {
                    $this->showerror('获取用户个人信息失败，请重试');
                    exit();
                } else {
                    session('openid', $openid);
                }
            }
            $user_info = M('User')->where("openid='%s'", $openid['openid'])->select();
            if (!empty($user_info)) {
                session('status', $user_info[0]['id']);
                if ($user_info[0]['category'] == 1) {
                    //贵宾会员
                    header("location:" . U('Mycenter/center'));
                } else {
                    //分销和代销
                    header("location:" . U('Center/center'));
                }
            }
        }else if(!empty($id)){
            $user_info = M('User')->where("id='%d'",$id)->select();
            if (!empty($user_info)) {
                session('status', $user_info[0]['id']);
                if ($user_info[0]['category'] == 1) {
                    //贵宾会员
                    header("location:" . U('Mycenter/center'));
                } else {
                    //分销和代销
                    header("location:" . U('Center/center'));
                }
            }
        }
        $this->assign(array('tittle' => '金聚云登录'));
        $this->display();
    }

    public function dologin()
    {
        $post = I('post.');
        $str_tel = '/^1[3|5|7|8|][0-9]{8}[0-9]$/';
        if (empty($post['iphone'])) {
            $this->gotourl('手机号码不能为空', U('Login/Login'));
            exit();
        } else if (empty($post['password'])) {
            $this->gotourl('密码不能为空', U('Login/Login'));
            exit();
        }
        if (preg_match($str_tel, $post['iphone']) == 0) {
            $this->gotourl('请输入有效的手机号码！', U('Login/login'));
            exit();
        }
        $tem = M('User')->where("iphone='%s'", $post['iphone'])->select();
        if (empty($tem)) {
            $this->gotourl('用户不存在', U('Index/index'));
            exit();
        }
        if (md5($post['password']) != $tem[0]['password']) {
            $this->gotourl('密码输入有误', U('Login/login'));
            exit();
        }
        if (!empty($post['iswei'])) {
            $openid = I('session.openid');
            $data['openid'] = $openid['openid'];
            $data['sex'] = $openid['sex'];
            $data['headimg'] = $openid['headimgurl'];
            //获取用户信息
            M('User')->where("id=%d", $tem[0]['id'])->save($data);
        }
        session('status', $tem[0]['id']);
        if ($tem[0]['category'] != 2) {
            //贵宾会员
            $this->gotourl('登录成功！', U('Mycenter/center'));
            exit();
        } else {
            $this->gotourl('登录成功！', U('Center/center'));
            exit();
        }
    }

    //公司管理登录
    public function salelogin()
    {
//        $id=I('session.salestatus');
//        if(!empty($id)){
//            header("Location: ".U('Task/showlist'));
//        }
        $this->display();
    }

    //处理公司登录信息
    public function dosalelogin()
    {
        $post = I('post.');
        if (empty($post['name'])) {
            $this->gotourl('账号不能为空', U('Login/salelogin'));
            exit();
        } else if (empty($post['password'])) {
            $this->gotourl('密码不能为空', U('Login/salelogin'));
            exit();
        }
        $tem = M('Salesman')->where("card='%s'", $post['name'])->select();
        if (empty($tem)) {
            $this->gotourl('用户不存在', U('Login/salelogin'));
            exit();
        }
        if (md5($post['password']) != $tem[0]['password']) {
            $this->gotourl('密码输入有误', U('Login/salelogin'));
            exit();
        }
        session('salestatus', $tem[0]['id']);
        $this->gotourl('登录成功！', U('Task/showlist'));
        exit();
    }

    public function outsalelogin()
    {
        session('salestatus', null);
        $this->gotourl('退出系统成功！', U('Login/salelogin'));
        exit();
    }
    public function outlogin()
    {
        session('status', null);
        $this->gotourl('退出登录成功！', U('Login/login'));
        exit();
    }

    public function gotourl($note, $url)
    {
        header("Content-type: text/html; charset=utf-8");
        echo "<script> alert('" . $note . "');self.location='" . $url . "';</script>";
        exit();
    }

    public function gotopreurl($note, $url)
    {
        header("Content-type: text/html; charset=utf-8");
        echo "<script> alert('" . $note . "');parent.history.go(-1);</script> ";
        exit();
    }

    public function showerror($note)
    {
        header("Content-type: text/html; charset=utf-8");
        echo "<script> alert('" . $note . "');</script>";
        exit();
    }
}
