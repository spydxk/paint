<?php
namespace Home\Controller;

use Think\Controller;

class PubController extends Controller
{
    public $user_info;
    public function __construct()
    {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
        if (is_weixin()) {
            $openid = I('session.openid');
            //openid为空
            if (empty($openid)) {
                $wx = new \Component\Wxgetuser();
                if (empty($_GET['code'])) {
                    $wx->get_code();
                }
                $openid = $wx->getuseropenid();
                if (isset($openid['errcode'])) {
                    $this->gotourl('获取用户个人信息失败，请重试', U('Index/index'));
                    exit();
                } else {
                    session('openid', $openid);
                }
            }
            //获取用户信息
            $user_info = M('User')->where("openid='%s'", $openid['openid'])->select();
            if (empty($user_info)) {
                if (empty($user_info)) {
                    $this->gotourl('用户不存在，请注册', U('Index/index'));
                    exit();
                }
            }
            $this->user_info = $user_info[0];
        } else {
            $login = I('session.status');
            // dump($login);
            // exit();
            if (!empty($login)) {
                $user_info = M('User')->where("id=%d", $login)->select();
                if (empty($user_info)) {
                    $this->gotourl('用户不存在，请注册', U('Index/index'));
                    exit();
                }
                if (empty($user_info[0]['headimg'])) {
                    $user_info[0]['headimg'] = ROOT . 'Public/admin/img/head.png';
                }
                $this->user_info = $user_info[0];
            } else {
                $this->gotourl('尚未登录，请登录', U('Login/login'));
                exit();
            }
        }
    }
    public function gotourl($note, $url)
    {
        echo "<script> alert('" . $note . "');self.location='" . $url . "';</script>";
        exit();
    }
    public function gotopreurl($note, $url)
    {
        echo "<script> alert('" . $note . "');parent.history.go(-1);var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);</script> ";
        exit();
    }
    public function gotoupurl($note, $url)
    {
        echo "<script> alert('" . $note . "');var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);self.location='" . $url . "';</script>";
        exit();
    }
    public function gotoindex($note)
    {
        $user_id = I('session.status');
        $tem     = M('User')->where("id=%d", $user_id)->select();
        if ($tem[0]['category'] ==1) {
            //贵宾会员
            $this->gotourl($note, U('Mycenter/center'));
            exit();
        } else {
            $this->gotourl($note, U('Center/center'));
            exit();
        }
    }
}
