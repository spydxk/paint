<?php

namespace Home\Controller;

use Think\Controller;

class PubTaskController extends Controller
{
    public $user_info;

    public function __construct()
    {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
        $login = I('session.salestatus');
        if (!empty($login)) {
            $user_info = M('Salesman')->where("id=%d", $login)->select();
            if (empty($user_info)) {
                $this->gotourl('用户不存在，禁止访问', U('Index/index'));
                exit();
            }
            $this->user_info = $user_info[0];
        } else {
            $this->gotourl('尚未登录，请登录', U('Login/salelogin'));
            exit();
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
        $tem = M('User')->where("id=%d", $user_id)->select();
        if ($tem[0]['category'] == 1) {
            //贵宾会员
            $this->gotourl($note, U('Mycenter/center'));
            exit();
        } else {
            $this->gotourl($note, U('Center/center'));
            exit();
        }
    }
}
