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
<div class="index_con" style="background-image: url('<?php echo (HOME_IMG_URL); ?>/login.png');background-repeat: no-repeat;background-size: 100% 100%;">

    <div class="head">
    <div style="position: fixed;top: 0px">
    <!-- <a href="<?php echo U('Login/outlogin');?>" style="line-height: 35px;font-size: 14px;margin-left: 9px;color: #fff;float: left;width: 100%;background-color: #139332;border-radius: 6px;font-size: 13px;margin-top: 3px;line-height: 25px;height: 26px; color: #fff;text-align: center;vertical-align: middle;font-family: Microsoft YaHei;width: 62px;">切换账号</a> -->
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
<!-- <div class="index_con" style="background-image: url('<?php echo (HOME_IMG_URL); ?>/login.png');background-repeat: no-repeat;background-size: 100% 100%;"> -->
<?php if(!is_mobile()):?>
<div style="width: 30%;margin: auto;border: 1px solid #ccc;margin-top: 10%;">
<?php endif?>
    <p style="font-size: 23px;text-align: center;width: 100%;position: absolute;right: 0px;color: #000;line-height: 80px;">金聚云ZY2.02营销管理系统</p>
<div class="img_head" style="background-color: transparent;">
    <div class="mycenter_head" style="background-color: #fff;margin-top: 17%;">
        <img src="<?php echo (HOME_IMG_URL); ?>/logo.jpg" style="width: 100%;height: 100%;border-radius: 100px;">
    </div>
    <p style="font-size: 17px;color: #000;">状元科技</p>
</div>
    <form action="<?php echo U('Login/dologin');?>" method="post" id="form-product">
        <div class="index_list" style="height: auto;margin-top: 15px"><i class="fa fa-mobile index-user" style="font-size: 27px"> </i>
            <input type="text" name="iphone" id="iphone" class="index-input" placeholder="请填写手机号码（必填）" style="background:transparent;border: 0px;color: #fff;font-size: 16px">
        </div>
        <div class="index_list" style="height: auto;margin-top: 15px"><i class="fa fa-circle-o-notch index-user" style="font-size: 16px"> </i>
            <input type="password" name="password" id="password" class="index-input" placeholder="请输入密码" style="background:transparent;border: 0px;color: #fff">
        </div>
        <p style="width: 86%;margin: auto;"> <a href="<?php echo U('Index/index');?>" style="text-align: left;display: block;width: 50%;float: left;color: #fff"><span >我要注册</span></a><span style="width: 50%;display: block;color: #fff;float: right;text-align: right;" onclick="alert('请按右上角“一键拔号”联系客服重置密码或发短信“重置密码+账号（即手机号）”到18923006442。')">忘记密码？</span></p>
        <?php if(is_weixin()):?>
        <div style="    width: 86%;
    margin: auto;color:#000">
            <input type="checkbox" name="iswei" checked="checked">是否关联微信
        </div>
        <?php endif?>
        <div class="index-sub">
            <input type="button" class="index-submit" value="登录">
        </div>
    </form>
</div>
<?php if(!is_mobile()):?>
</div>
<?php endif?>
</body>
<script type="text/javascript" src="<?php echo (ADMIN_URL); ?>/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    $(".index-submit").click(function() {
        var iphone = $('#iphone');
        var password = $('#password').val();
        if (iphone.value == '') {
            alert('手机号码不能为空');
            return;
        }
                var myreg = /^1[3|5|7|8|][0-9]{8}[0-9]$/;
        if (!myreg.test($("#iphone").val())) {
            alert('请输入有效的手机号码！');
            return false;
        }
        if (password == '') {
            alert('请输入密码！');
            return false;
        }
        $('#form-product').submit();
    })
})
</script>

</html>