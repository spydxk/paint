<?php
/**
 * 表单数据过滤 防注入
 * @param type $data
 * @return type
 */
function check_input($data){
    //对特殊符号添加反斜杠
    $data = addslashes($data);
    //判断自动添加反斜杠是否开启
    if(get_magic_quotes_gpc()){
        //去除反斜杠
        $data = stripslashes($data);
    }
    //把'_'过滤掉
    $data = str_replace("_", "\_", $data);
    //把'%'过滤掉
    $data = str_replace("%", "\%", $data);
    //把'*'过滤掉
    $data = str_replace("*", "\*", $data);
    //回车转换
    $data = nl2br($data);
    //去掉前后空格
    $data = trim($data);
    //将HTML特殊字符转化为实体
    $data = htmlspecialchars($data);
    return $data;
}
function array_diff_assoc2_deep($array1, $array2)
{
    $ret = array();
    foreach ($array1 as $k => $v) {
        if (!isset($array2[$k])) {
            $ret[$k] = $v;
        } else if (is_array($v) && is_array($array2[$k])) {
            $ret[$k] = array_diff_assoc2_deep($v, $array2[$k]);
        } else if ($v != $array2[$k]) {
            $ret[$k] = $v;
        } else {
            unset($array1[$k]);
        }

    }
    return $ret;
}
function is_mobile()
{
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_mac = (strpos($agent, 'mac os')) ? true : false;
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        

        if($is_pc){
              return  false;
        }
        
        if($is_mac){
              return  true;
        }
        
        if($is_iphone){
              return  true;
        }
        
        if($is_android){
              return  true;
        }
        
        if($is_ipad){
              return  true;
        }
}
/**
 * 安全URL编码
 * @param type $data
 * @return type
 */
function encoded($data)
{
    return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode(serialize($data)));
}
/**
 * 安全URL解码
 * @param type $string
 * @return type
 */
function decoded($string)
{
    $data = str_replace(array('-', '_'), array('+', '/'), $string);
    $mod4 = strlen($data) % 4;
    ($mod4) && $data .= substr('====', $mod4);
    return unserialize(base64_decode($data));
}
//删除目录及所有文件
function deleteAll($path)
{
    $op = dir($path);
    while (false != ($item = $op->read())) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (is_dir($op->path . '/' . $item)) {
            deleteAll($op->path . '/' . $item);
            rmdir($op->path . '/' . $item);
        } else {
            unlink($op->path . '/' . $item);
        }

    }
}
//下载文件

/**
 *
 * URL: http://www.cnitblog.com/CoffeeCat/archive/2008/08/07/47753.html
 *
 * 根据HTML代码获取word文档内容
 * 创建一个本质为mht的文档，该函数会分析文件内容并从远程下载页面中的图片资源
 * 该函数依赖于类MhtFileMaker
 * 该函数会分析img标签，提取src的属性值。但是，src的属性值必须被引号包围，否则不能提取
 *
 * @param string $content HTML内容
 * @param string $absolutePath 网页的绝对路径。如果HTML内容里的图片路径为相对路径，那么就需要填写这个参数，来让该函数自动填补成绝对路径。这个参数最后需要以/结束
 * @param bool $isEraseLink 是否去掉HTML内容中的链接
 */
function getWordDocument($content, $absolutePath = "", $isEraseLink = true)
{
    $mht = new \Component\Mhtfilemaker();
    if ($isEraseLink) {
        $content = preg_replace('/<a\s*.*?\s*>(\s*.*?\s*)<\/a>/i', '$1', $content);
    }
    //去掉链接

    $images  = array();
    $files   = array();
    $matches = array();
    //这个算法要求src后的属性值必须使用引号括起来
    if (preg_match_all('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/', $content, $matches)) {
        $arrPath = $matches[1];
        for ($i = 0; $i < count($arrPath); $i++) {
            $path = $arrPath[$i];
            // echo $path;
            $imgPath = trim($path);
            // echo $imgPath;
            if ($imgPath != "") {
                $files[] = $imgPath;
                if (substr($imgPath, 0, 7) == 'http://') {
                    //绝对链接，不加前缀
                } else {
                    $imgPath = $absolutePath . $imgPath;
                    // echo $imgPath;
                }
                // dump($imgPath);
                $images[] = $imgPath;
            }
        }
    }
    // exit();
    $mht->AddContents("tmp.html", $mht->GetMimeType("tmp.html"), $content);

    for ($i = 0; $i < count($images); $i++) {
        $image = $images[$i];
        if (@fopen($image, 'r')) {
            $imgcontent = @file_get_contents($image);
            if ($content) {
                $mht->AddContents($files[$i], $mht->GetMimeType($image), $imgcontent);
            }

        } else {
            echo "file:" . $image . " not exist!<br />";
        }
    }
// exit();
    return $mht->GetFile();
}
function is_weixin()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}
//发送邮件
function mailer($em_user, $fileurl, $filename)
{
    Vendor('PHPMailer.PHPMailerAutoload');
    $phpmailer = new PHPMailer();
    $phpmailer->IsSMTP(); // 用smtp协议来发
    $phpmailer->CharSet  = 'UTF-8';
    $phpmailer->Host     = 'smtp.163.com';
    $phpmailer->SMTPAuth = true;
    // SMTP 安全协议
    // $phpmailer->SMTPSecure = "ssl";
    $phpmailer->Port = 25;
    // $phpmailer->Mailer   = "SMTP";
    $phpmailer->Username = 'qhjy2224144@163.com';
    $phpmailer->Password = 'qhjy2224144';
    $phpmailer->From     = 'qhjy2224144@163.com';
    $phpmailer->FromName = 'qhjy2224144';
    $phpmailer->Subject  = '【新报名表】';
    $phpmailer->Body     = "【新报名表】启航教育，您有一份新的报名表未查看，请及时处理。";
    $phpmailer->AddAttachment($fileurl, $filename); // 添加附件,并指定名称
    $phpmailer->AddAddress($em_user);
    $row = $phpmailer->send();
    if ($row == false) {
        $data['status']  = false;
        $data['message'] = $phpmailer->ErrorInfo . PHP_EOL;
        return $data;
    } else {
        $data['status'] = true;
        return $data;
    }
}
//删除目录
function deldir($dir)
{
    //先删除目录下的文件：
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }

    closedir($dh);
    //删除当前文件夹：
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}
//
//遍历加密
function jiami($arr, $num)
{
    if ($num == 1) {
        foreach ($arr as $key => $value) {
            $arr[$key]['id'] = encoded($value['id']);
        }
        return $arr;
    } else if ($num == 2) {
        foreach ($arr as $key => $value) {
            foreach ($value as $k => $v) {
                $arr[$key][$k]['id'] = encoded($v['id']);
            }
        }
        return $arr;
    }
}
function totime($arr, $num)
{
    if ($num == 1) {
        foreach ($arr as $key => $value) {
            $arr[$key]['time'] = date('Y-m-d', $value['time']);
        }
        return $arr;
    } else if ($num == 2) {
        foreach ($arr as $key => $value) {
            foreach ($value as $k => $v) {
                $arr[$key][$k]['time'] = date('Y-m-d', $v['time']);
            }
        }
        return $arr;
    }
}
function deserror($arr)
{
    foreach ($arr as $key => $value) {
        if ($value === false) {
            $res = 0;
            return $res;
        } else {
            $res = 1;
        }
    }
    return $res;
}
function selrole($id)
{
    $tem = M('Role')->where("role_leve = %d", $id)->select();
    if (!empty($tem)) {
        foreach ($tem as $key => $value) {
            $tem1 = selrole($value['role_id']);
            if ($tem1 == false) {
                $man[] = $value;
            } else {
                $man[] = $value;
                foreach ($tem1 as $k2 => $v2) {
                    $man[] = $v2;
                }
            }
        }
        return $man;
    } else {
        return false;
    }
}

//处理数组空值
function desvalue($arr)
{
    foreach ($arr as $key => $value) {
        if (empty($value)) {
            unset($arr[$key]);
        }
    }
    return $arr;
}

function numtonum($num)
{
    vendor('numtonum.numtonum');
    $c = new ChineseNumber();
    return $c->ParseNumber($num);
}

function jiai($arr)
{
    $i = 1;
    foreach ($arr as $key => $value) {
        $arr[$key]['i_num'] = $i;
        $i++;
    }
    return $arr;
}
function jiaid($arr)
{
    $i = 1;
    foreach ($arr as $key => $value) {
        $arr[$key]['id'] = $i;
        $i++;
    }
    return $arr;
}

function readecexl($fileName)
{
    // import('Component.Classes.PHPExcel');
    $path = './Public/Uploads/tmp/' . $fileName;
    // echo $path;
    import('Component.Classes.PHPExcel.Autoloader');
    require_once './Component/Classes/PHPExcel/IOFactory.php';
    $objReader    = \PHPExcel_IOFactory::createReaderForFile($path);
    $objPHPExcel  = $objReader->load($path);
    $currentSheet = $objPHPExcel->setActiveSheetIndex(0);
    $content      = array();
    // $currentSheet->setCellValueExplicit('H3','8757584',PHPExcel_Cell_DataType::TYPE_STRING);
    // dump($currentSheet);
    // exit();
    // $row = $currentSheet->getHighestRow();  //获取最大行数
    $column = PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn()); //获取最大列数
    // $row = (int)$currentSheet->getHighestRow();  //获取最大行数
    // $column =PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn());  //获取最大列数
    // dump($column);
    // exit();
    // $objPHPExcel->getActiveSheet()->getStyle('E'.$n)->getNumberFormat()->setFormatCode("@");

    $objWorksheet = $objPHPExcel->getActiveSheet();

    // $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()
    // ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    // $objWorksheet->getStyle('E2')->getNumberFormat()->setFormatCode("@");
    foreach ($objWorksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        // dump($cellIterator);
        foreach ($cellIterator as $cell) {
            $content[] = $cell->getValue();
        }
    }
    $data = array_chunk($content, $column);
    // dump($data);
    foreach ($data as $key => $value) {
        if ($key !== 0 || $key !== 1) {
            $data[$key][4]  = NumToStr($value[4]);
            $data[$key][14] = NumToStr($value[14]);
            $data[$key][7]  = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value[7]));
            $data[$key][18] = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value[18]));
            $data[$key][30] = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value[30]));
            // PHPExcel_Style_NumberFormat::FORMAT_TEXT
        }
    }
    $data['col'] = $column;
    return $data;
}

function read($fileName)
{
    // import('Component.Classes.PHPExcel');
    import('Component.Classes.PHPExcel.Autoloader');
    $path = $fileName;
    // $path = './Public/Uploads/tmp/' . $fileName;
    require_once './Component/Classes/PHPExcel/IOFactory.php';
    $objReader   = \PHPExcel_IOFactory::createReaderForFile($path);
    $objPHPExcel = $objReader->load($path);

    $currentSheet = $objPHPExcel->setActiveSheetIndex(0);
    $content      = array();

    // $currentSheet->setCellValueExplicit('H3','8757584',PHPExcel_Cell_DataType::TYPE_STRING);

    // dump($currentSheet);
    // exit();
    // $row = $currentSheet->getHighestRow();  //获取最大行数
    $column = PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn()); //获取最大列数
    // $row = (int)$currentSheet->getHighestRow();  //获取最大行数
    // $column =PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn());  //获取最大列数
    // dump($column);
    // exit();
    // $objPHPExcel->getActiveSheet()->getStyle('E'.$n)->getNumberFormat()->setFormatCode("@");

    $objWorksheet = $objPHPExcel->getActiveSheet();

    // $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()
    // ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    // $objWorksheet->getStyle('E2')->getNumberFormat()->setFormatCode("@");
    foreach ($objWorksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        // dump($cellIterator);
        foreach ($cellIterator as $cell) {
            $content[] = $cell->getValue();
        }
    }
    $data = array_chunk($content, $column);
    foreach ($data as $key => $value) {
        if ($key !== 0 || $key !== 1) {
            $data[$key][4]  = NumToStr($value[4]);
            $data[$key][14] = NumToStr($value[14]);
            $data[$key][7]  = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value[7]));
            $data[$key][18] = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value[18]));
            $data[$key][30] = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value[30]));
            // PHPExcel_Style_NumberFormat::FORMAT_TEXT
        }
    }
    // dump($data);
    // exit();
    $data['col'] = $column;
    return $data;
}
//data_col时间的行数
function readinexecl($fileName, $date_col)
{
    import('Component.Classes.PHPExcel.Autoloader');
    $path = './Public/Uploads/tmp/' . $fileName;
    require_once './Component/Classes/PHPExcel/IOFactory.php';
    $objReader    = \PHPExcel_IOFactory::createReaderForFile($path);
    $objPHPExcel  = $objReader->load($path);
    $currentSheet = $objPHPExcel->setActiveSheetIndex(0);
    $content      = array();
    // $objPHPExcel->getActiveSheet()->setCellValue('D1', ' ' . 123456789033);
    // $currentSheet->setCellValueExplicit('H3','8757584',PHPExcel_Cell_DataType::TYPE_STRING);
    // dump($currentSheet);
    // exit();
    // $row = $currentSheet->getHighestRow();  //获取最大行数
    $column = PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn()); //获取最大列数
    // $row = (int)$currentSheet->getHighestRow();  //获取最大行数
    // $column =PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn());  //获取最大列数
    // $objPHPExcel->getActiveSheet()->getStyle('E'.$n)->getNumberFormat()->setFormatCode("@");

    $objWorksheet = $objPHPExcel->getActiveSheet();
    // $objPHPExcel->getActiveSheet()->getStyle('F2')->getNumberFormat()->setFormatCode(PHPExcel_Cell_DataType::TYPE_STRING);

    // $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    // $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat();
    // ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    // $objWorksheet->getStyle('E2')->getNumberFormat()->setFormatCode("@");

    foreach ($objWorksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        foreach ($cellIterator as $k => $cell) {
            $content[] = $cell->getValue();
        }
    }
    $data = array_chunk($content, $column);
    unset($data[0]);
    // $data[1][2]=excelTime($data[1][2]);
    // dump($date_col);
    // exit();
    if (!empty($date_col)) {
        foreach ($data as $key => $value) {
            $data[$key][2] = getIDCardInfo($value[3]);
            foreach ($date_col as $k => $v) {
                if (!empty($value[$k])) {
                    $data[$key][$k] = gmdate($v, PHPExcel_Shared_Date::ExcelToPHP($value[$k]));
                }
            }
        }
    }
    // dump($data);
    // exit();
    $data['col'] = $column;
    return $data;
}
function getIDCardInfo($IDCard)
{
    $result['error'] = 0; //0：未知错误，1：身份证格式错误，2：无错误
    $result['flag']  = ''; //0标示成年，1标示未成年
    $result['tdate'] = ''; //生日，格式如：2012-11-15
    if (!eregi("^[1-9]([0-9a-zA-Z]{17}|[0-9a-zA-Z]{14})$", $IDCard)) {
        $result['error'] = 1;
        return $result;
    } else {
        if (strlen($IDCard) == 18) {
            $tyear  = intval(substr($IDCard, 6, 4));
            $tmonth = intval(substr($IDCard, 10, 2));
            $tday   = intval(substr($IDCard, 12, 2));
            if ($tyear > date("Y") || $tyear < (date("Y") - 100)) {
                $flag = 0;
            } elseif ($tmonth < 0 || $tmonth > 12) {
                $flag = 0;
            } elseif ($tday < 0 || $tday > 31) {
                $flag = 0;
            } else {
                // $tdate=$tyear."-".$tmonth."-".$tday." 00:00:00";
                $tdate = $tyear . "-" . $tmonth . "-" . $tday;
                if ((time() - mktime(0, 0, 0, $tmonth, $tday, $tyear)) > 18 * 365 * 24 * 60 * 60) {
                    $flag = 0;
                } else {
                    $flag = 1;
                }
            }
        } elseif (strlen($IDCard) == 15) {
            $tyear  = intval("19" . substr($IDCard, 6, 2));
            $tmonth = intval(substr($IDCard, 8, 2));
            $tday   = intval(substr($IDCard, 10, 2));
            if ($tyear > date("Y") || $tyear < (date("Y") - 100)) {
                $flag = 0;
            } elseif ($tmonth < 0 || $tmonth > 12) {
                $flag = 0;
            } elseif ($tday < 0 || $tday > 31) {
                $flag = 0;
            } else {
                // $tdate=$tyear."-".$tmonth."-".$tday." 00:00:00";
                $tdate = $tyear . "-" . $tmonth . "-" . $tday;
                if ((time() - mktime(0, 0, 0, $tmonth, $tday, $tyear)) > 18 * 365 * 24 * 60 * 60) {
                    $flag = 0;
                } else {
                    $flag = 1;
                }
            }
        }
    }
    $result['error']    = 2; //0：未知错误，1：身份证格式错误，2：无错误
    $result['isAdult']  = $flag; //0标示成年，1标示未成年
    $result['birthday'] = $tdate; //生日日期
    return $tdate;
}

function excelTime($days, $time = false)
{
    if (is_numeric($days)) {
        //based on 1900-1-1
        $jd        = GregorianToJD(1, 1, 1970);
        $gregorian = JDToGregorian($jd + intval($days) - 25569);
        $myDate    = explode('/', $gregorian);
        $myDateStr = str_pad($myDate[2], 4, '0', STR_PAD_LEFT)
        . "-" . str_pad($myDate[0], 2, '0', STR_PAD_LEFT);
        // ."-".str_pad($myDate[1],2,'0', STR_PAD_LEFT)
        // .($time?" 00:00:00":'');
        return $myDateStr;
    }
    return $days;
}
function NumToStr($num)
{
    if (stripos($num, 'e') === false) {
        return $num;
    }

    $num    = trim(preg_replace('/[=\'"]/', '', $num, 1), '"'); //出现科学计数法，还原成字符串
    $result = "";
    while ($num > 0) {
        $v      = $num - floor($num / 10) * 10;
        $num    = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}

function del0($num)
{
    return "" . intval($num);
}
//单个数字变汉字
function n2c($x)
{
    $arr_n = array("零", "一", "二", "三", "四", "五", "六", "七", "八", "九", "十");
    return $arr_n[$x];
}
//读取数值（4位）
function num_r($abcd)
{
    $arr      = array();
    $str      = ""; //读取后的汉字数值
    $flag     = 0; //该位是否为零
    $flag_end = 1; //是否以“零”结尾
    $size_r   = strlen($abcd);
    for ($i = 0; $i < $size_r; $i++) {
        $arr[$i] = $abcd{$i};
    }
    $arrlen = count($arr);
    for ($j = 0; $j < $arrlen; $j++) {
        $ch = n2c($arr[$arrlen - 1 - $j]); //从后向前转汉字
        if ($ch == "零" && $flag == 0) {
            //如果是第一个零
            $flag = 1; //该位为零
            $str  = $ch . $str; //加入汉字数值字符串
            continue;
        } elseif ($ch == "零") {
            //如果不是第一个零了
            continue;
        }
        $flag = 0; //该位不是零
        switch ($j) {
            case 0:$str = $ch;
                $flag_end   = 0;
                break; //第一位（末尾），没有以“零”结尾
            case 1:$str = $ch . "十" . $str;
                break; //第二位
            case 2:$str = $ch . "百" . $str;
                break; //第三位
            case 3:$str = $ch . "千" . $str;
                break; //第四位
            case 4:$str = $ch . "万" . $str;
                break; //第五位
            case 5:$str = $ch . "十" . $str;
                break; //第六位
            case 6:$str = $ch . "百" . $str;
                break; //第七位
            case 7:$str = $ch . "千" . $str;
                break; //第八位
        }
    }
    //如果以“零”结尾
    if ($flag_end == 1) {
        mb_internal_encoding("UTF-8");
        $str = mb_substr($str, 0, mb_strlen($str) - 1); //把“零”去掉
    }
    return $str;
}
function num2ch($num) //整体读取转换

{
    $num_real = del0($num); //去掉前面的“0”
    $numlen   = strlen($num_real);
    echo "numlen=" . $numlen . "";
    if ($numlen >= 9) //如果满九位，读取“亿”位
    {
        $y = substr($num_real, -9, 1);
        //echo $y;
        $wsbq = substr($num_real, -8, 4);
        $gsbq = substr($num_real, -4);
        $a    = num_r(del0($gsbq));
        $b    = num_r(del0($wsbq)) . "万";
        $c    = num_r(del0($y)) . "亿";
    } elseif ($numlen <= 8 && $numlen >= 5) //如果大于等于“万”
    {
        $wsbq = substr($num_real, 0, $numlen - 4);
        $gsbq = substr($num_real, -4);
        $a    = num_r(del0($gsbq));
        $b    = num_r(del0($wsbq)) . "万";
        $c    = "";
    } elseif ($numlen <= 4) //如果小于等于“千”
    {
        $gsbq = substr($num_real, -$numlen);
        $a    = num_r(del0($gsbq));
        $b    = "";
        $c    = "";
    }
    $ch_num = $c . $b . $a;
    return $ch_num;
}
// function downfiles($etc,$filename)
// {
//     $downnow = new \Component\DownFile($etc);
//     if (!$downnow->downloadfile($filename)) {
//         return $downnow->geterrormsg();
//     }

// }

function downfiles($file, $filt)
{

    //First, see if the file exists
    //Gather relevent info about file
    // echo $file;
    $len            = filesize($filt);
    $filename       = basename($file);
    $file_extension = strtolower(substr(strrchr($filename, "."), 1));
    // echo $file;
    // exit('>>>>' . $len . '>>>>' . $filename . '>>>>' . $file_extension);
    //This will set the Content-Type to the appropriate setting for the file
    switch ($file_extension) {
        case "pdf":$ctype = "application/pdf";
            break;
        case "exe":$ctype = "application/octet-stream";
            break;
        case "zip":$ctype = "application/zip";
            break;
        case "doc":$ctype = "application/msword";
            break;
        case "docx":$ctype = "application/msword";
            break;
        case "xls":$ctype = "application/vnd.ms-excel";
            break;
        case "ppt":$ctype = "application/vnd.ms-powerpoint";
            break;
        case "gif":$ctype = "image/gif";
            break;
        case "png":$ctype = "image/png";
            break;
        case "jpeg":
        case "jpg":$ctype = "image/jpg";
            break;
        case "mp3":$ctype = "audio/mpeg";
            break;
        case "wav":$ctype = "audio/x-wav";
            break;
        case "mpeg":
        case "mpg":
        case "mpe":$ctype = "video/mpeg";
            break;
        case "mov":$ctype = "video/quicktime";
            break;
        case "avi":$ctype = "video/x-msvideo";
            break;

        //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
        case "php":
        case "htm":
        case "html":
        case "txt":die("<b>Cannot be used for " . $file_extension . " files!</b>");
            break;

        default:$ctype = "application/force-download";
    }
    $file = fopen($filt, "r");
    //返回的文件类型
    Header("Content-type:" . $ctype);
    //按照字节大小返回
    Header("Accept-Ranges: bytes");
    //返回文件的大小
    Header("Accept-Length: " . filesize($filt));
    //这里对客户端的弹出对话框，对应的文件名
    $filename = basename($filt);
    Header("Content-Disposition: attachment; filename=" . $filename);
    //修改之前，一次性将数据传输给客户端
    echo fread($file, filesize($filt));
    //修改之后，一次只传输1024个字节的数据给客户端
    //向客户端回送数据
    $buffer = 1024; //
    //判断文件是否读完
    while (!feof($file)) {
        //将文件读入内存
        $file_data = fread($file, $buffer);
        //每次向客户端回送1024个字节的数据
        echo $file_data;
    }
    fclose($file);
    exit();
}
