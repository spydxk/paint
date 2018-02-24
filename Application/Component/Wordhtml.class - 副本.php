<?php

namespace Component;

class Wordhtml
{
    public function createWord($data)
    {
        // dump($data);
        // exit();
       $html = '<table style="border-collapse:collapse;width:1592px;padding: 0px;margin-top:0px;" border="0" cellspacing="0">
        <tr style="height: 70px;">
            <th colspan="9" style="width: 795px;font-size: 32px;height:70px;line-height: 70px;vertical-align: middle;text-align: center;font-weight: 900;border:1px solid #fff">梅州市交通技工学校（　<span>' .($data['main']['gra_year']+2).'</span>　）届毕业生</th>
            <td style="width: 67px;border:1px solid #fff" rowspan="21"></td>
            <td style="width: 108px;border:1px solid #000;text-align: center;" rowspan="6">自<br/><br/>我<br/><br/>鉴<br/><br/>定</td>
            <td style="width: 622px;text-indent:2em;text-align:left;border:1px solid #000;text-indent:2em;vertical-align:top" rowspan="6" colspan="5">' . $data['main']['selfde'] . '<p style="position:absolute;bottom:3px;right:0px;">签名：           年    月    日</p></td>
        </tr>
        <tr>
            <th colspan="9" style="width: 795px;height:70px;font-size: 28px;line-height: 70px;vertical-align: middle;border:0px;text-align: center;font-weight: 600;border:1px solid #fff"><span style="margin-bottom:8px">毕业鉴定表（' . $data['main']['gra_major'] . '专业）</span></th>
        </tr>
        <tr style="height: 68px">
            <td style="height:59px;width:85px;text-align:center;border:1px solid #000">姓　名</td>
            <td style="height:59px;width:87px;text-align:center;border:1px solid #000">' . $data['main']['gra_name'] . '</td>
            <td style="height:59px;width:85px;text-align:center;border:1px solid #000">性　别</td>
            <td style="height:59px;width:53px;text-align:center;border:1px solid #000">' . $data['main']['gra_sex'] . '</td>
            <td style="height:59px;width:88px;text-align:center;border:1px solid #000">民　族</td>
            <td style="height:59px;width:70px;text-align:center;border:1px solid #000">' . $data['main']['gra_nation'] . '</td>
            <td style="height:59px;width:105px;text-align:center;border:1px solid #000">出生年月</td>
            <td style="height:59px;width:87px;text-align:center;border:1px solid #000">' . $data['main']['brithdate'] . '</td>
            <td rowspan="4" style="width: 140px;height:272px;border:1px solid #000"></td>
        </tr>
        <tr>
            <td style="height:59px;width:85px;text-align:center;border:1px solid #000">班　级</td>
            <td colspan="3" style="height:59px;width:225px;text-align:center;border:1px solid #000">' . $data['main']['gra_year'] . '级' .$data['main']['gra_major'] . $data['main']['gra_class'] . '</td>
            <td colspan="2" style="height:59px;width:158px;text-align:center;border:1px solid #000">入党(团)时间</td>
            <td style="height:59px;width:192px;text-align:center" colspan="2">' . $data['main']['partytime'] . '</td>
        </tr>
        <tr>
            <td style="height:59px;width:85px;text-align:center;border:1px solid #000">籍　贯</td>
            <td colspan="7" style="height:59px;width:575;text-align:center;border:1px solid #000">' . $data['main']['gra_adress'] . '</td>
        </tr>
        <tr>
            <td style="height:59px;width:85px;text-align:center;border:1px solid #000">现住址</td>
            <td colspan="7" style="height:59px;width:575px;text-align:center;border:1px solid #000">' . $data['main']['nowaddress'] . '</td>
        </tr>
        <tr>
            <td style="height:59px;text-align:center;border:1px solid #000" rowspan="14">所课程及成绩</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">科目 </td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">成绩</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">科目</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > 成绩</td>
            <td style="height:59px;text-align:center;border:1px solid #000;width: 108px" >旷课</td>
            <td style="height:59px;text-align:center;border:1px solid #000;width: 128px" >' . $data['main']['lettime'] . '／（节）</td>
            <td style="height:59px;text-align:center;border:1px solid #000;width: 144px" >迟到、早退</td>
            <td style="height:59px;text-align:center;border:1px solid #000;width: 128px" >' . $data['main']['outtime'] . '／（节）</td>
            <td style="height:59px;text-align:center;border:1px solid #000;width: 97px" >病事假</td>
            <td style="height:59px;text-align:center;border:1px solid #000" >' . $data['main']['deduction'] . '</td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][0]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][0]['result'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][12]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000">' . $data['result'][12]['result'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" rowspan="7">班<br/><br/>主<br/><br/>任<br/><br/>评<br/><br/>语</td>
          <td style="text-indent:2em;text-align:left;border:1px solid #000;vertical-align:top" colspan="5" rowspan="7">' . $data['main']['teacherde'].'</td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][1]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][1]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][13]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" >' . $data['result'][13]['result'] . '</td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][2]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][2]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][14]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" >' . $data['result'][14]['result'] . ' </td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][3]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][3]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][15]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][15]['result'] . '</td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][4]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][4]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][16]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" >' . $data['result'][16]['result'] . ' </td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][5]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][5]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][17]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][17]['result'] . '</td> 
             <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][6]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][6]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][18]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][18]['result'] . '</td>
        </tr>  
        <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][7]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][7]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][19]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" >' . $data['result'][19]['result'] . ' </td>
          <td style="height:59px;text-align:center;border:1px solid #000" rowspan="6">学<br/><br/>校<br/><br/>意<br/><br/>见</td>
          <td style="border:1px solid #000;text-align:left;border:1px solid #000;text-indent:2em;vertical-align:top" colspan="6" rowspan="6">' . $data['main']['schoolde'] . '</td>
        </tr>

        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][8]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][8]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][20]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][20]['result'] . '</td>
        </tr>
        <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][9]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][9]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][21]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][21]['result'] . '</td>
        </tr>
         <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][10]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][10]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][22]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][22]['result'] . '</td>
        </tr>
         <tr>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="3">' . $data['result'][11]['courname'] . '</td>
          <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][11]['result'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="2">' . $data['result'][23]['courname'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000" > ' . $data['result'][23]['result'] . '</td>
        </tr>
        <tr>
            <td style="height:59px;text-align:center;border:1px solid #000">受到何种奖励或处分</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="5">' . $data['main']['reward'] . '</td>
            <td style="height:59px;text-align:center;border:1px solid #000">操行成绩</td>
            <td style="height:59px;text-align:center;border:1px solid #000" colspan="1">' . $data['main']['gra_evaluate'] . '</td>
        </tr>
    </table>';

        return $html;
    }
}
