<?php

namespace Component;

class Wordhtml
{
    public function createWord($data)
    {
        $url='Public/Uploads/home/';
       $html = '<table style="border-spacing: 0px;border-collapse: collapse;vertical-align:middle;padding:0px">
<tr>
  <th style="height: 80px;line-height: 80px;vertical-align: middle;text-align: center;font-size:18px" colspan="8" >学生个人基本资料</th>
</tr>
    <tr>
        <td style="border: 1px solid #000;width: 140px;height: 33px;vertical-align: middle;text-align: center;font-size:12px">姓名</td>
        <td style="border: 1px solid #000;width: 200px;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['name'].'</td>
        <td style="border: 1px solid #000;width: 140px;height: 33px;vertical-align: middle;text-align: center;font-size:12px">性别</td>

        <td style="border: 1px solid #000;width: 100px;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['sex'].'</td> 
        <td style="border: 1px solid #000;width: 100px;height: 33px;vertical-align: middle;text-align: center;font-size:12px">出生年月</td>
        <td style="border: 1px solid #000;width: 140px;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['brithdate'].'</td>
        <td colspan="2" style="border: 1px solid #000;width:120px;text-align:center" rowspan="4"><img src="'.$url.'headimg/'.$data['headimg'].'" width="100" height="132"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">证件号</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['idcard'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">民族</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['nation'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">籍贯</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['address'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">学生住址</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px" colspan="5">'.$data['stuaddress'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">工作单位</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px" colspan="5">'.$data['stuwork'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px;">报读院校</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">'.$data['school'].'</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">层次</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">'.$data['level'].'</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">年级</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">'.$data['grade'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">学院代码</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['code'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">学制</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px" colspan="3">'.$data['year'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">成人高考成绩</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px;">专业</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px;">'.$data['major'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px;">预报名号</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px;" colspan="3">'.$data['number'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px;width: 60px">语文</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px;width: 60px">'.$data['chinese'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">学号</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['school'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">考生号</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px" colspan="3">'.$data['studynum'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">数学</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['math'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">入学时间</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['math'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">预计毕业时间</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px" colspan="3">'.$data['jiontime'].'</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">英语</td>
        <td style="border: 1px solid #000;height: 33px;vertical-align: middle;text-align: center;font-size:12px">'.$data['english'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">学籍状态</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">'.$data['status'].'</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">学习类别</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px" colspan="3">'.$data['situation'].'</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">总分</td>
        <td style="border: 1px solid #000;height: 60px;vertical-align: middle;text-align: center;font-size:12px">'.$data['total'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px">教学点名称</td>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">'.$data['schoolname'].'</td>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px" colspan="3">负责人</td>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">'.$data['header'].'</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px">教学点地址</td>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">'.$data['schooladdress'].'</td>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px" colspan="3">办公室电话</td>
        <td style="border: 1px solid #000;height: 40px;vertical-align: middle;text-align: center;font-size:12px" colspan="2">'.$data['worknum'].'</td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;height: 160px;vertical-align: middle;text-align: center;" width="470" height="160" colspan="3">
        <img src="'.$url.'idcardhead/'.$data['headurl'].'" width="320" height="190">
      </td>
      <td style="border: 1px solid #000;height: 160px;vertical-align: middle;text-align: center;" width="420" height="160" colspan="5">
        <img src="'.$url.'idcardtaill/'.$data['taillurl'].'" width="320" height="190">
      </td>
    </tr>
</table>
';
// $html.='</html>';
        return $html;
    }
}
