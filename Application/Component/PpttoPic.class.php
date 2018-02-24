<?php

namespace Component;

class PpttoPic
{
    public function pptToImage($ppName, $FileName)
    {
        $ppApp          = new \COM("PowerPoint.Application");
        $ppApp->Visible = true;
        $strPath        = realpath(basename(getenv($_SERVER["SCRIPT_NAME"]))); // C:/AppServ/www/myphp
        $ppName         = $strPath . $ppName;
        $FileName       = $strPath . $FileName;

        //*** Open Document ***//
        $ppName   = str_replace(DIRECTORY_SEPARATOR, '/', $ppName);
        $FileName = str_replace(DIRECTORY_SEPARATOR, '/', $FileName);
        $ppApp->Presentations->Open(realpath($ppName));
        //*** Save Document ***//
        if (!is_dir($FileName)) {
            mkdir($FileName, 0755);
        }
        $ppApp->ActivePresentation->SaveAs($FileName, 17); //'*** 18=PNG, 19=BMP **'
        $ppApp->Quit;
        $ppApp = null;
        return $FileName;
    }
    /**
     * ppt转重命名 将"幻灯片"字样截取
     *path 文件夹
     *
     */
    public function pptRename($path)
    {
        $dir = str_replace(DIRECTORY_SEPARATOR, '/', $path);
        if (!is_dir($dir)) {
//判断是不是文件夹
            exit('dir didnot exit ');
        }
        $file = scandir($dir);
        if (count($file) == 2) {
            exit('empty dir');
        } else {
            $cou = count($file);
            unset($file[0]);
            unset($file[1]);
            $arr = array();
            for ($i = 2; $i < $cou; $i++) {
                $ke = $dir . "/" . time() . substr($file[$i], 6);
                rename($dir . "/" . $file[$i], $ke);
                $str   = strstr($ke, 'ppt/');
                $arr[] = $str;
            }
            return $arr;
        }
    }
}