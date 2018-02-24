<?php

namespace Component;

class Wordhtml
{
    public function createWord($data)
    {
        $html = '<div style="width:1600px">
        <div style="line-height:40px;font-size: 30px;height:20px;float:left;width:800px">
            <div style="width:800px;text-align:center;float:left">梅州市交通技工学校（&nbsp<span>' . $data['main']['gra_year'] . '</span>&nbsp）届毕业生</div>
            <div style="width:800px;text-align:center;float:left">毕业鉴定</div>
        </div>
        <div style="margin-left:100px">
            <table style="border-collapse:collapse;width:800px;border-bottom-width:0px;height:272px" border="1">
                <tr>
                    <td style="height:68px;width:85px;text-align:center">姓&nbsp名</td>
                    <td style="height:68px;width:87px;text-align:center">' . $data['main']['gra_name'] . '</td>
                     <td style="height:68px;width:85px;text-align:center">性&nbsp别</td>
                    <td style="height:68px;width:53px;text-align:center">' . $data['main']['gra_sex'] . '</td>
                    <td style="height:68px;width:88px;text-align:center">民&nbsp族</td>
                    <td style="height:68px;width:70px;text-align:center">' . $data['main']['nation'] . '</td>
                    <td style="height:68px;width:105px;text-align:center">出生年月</td>
                    <td style="height:68px;width:87px;text-align:center">' . $data['main']['brithdate'] . '</td>


                    <td rowspan="4" style="width: 140px;height:272px;"></td>
                </tr>
                <tr>
                    <td style="height:68px;width:85px;text-align:center">班&nbsp级</td>
                    <td colspan="3" style="height:68px;width:225px;text-align:center">' . $data['main']['gra_year'] . '级' . $data['main']['gra_class'] . '</td>
                    <td colspan="2" style="height:68px;width:158px;text-align:center">入党(团)时间</td>
                    <td style="height:68px;width:192px;text-align:center" colspan="2">' . $data['main']['partytime'] . '</td>
                </tr>
                <tr>
                    <td style="height:68px;width:85px;text-align:center">籍&nbsp贯</td>
                    <td colspan="7" style="height:68px;width:575;text-align:center">' . $data['main']['gra_adress'] . '</td>
                </tr>
                <tr>
                    <td style="height:68px;width:85px;text-align:center">现住址</td>
                    <td colspan="7" style="height:68px;width:575px;text-align:center">' . $data['main']['nowaddress'] . '</td>
                </tr>
            </table>
            <div style="display: block;width:900px">
                <table style="border-collapse:collapse;width: 400px;border-right-width:0px;box-sizing:border-box;border-bottom-width:0px;text-align: center;float:left;border-top-width:0px;height:748px;" border="1" cellpadding="5">
                    <tr style="text-align: center;">
                        <td style="width:8%;letter-spacing:1px;height:748px;width:85px" rowspan="12">所
                            <br/>&nbsp
                            <br/>学
                            <br/>&nbsp
                            <br/>课
                            <br/>&nbsp
                            <br/>程
                            <br/>&nbsp
                            <br/>及
                            <br/>&nbsp
                            <br/>成
                            <br/>&nbsp
                            <br/>绩</td>
                        <td style="width:207px;height:68px">科&nbsp目</td>
                        <td style="width:122px;height:68px">成&nbsp绩</td>
                    </tr>';
        for ($i = 1; $i <= 10; $i++) {
            $html .= '<tr>
                        <td style="text-align:left;width:207px;height:68px">' . $i . '、' . $data['result'][1][$i]['courname'] . '</td>
                        <td style="width:122px;height:68px">' . $data['result'][1][$i]['result'] . '</td>
                    </tr>';
        }

        $html .= '</table>
                <table style="border-collapse:collapse;width: 400px;border-left-width:0px;box-sizing:border-box;text-align: center;border-bottom-width:0px;border-top-width:0px;height:748px;float:left" border="1" cellpadding="5">
                    <tr style="text-align: center;">
                        <td style="border-left-width:0;width:207px;height:68px">科&nbsp目</td>
                        <td style="border-left-width:0;width122px;height:68px">成&nbsp绩</td>
                    </tr>';
        if (isset($data['result'][2])) {
            for ($i = 1; $i <= 10; $i++) {
                $html .= '<tr>
                        <td style="text-align:left;width:207px;height:68px">' . $i . '、' . $data['result'][1][$i]['courname'] . '</td>
                        <td style="width:122px;height:68px">' . $data['result'][1][$i]['result'] . '</td>
                    </tr>';
            }
        }

        $html .= '</table>
                <table style="border-collapse:collapse;width:800px;text-align: center;border-top-width:0px;height: 54px;" border="1" cellpadding="5">
                    <tr>
                        <td style="width: 195px">受到何种奖励或处分</td>
                        <td style="width: 270px">' . $data['main']['reward'] . '</td>
                        <td style="width: 115px">操行成绩</td>
                        <td style="width: 230px">' . $data['main']['gra_evaluate'] . '</td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="float:right;width: 49%;height: 568px;">
            <table style="border-collapse:collapse;width:100%;text-align: center;box-sizing: border-box;height: 568px" border="1" cellpadding="5">
                <tbody>
                    <tr>
                        <td style="width: 8%;text-align: center">
                            <span style="display: inline-block;width: 100%">自 </span>
                            <span style="display: inline-block;width: 100%"> </span>
                            <span style="display: inline-block;width: 100%">我</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">鉴</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">定</span>
                        </td>
                        <td colspan="5" style="position: relative;">
                            <div>' . $data['main']['selfde'] . '</div>
                            <div style="position:absolute;bottom: 0;right: 0">
                                <span>
                            <span>签名:</span>
                                <span></span>
                                </span>
                                <span style="display: inline-block; height: 21px;line-height: 21px;">
                           <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">年</span>
                                <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">月</span>
                                <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">日</span>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>旷课</td>
                        <td><span style="float: right;display: inline-block;">' . $data['main']['lettime'] . '(节)</span></td>
                        <td style="width:15%">迟到、早退</td>
                        <td><span style="float: right;display: inline-block;">' . $data['main']['outtime'] . '(节)</span></td>
                        <td style="width:15%">病事假</td>
                        <td>' . $data['main']['deduction'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 8%;text-align: center;">
                            <span style="display: inline-block;width: 100%">班</span>
                            <span style="display: inline-block;width: 100%"> </span>
                            <span style="display: inline-block;width: 100%">主</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">任</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">评</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">语</span>
                        </td>
                        <td colspan="5" style="position: relative;">
                         <div>' . $data['main']['teacherde'] . '</div>
                            <div style="position:absolute;bottom: 0;right: 0">
                                <span>
                            <span>班主任签名:</span>
                                <span></span>
                                </span>
                                <span style="display: inline-block; height: 21px;line-height: 21px;">
                           <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">年</span>
                                <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">月</span>
                                <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">日</span>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 8%;text-align: center;">
                            <span style="display: inline-block;width: 100%">学 </span>
                            <span style="display: inline-block;width: 100%"> </span>
                            <span style="display: inline-block;width: 100%">校</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">意</span>
                            <span style="display: inline-block;width: 100%"></span>
                            <span style="display: inline-block;width: 100%">见</span>
                        </td>
                        <td colspan="5" style="position: relative;">
                         <div>' . $data['main']['schoolde'] . '</div>
                            <div style="position:absolute;bottom: 0;right: 0">
                                <span>
                            <span>盖章</span>
                                <span></span>
                                </span>
                                <span style="display: inline-block; height: 21px;line-height: 21px;">
                           <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">年</span>
                                <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">月</span>
                                <span style="display: inline-block;width:10px;height: 21px;"></span>
                                <span style="display: inline-block;height: 21px;">日</span>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>';

        return $html;
    }
}
