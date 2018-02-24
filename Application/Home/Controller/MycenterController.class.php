<?php

namespace Home\Controller;

use Think\Controller;

class MycenterController extends PubController
{
    //贵宾
    public function center()
    {
        $user_info = $this->user_info;
        $user_info = $this->user_info;
        $one       = M('User')->where('introducer=%d', $user_info['id'])->select();
        $two       = 0;
        if (!empty($one)) {
            foreach ($one as $key => $value) {
                $two = (M('User')->where('introducer=%d', $value['id'])->count()) + $two;
            }
        }
        $user_info['num'] = $two + count($one);
        if ($user_info['category'] !=1) {
            $this->gotourl('您的用户类别禁止访问', U('Center/center'));
            exit();
        }
        /**************信息******************/
        $where['starttime'] = array('LT', time());
        $where['uptime']    = array('GT', time());
        $where['_logic']    = 'AND';
        $new                = M('New')->where($where)->select();
        if (!empty($new)) {
            foreach ($new as $key => $value) {
                $data = explode('<><>', $value['user_id']);
                if (!in_array($user_info['id'], $data)) {
                    $arr['user_id']=$value['user_id'].'<><>'.$user_info['id'];
                    M('New')->where('id=%d',$value['id'])->save($arr);
                    $new[$key]['content'] = htmlspecialchars_decode($value['content']);
                    $new[$key]['id']=encoded($value['id']);
                    $newdata[]=$new[$key];
                }
            }
            $newdata = json_encode($newdata);
        }
        /**************信息******************/
        $this->assign(array('user_info' => $user_info, 'tittle' => '金聚云', 'new' => $newdata));
        $this->display();
    }
    public function qrcode()
    {
        Vendor('phpqrcode.phpqrcode');
        $user_id              = I('get.user_id');
        $object               = new \QRcode();
        $url                  = 'http://' . $_SERVER['HTTP_HOST'] . U('Index/bang', array("user_id" => $user_id)); //网址或者是文本内容
        // dump($url);
        // exit();
        $level                = 3;
        $size                 = 3;
        $errorCorrectionLevel = intval($level); //容错级别
        $matrixPointSize      = intval($size); //生成图片大小
        $img                  = $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
        return $img;
    }
    public function qrcodeimg()
    {
        $user_info = $this->user_info;
        $this->assign(array('user_info' => $user_info, 'tittle' => '我的二维码'));
        $this->display();
    }
    public function aboutself()
    {
        $data = M('Self')->order('time desc')->select();
        $this->assign(array('data' => $data[0], 'tittle' => '关于我们'));
        $this->display();
    }
    public function reform()
    {
        $post            = I('post.');
        $post['user_id'] = I('session.status');
        $post['time']    = time();
        $post['new_id']  = decoded($post['new_id']);
        $res             = M('Reform')->add($post);
        if ($res === false) {
            session('new_status', null);
            $this->gotoindex('回复失败');
            exit();
        } else {
            session('new_status', 'success');
            $this->gotoindex('回复成功');
            exit();
        }
    }
}
