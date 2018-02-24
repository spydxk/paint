<?php
namespace Admin\Controller;

use Think\Controller;

class NewController extends PubController
{
    public function showlist()
    {
        $get = I('get.');
        // dump($get);
        unset($get['s']);
        if (!empty($get)) {
            $i = 0;
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
             $this->assign('get', $get);
        }
        $num  = M('New')->where($where)->count();
        $page = new \Component\Page($num, 20);
        $pag  = $page->fpage();
        $data = M('New')->where($where)->limit($page->limit)->order('time desc')->select();
        $data = jiai($data);
        $this->assign(array('data' => $data, 'num' => $num, 'page' => $pag));
        $this->display();
    }
    public function adddata()
    {
        header('Content-Type:text/html;charset=utf8');
        $post = I('post.');
        if (empty($post['tittle'])) {
            echo "<script> alert('消息标题不能为空');parent.history.go(-1);</script>";
            exit();
        }elseif(empty($post['uptime'])){
            echo "<script> alert('消息截止时间不能为空');parent.history.go(-1);</script>";
            exit();
        }else if (empty($post['content'])) {
            echo "<script> alert('消息内容不能为空');parent.history.go(-1);</script>";
            exit();
        }
        $post['time']=time();
        $post['uptime']=strtotime($post['uptime']);
        $post['starttime']=strtotime($post['starttime']);
        if(empty($post['id'])){
            unset($post['id']);
            $res=M('New')->add($post);
        }else{
            $res=M('New')->where('id=%d',$post['id'])->save($post);
        }
        if($res==false){
            $this->gotourl('数据更新失败',U('New/showlist'));
            exit();
        }else{
            $this->gotourl('数据更新成功',U('New/showlist'));
            exit();
        }
        exit();
    }
    public function addpage()
    {
        $id   = decoded(I('get.id'));
        $data = M('New')->where('id=%d', $id)->select();
        $this->assign('data', $data[0]);
        $this->display('addpage');
        exit();
    }
    public function showpage()
    {
        $id   = decoded(I('get.id'));
        $data = M('New')->where('id=%d',$id)->order('time desc')->select();
        $this->assign(array('data'=>$data[0]));
        $this->display();
    }
    public function delpage()
    {
        header('Content-Type:text/html;charset=utf8');
        $id  = decoded(I('get.id'));
        $res = M('New')->where('id=%d', $id)->delete();
        if ($res === false) {
            $this->gotourl('数据删除失败',U('New/showlist'));
            exit();
        } else {
            $this->gotourl('数据删除成功',U('New/showlist'));
            exit();
        }
    }
    public function showre(){
        $id=decoded(I('get.id'));
        if(!empty($id)){
            $new=M('New')->where('id=%d',$id)->order('time desc')->select();
            $re=M('Reform')->join('as re LEFT JOIN mb_user as us on re.user_id=us.id')->where('new_id=%d',$id)->order('re.time desc')->select();
            $data=jiai($re);
        }
        $this->assign(array('data'=>$data,'new'=>$new[0]));
        $this->display();
    }
    public function delnew(){
        $id=decoded(I('get.re_id'));
        $new_id=decoded(I('get.new_id'));
         $res = M('Reform')->where('re_id=%d', $id)->delete();
        if ($res == false) {
            $this->gotourl('数据删除失败',U('New/showre','id='.encoded($new_id)));
            exit();
        } else {
            $this->gotourl('数据删除成功',U('New/showre','id='.encoded($new_id)));
            exit();
        }
    }
}
