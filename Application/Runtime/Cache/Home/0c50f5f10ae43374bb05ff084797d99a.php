<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>金聚云</title>
    <link href="<?php echo (ADMIN_CSS_URL); ?>/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/animate.min.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/style.min862f.css?v=4.1.0" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?php echo (HOME_CSS_URL); ?>/common.css">
<script type="text/javascript" href="<?php echo (HOME_JS_URL); ?>/fontSize.js"></script> 
</head>

<body >
    <div class="head">
    <div style="position: absolute;">
    <?php if(!is_weixin()):?>
    <a href="<?php echo U('Login/outlogin');?>" style="line-height: 35px;font-size: 14px;margin-left: 9px;color: #fff;float: left;width: 100%;background-color: #139332;border-radius: 6px;font-size: 13px;margin-top: 3px;line-height: 25px;height: 26px; color: #fff;text-align: center;vertical-align: middle;font-family: Microsoft YaHei;width: 62px;">切换账号</a>
    <?php endif?>
    </div>
        <p style="float: left;width: 100%">
            <?php echo ($tittle); ?>
        </p>
        <div style="float: right;position: absolute;right: 3px">

            <!-- <a href="tel:15916537159"><img src="<?php echo (HOME_URL); ?>/images/13.png" style="width: 16px"></a> -->
            <a href="tel:18923006442"><p style="float: left;
    width: 100%;
    background-color: #139332;
    border-radius: 6px;
    font-size: 13px;
    margin-top: 3px;    line-height: 25px;
    height: 26px;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    /* font-weight: bold; */
    font-family: Microsoft YaHei;
    width: 62px;">一键拨号</p></a>
        </div>
    </div>
<div class="center_bd" <?php if(!is_mobile()):?>style='width: 26%;margin: auto;' <?php endif?>>
    <div class="background" style="display: none;<?php if(!is_mobile()):?>width: 26%;margin: auto;<?php endif?>" id="background" onclick="disbg()"></div>
    <div class="moneyshow" style="display: none;<?php if(!is_mobile()):?>width: 26%;margin: auto;<?php endif?>" id="moneyshow">
    </div>
    <div class="center_con">
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/03.png" class="mycenter_ico">
            <p class="info"><span class="idcard">账号：</span><span style="    display: inline-block;height: 55px;line-height: 55px;"><?php echo ($user_info['iphone']); ?></span></p>
        </div>
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/08.png" class="mycenter_ico">
            <p class="info"><span class="idcard">推荐ID：</span><span style="    display: inline-block;height: 55px;line-height: 55px;"><?php echo ($user_info['pid']); ?></span></p>
            <p class="tip">(默认手机后六位)</p>
        </div>
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/09.png" class="mycenter_ico">
            <p class="info"><span class="idcard">财务清单：<?php if(empty($user_info['money'])):?>0元<?php else: echo ($user_info['money']); ?>元<?php endif?></span>
                <a href="<?php echo U('Order/moneylist');?>" class="but_a">查看清单</a></p>
        </div>
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/10.png" class="mycenter_ico">
            <p class="info"><span class="idcard">本年度累计消费：<?php if(empty($user_info['all'])):?>0元<?php else: echo ($user_info['all']); ?>元<?php endif?></span>
                <span onclick="lookjl();" class="but_a">查看奖励</span></p>
        </div>
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/11.png" class="mycenter_ico">
            <p class="info"><span class="idcard">总积分：<?php echo ($user_info['credits']+$user_info['all']); ?></span>
                <span onclick="lookjf();" class="but_a">如何赚积分</span></p>
        </div>
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/06.png" class="mycenter_ico">
            <p class="info"><span class="idcard">可用积分：<?php echo ($user_info['credits']); ?></span>
            </p>
            <p class="tip">(100积分=人民币1元)</p>
        </div>
        <div class="index_list" style="text-align: center;">
            <span class="list_a" style="background-color: #818181" onclick="alert('即将为您呈现,积分超值兑换多款商品，可全额积分兑换。')">兑换商品</span>
            <span onclick="showbg();" class="list_a">申请提现</span>
            <span class="list_a" style="background-color: #818181" onclick="alert('支付抵现,即将为您做到,积分当现金使用，全额积分支付抵扣，不足可微信合并支付余额')">支付抵现</span>
            <span class="list_a" style="background-color: #818181" onclick="alert('积分生金,即将为您增值,10000积分起倍数整存，期限为12个月，每万积分每天增值1.88积分')">积分生金</span>
        </div>
        <div class="index_list">
            <img src="<?php echo (HOME_URL); ?>/images/12.png" class="mycenter_ico">
            <p class="info"><span class="idcard">签到：</span>
                <a href="<?php echo U('Center/signdown');?>" class="but_a">签到</a></p>
        </div>
        <div class="index_listbut">
            <p class="info"><span class="idcard" style="font-size: 12px">累计<span style="color: blue;font-size: 16px"><?php echo ($user_info['num']); ?></span>人在帮你赚积分,邀请他一起来吧！</span>
                <a href="<?php echo U('Mycenter/qrcodeimg');?>" class="but_ap">邀请</a></p>
        </div>
        <?php if(($user_info['category']==3)&&($user_info['status']==0)):?>
        <div class="index-sub">
            <a href="<?php echo U('Paint/changestatus');?>" onclick="return confirm('确定要提交申请吗？')">
                <input type="button" style="margin-top:35px" class="index-submit" value="申请分销">
            </a>
        </div>
        <?php endif?>
    </div>
</div>
<!-- <div style='width: 100%;text-align: center;'>
    <input type='button' onclick='disbg()' class='goback' style='width: 39px;background-color: #981306;margin: auto;color: #fff;border: 0px;height: 23px;float: none;margin-top: 30px' value='关闭'>
</div> -->
<script type="text/javascript" src="<?php echo (ADMIN_URL); ?>/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
function showbg() {
    $('#background').show();
    var credits = "<?php echo ($user_info['credits']); ?>";
    html = "<form action='" + "<?php echo U('Center/tomoney');?>" + "' method='post' id='form-product'><div class='moneylist' style='margin-top: 33%;'><p style='line-height:30px'>可用积分：" + credits + "</p>提现积分：<input type='text' name='number' style='width: 34%;border: 0px;border-bottom: 1px solid #ccc;' id='credits' onkeyup='chanmoney(this.value)'></div><div class='moneylist'>折算金额：<span class='count_con' id='money_con'></span></div><div class='moneysub'><input type='button' value='提交审核' onclick='appmon()' class='sub center_sub'></div><div style='width: 100%;text-align: center;'><input type='button' onclick='disbg()' class='goback' style='width: 39px;background-color: #981306;margin: auto;color: #fff;border: 0px;height: 23px;float: none;margin-top: 30px' value='关闭'></div></form>";
    $('#moneyshow').html(html);
    $('#moneyshow').show();
}
$(document).ready(function() {
    var ordernum = "<?php echo ($num); ?>";
    if (ordernum > 0) {
        alert('您有' + ordernum + '条订单尚未处理，请及时处理');
    }
    var thenew = '<?php echo ($new); ?>';
    if (thenew != '') {
        var jsonobj = eval('(' + thenew + ')');
        $("body").addClass('hidden_body');
        for (var i = 0; i < jsonobj.length; i++) {
            $('#background').show();
            html = "<div style='padding: 10px;font-size: 12px;'><p style='font-size: 14px;color: #000;'>" + jsonobj[i].tittle + "</p><p>" + jsonobj[i].content + "</p><div style='text-align:center'><form action='" + "<?php echo U('Mycenter/reform');?>" + "' method='post' id='form-reform'><input type='text' name='new_id' style='display:none' value='" + jsonobj[i].id + "'/><textarea placeholder='请输入交流内容' name='content' id='recontent' style='width:80%;margin:auto;height:50px;'></textarea></div></div><div><input type='button' class='reform reform_submit' style='float:left' value='交流'><input type='button' onclick='disbg()' class='goback' style='float:left' value='关闭'></form></div>";
            $('#moneyshow').html(html);
            $('#moneyshow').show();
        }
    }
})

function disbg() {
    $('#background').hide();
    $('#moneyshow').hide();
}

function lookjf() {
    $('#background').show();
    html = "<div style='padding: 10px;font-size: 12px;'><p style='font-size: 14px;color: #000;'>如何赚积分：</p><p>1、天天签到积分赚不停；</p><p>2、分享我们产品给有需要的朋友兄弟姐妹；</p><p>3、分享图文到微信朋友圈赚积分（自愿为原则）！</p><p>签到积分规则：</p><p>每天只计一次，首次签到送100积分，第一天10积分，第二天20积...第五天50积分，第六，七，八...天每天50积分，若中间停签到则又算第一天开始计签到积分。</p><div style='width: 100%;text-align: center;'><input type='button' onclick='disbg()' class='goback' style='width: 39px;background-color: #981306;margin: auto;color: #fff;border: 0px;height: 23px;float: none;margin-top: 30px' value='关闭'></div></div>";
    $('#moneyshow').html(html);
    $('#moneyshow').show();
}

function lookjl() {
    $('#background').show();
    html = "<div style='padding: 10px;font-size: 12px;'><p style='font-size: 14px;color: #000;'>分销合作奖励制度：</p>分销合作奖励制度：<p>签订分销合作合同<p/><p>需一次性订货金额满5000元+，成为分销商，公司一次性鼓励金奖你1500元同型号货品，<p/><p>需一次性订货金额满10000元+，成为分销商，公司一次性鼓励金奖你5000元同型号货品，<p/><p>年销售额≥50000元，公司奖励2%<p/><p>年销售额≥100000元，公司奖励3%<p/><p>年销售额≥200000元，公司奖励5%<p/><p>广告、宣传物料支持<p/><p>销售政策全城联动<p/></br><p style='font-size: 14px;color: #000;'>代销合作制度：<p/><p>签订代销合作合同<p/><p>广告、宣传物料支持<p/><p>有申请分销资格<p/><p>销售政策全城联动<p/><div style='width: 100%;text-align: center;'><input type='button' onclick='disbg()' class='goback' style='width: 39px;background-color: #981306;margin: auto;color: #fff;border: 0px;height: 23px;float: none;margin-top: 30px' value='关闭'></div></div>";
    $('#moneyshow').html(html);
    $('#moneyshow').show();
}

function chanmoney(mon) {
    var txt = (mon * 0.01).toFixed(2);
    var credits = $('#credits').val();
    if (credits == '') {
        alert('提现积分不能为空');
        return;
    }
    $('#money_con').html(txt);
}

function appmon() {
    // alert('12323');
    var credits = $('#credits').val();
    if (credits == '') {
        alert('提现积分不能为空');
        return;
    }
    if (!(checkNumber(credits))) {
        alert('提现积分必须为数字');
        return;
    };
    $('#form-product').submit();
}
$(function() {
    $(".reform_submit").click(function() {
        var recontent = $('#recontent').val();
        if (recontent == '') {
            alert('请填写回复内容');
            return;
        }
        $('#form-reform').submit();
    })
})

function checkNumber(theObj) {
    var reg = /^[0-9]+.?[0-9]*$/;
    if (reg.test(theObj)) {
        return true;
    }
    return false;
}
</script>