<?php
/*******************************
用户管理
@author spy
@company 三级分销系统
@date 2017-9-6
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class UserController extends PubController
{

    public function showlist()
    {
        $get = I('get.');
        // dump($_GET);
        // echo "string";
        if (!empty($get)) {
            $i = 0;
            // dump($get);
            // exit();
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
            if (!empty($get['iphone'])) {
                $i++;
                $where['iphone'] = array('like', '%' . $get['iphone'] . '%');
            }
            if ($get['category'] != 0) {
                $i++;
                $where['category'] = $get['category'];
            }
            if ($i >= 2) {
                $where['_logic'] = 'AND';
            }
            $this->assign('get', $get);
        }
        $num  = M('User')->where($where)->count();
        $page = new \Component\Page($num, 20);
        $pag  = $page->fpage();
        $data = M('User')->where($where)->limit($page->limit)->order('time desc')->select();
        foreach ($data as $key => $value) {
            $data[$key]['secondnum'] = $this->showsecondcount($value['id']);
            $data[$key]['thirdnum']  = $this->showthirdcount($value['id']);
            $data[$key]['money']     = $value['credits'] / 100.00;
            $money_all= M('Money')->where('user_id=%d', $value['id'])->sum('money');
            $data[$key]['money_all'] =empty($money_all)?0:$money_all;    
            if(empty($data[$key]['headimg'])){
                    $data[$key]['headimg']=ROOT.'Public/admin/img/head.png';
                }
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
    public function update()
    {
        $get  = decoded(I('get.id'));
        $data = M('User')->where('id=%d', $get)->select();
        $this->assign(array('data' => $data[0]));
        $this->display();
    }
        public function modifypassword()
    {
        $id   = decoded(I('get.id'));
        $data = M('User')->where('id=%d', $id)->select();
        $this->assign(array('data' => $data[0]));
        $this->display();
    }
    public function savepassword()
    {
        $post = I('post.');
        if (empty($post['password']) || empty($post['repassword'])) {
            echo "<script> alert('新密码或确认密码不能为空');history.go(-1);</script>";
            exit();
        }
        $str_password = '/^[0-9a-zA-Z][0-9a-zA-Z]{4}[0-9a-zA-Z]$/';
        if (!preg_match($str_password, $_POST['password'])) {
            $this->gotopreurl('密码只能是6-8个长度的字母或者数字!', U('User/modifypassword'));
            exit();
        }
        if ($post['password'] !== $post['repassword']) {
            echo "<script> alert('新密码和确认密码不一致');history.go(-1);</script>";
            exit();
        }

        $data['id']       = decoded($post['id']);
        $data['password'] = md5($post['password']);
        $data['time']     = time();
        $row              = M('User')->where('id=%d', $data['id'])->save($data);
        if ($row === false) {
            $this->gotopreurl('修改密码失败', U('User/showlist'));
            exit();
        } else {
            $this->gotopreurl('修改密码成功', U('User/showlist'));
            exit();
        }
    }
    public function adddata()
    {
        $post = I('post.');
        if (empty($post['one']) || empty($post['second'] || empty($post['third']))) {
            $this->showerror('存在比例为空，请填写');
            exit();
        }
        $post['id']   = decoded($post['id']);
        $post['time'] = time();
        $row          = M('User')->where('id=%d', $post['id'])->save($post);
        if ($row === false) {
            $this->gotopreurl('数据更新失败', U('User/showlist'));
            exit();
        } else {
            $this->gotopreurl('数据更新成功', U('User/showlist'));
            exit();
        }
    }
   public function delete()
    {
        $id  = I('get.id');
        $sel = M('User');
        $row = $sel->where('id=%d', $id)->delete();
        if ($row != false) {
            $this->success('删除用户信息成功！', U('User/showlist'));
        } else {
            $this->error('删除用户信息失败！', U('User/showlist'));
        }
    }
}
