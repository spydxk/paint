<?php
/*
 * cutting images example
 * author: xinqiyang
 * blog: http://scotoma.cnblogs.om/
 */
namespace Component;

class UploadFile
{
    // cutting images
    public function addfile($file, $filepath, $arr)
    {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($arr!==null) {
            if (!in_array($ext, $arr)) {
                $data['status']  = 1;
                $data['message'] = "格式不正确或不支持" . $ext . "文件上传，请核对后重新上传";
                return $data;
            }
        }
        $time = date('Y-m-d', time());
        $name = $time . '/' . date('Ymd', time()) . rand(0, 1000) . '.' . $ext;
        $path = $filepath . $name;
        if (!is_dir($filepath . $time)) {
            $row=mkdir($filepath . $time, 0755);
            if($row===false){
                $data['status']  = 4;
                $data['message'] = "文件目录创建失败";
                return $data;
            }
        }
        $rst[] = move_uploaded_file($file['tmp_name'], $path);
        $rst[] = chmod($path, 0644);
        //返回正确或错误的图标
        if (($rst[0] === false) && ($rst[1] === false)) {
            $data['status']  = 2;
            $data['message'] = '文件上传失败';
        } else {
            $data['status'] = 3;
            $data['url']    = $name;
            $data['size']    = $file['size'];
            $data['name']    = $file['name'];
        }
        return $data;
    }
}
