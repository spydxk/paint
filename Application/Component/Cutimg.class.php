<?php
/*
 * cutting images example
 * author: xinqiyang
 * blog: http://scotoma.cnblogs.om/
 */
namespace Component;

class Cutimg
{
    // cutting images
    public function filecut($width,$height,$type)
    {
        if (!empty($_REQUEST['cut_pos'])) {
            require 'ImageResize.class.php';
            $imgresize = new \Component\ImageResize();
            $url       = C('ATTACHDIR') . '/temp/' . trim($_POST['imgname']);
            $imgresize->load($url);
            $posary = explode(',', $_REQUEST['cut_pos']);
            foreach ($posary as $k => $v) {
                $posary[$k] = intval($v);
            }
            if ($posary[2] > 0 && $posary[3] > 0) {
                $imgresize->resize($posary[2], $posary[3]);
            }
            $uico = time() . '.jpg';
            $path = C('AVATAR').$type.'/';
            // save 120*120 image
            $imgresize->cut($width, $height, intval($posary[0]), intval($posary[1]));
            $large = 'l_' . $uico;
            $imgresize->save($path . $large, true, '');
            $res=$path . $large;
            unlink($url);
            return $res;
        } else {
            return false;
        }
    }
}
