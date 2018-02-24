<?php
/*******************************
用户管理
@author spy
@company 梅州市交通技工学校
@date 2016-12-1
 ********************************/
namespace Admin\Controller;

use Think\Controller;

class PubController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $ses = I('session.auserinfo');
        if (empty($ses)) {
            $this->error('您尚未登录，请登录', U('Usermanage/login'));
            exit();
        }
    }
    public function gotourl($note, $url)
    {
        echo "<script> alert('" . $note . "');self.location='" . $url . "';</script>";
        exit();
    }
    public function showerror($note)
    {
        echo "<script> alert('" . $note . "');</script>";
        exit();
    }
    protected function gotopreurl($note, $url)
    {
        echo "<script> alert('" . $note . "');parent.history.go(-1);var index = parent.layer.getFrameIndex(window.name);window.parent.layer.close(index);</script> ";
        exit();
    }
    public function gotoupurl($note, $url)
    {
        echo "<script> alert('" . $note . "');var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.location='" . $url . "';</script>";
        exit();
    }
    public function deldir($path, $delDir = false)
    {
        $handle = opendir($path);
        if ($handle) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
                }

            }
            closedir($handle);
            if ($delDir) {
                return rmdir($path);
            }

        } else {
            if (file_exists($path)) {
                return unlink($path);
            } else {
                return false;
            }
        }
    }
    //获取下级人数
    public function showsecondcount($pid)
    {
        $one = M('User')->where('introducer=%d', $pid)->select();
        $two = 0;
        if (!empty($one)) {
            foreach ($one as $key => $value) {
                $two = (M('User')->where('introducer=%d', $value['id'])->count()) + $two;
            }
        }
        $num = $two + count($one);
        return $num;
    }
    //获取三级人数
    public function showthirdcount($pid)
    {
        $data = M('User')->where('introducer=%d', $pid)->select();
        $num  = 0;
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $num2 = M('User')->where('introducer=%d', $value['id'])->count();
                $num  = $num + $num2;
            }
            return $num;
        } else {
            return $num;
        }
    }
}
