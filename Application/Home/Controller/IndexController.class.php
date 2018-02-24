<?php
/**
 *@author spy
 *@date 2017-9-19
 *@type 注册页面
 */
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    //注册展示页
    public function index()
    {

        if (is_weixin()) {
            $openid = I('session.openid');
            //openid为空
            if (empty($openid)) {
                $wx = new \Component\Wxgetuser();
                // if (empty($_GET['code'])) {
                //     $wx->get_code();
                // }
                $openid = $wx->getuseropenid();
                if (isset($openid['errcode'])) {
                    $this->showerror('获取用户个人信息失败，请重试');
                    exit();
                } else {
                    session('openid', $openid);
                }
            }
            //获取用户信息
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
        } else {
            $login = I('session.status');
            if (!empty($login)) {
                $user_info = M('User')->where("id=%d", $login)->select();
                if (!empty($user_info)) {
                    if ($user_info[0]['category'] == 1) {
                        //贵宾会员
                        header("location:" . U('Mycenter/center'));
                    } else {
                        //分销和代销
                        header("location:" . U('Center/center'));
                    }
                }
            }
        }
        $this->assign(array('tittle' => '金聚云注册'));
        $this->display();
    }
    //绑定推荐人
    public function bang()
    {
        $dataadd['introducer'] = decoded(I('get.user_id'));
        //当前用户是否已注册
        if (!empty($user_info)) {
            $userdata = M('User')->where('id=%d', $dataadd['introducer'])->select();
            //能查到推荐人并存在id
            if (!empty($dataadd['introducer']) && !empty($userdata)) {
                $res = M('User')->where('id=%d AND id <> %d', array($user_info[0]['id'],$user_info[0]['id']))->save($dataadd);
                if ($res === false) {
                    $this->showerror('绑定推荐人失败');
                } else {
                    if ($user_info[0]['category'] == 1) {
                        //贵宾会员
                        $this->gotourl('绑定推荐人成功', U('MyCenter/center'));
                        exit();
                    } else {
                        $this->gotourl('绑定推荐人成功', U('Center/center'));
                        exit();
                    }
                }
            } else if (!empty($dataadd['introducer']) && empty($userdata)) {
                $this->showerror('绑定推荐人不存在');
            }
            if ($user_info[0]['category'] == 1) {
                //贵宾会员
                header("location:" . U('Mycenter/center'));
            } else {
                //分销和代销
                header("location:" . U('Center/center'));
            }
        }
        //推荐人不存在
        if (!empty($dataadd['introducer'])) {
            $userdata = M('User')->where('id=%d', $dataadd['introducer'])->select();
            if (empty($userdata)) {
                $this->showerror('绑定推荐人不存在');
            }
            $this->assign(array('introducerpid' => $userdata[0]['pid']));
        }
        $this->assign(array('tittle' => '金聚云注册'));
        $this->display('index');
    }
    public function delses()
    {
        session('user_info', null);
    }
    public function adduser()
    {
        header("Content-type: text/html; charset=utf-8");
        $post             = I('post.');
        $openid           = I('session.openid');
        $post['category'] = decoded($post['category']);
        $str_tel          = '/^1[3|4|5|7|8|][0-9]{8}[0-9]$/';
        $pattern          = "/^[\w-\.]{6,8}$/";
        if (empty($post['name'])) {
            $this->gotopreurl('姓名不能为空', U('Index/index'));
            exit();
        } else if (empty($post['iphone'])) {
            $this->gotopreurl('手机号码不能为空', U('Index/index'));
            exit();
        }
        $tem = M('User')->where("iphone='%s'", $post['iphone'])->select();
        if (!empty($tem)) {
            $this->gotopreurl('用户已存在，请登录', U('Login/login'));
            exit();
        }
        if ($post['category'] == 0) {
            $this->gotopreurl('推荐类别不能为空', U('Index/index'));
            exit();
        }
        if (preg_match($str_tel, $post['iphone']) == 0) {
            $this->gotopreurl('请输入有效的手机号码！', U('Index/index'));
            exit();
        }
        if (preg_match($pattern, $post['password']) == 0) {
            $this->gotopreurl('请输入6-8位数字或者字母的密码', U('Index/index'));
            exit();
        }
        if ($post['password'] != $post['repassword']) {
            $this->gotopreurl('两次输入密码不一致，请重新填写!', U('Index/index'));
            exit();
        }
        $post['password']=md5($post['password']);
        unset($post['repassword']);
        if (!empty($post['introducer'])) {
            $post['introducer'] = M('User')->where("pid='%s'", $post['introducer'])->getField('id');
            if (empty($post['introducer'])) {
                $this->gotopreurl('推荐人不存在', U('Index/index'));
                exit();
            }
        }
        if (is_weixin()) {
            if (empty($openid)) {
                $wx = new \Component\Wxgetuser();
                if (empty($_GET['code'])) {
                    $wx->get_code();
                }
                $openid = $wx->getuseropenid();
                if (!empty($data['errcode'])) {
                    $this->gotopreurl('获取用户个人信息失败，请重试', U('Index/index'));
                    exit();
                }
            }
            $post['openid']  = $openid['openid'];
            $post['sex']     = $openid['sex'];
            $post['headimg'] = $openid['headimgurl'];
        }else{
            $post['headimg']=ROOT.'Public/admin/img/head.png';
        }
        //如果选择分销类别,则修改状态为申请分销中
        if ($post['category'] == 2) {
            $post['category'] = 1;
            $post['status']   = 1;
        } else {
            $post['status'] = 0;
        }
        $post['pid']      = substr($post['iphone'], 5);
        $post['credits']  = 9888;
        $post['one']      = 0.166666;
        $post['second']   = 0.33333;
        $post['third']    = 1;
        $post['all']      = 0;
        $post['signstatus']      = 1;
        $post['time']     = time();
        $row              = M('User')->add($post);
        if ($row === false) {
            $this->gotourl('注册账号失败', U('Index/index'));
            exit();
        } else {
            session('status', $row);
            //如果是代销
            if ($post['category'] ==3) {
                $this->gotourl('注册账号成功，你已成为代销会员', U('Center/center'));
                exit();
            } else {
                //其他都是贵宾会员
                if ($post['status'] === 2) {
                    $this->gotourl('注册账号成功,分销申请成功提交，待审核，7个工作日内有人为你专门服务', U('Mycenter/center'));
                    exit();
                } else {
                    $this->gotourl('注册账号成功,你已成为贵宾会员', U('Mycenter/center'));
                    exit();
                }
            }
        }
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
