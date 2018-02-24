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
<div class="index_con" <?php if(!is_mobile()):?>style='width: 26%;margin: auto;' <?php endif?>>
    <form action="<?php echo U('Index/adduser');?>" method="post" id="form-product">
        <div class="index_list"><i class="fa fa-user index-user" style="font-size: 19px"> </i>
            <input type="text" name="name" id="name" class="index-input" placeholder="请填写姓名（必填）">
        </div>
        <div class="index_list"><i class="fa fa-mobile index-user" style="font-size: 27px"> </i>
            <input type="text" name="iphone" id="iphone" class="index-input" placeholder="请填写手机（必填）">
        </div>
        <div class="index_list"><i class="fa fa-circle-o-notch index-user" style="font-size: 16px"> </i>
            <input type="text" name="introducer" id="introducer" class="index-input" placeholder="请填写推荐人ID（选填）" value="<?php echo ($introducerpid); ?>">
        </div>
        <div class="index_list"><i class="fa fa-home index-user" style="font-size: 16px"> </i>
            <input type="text" name="address" id="address" class="index-input" placeholder="请填写地址（选填）">
        </div>
        <div class="index_list"><i class="fa fa-tasks index-user" style="font-size: 16px;float: left;"> </i>
            <div class="index_input">
                <select name="category" class="index_select" style="color: darkgrey" style="font-size: 16px">
                    <option value="<?php echo encoded(0)?>">请选择用户类别</option>
                    <option value="<?php echo encoded(1)?>">贵宾会员</option>
                    <option value="<?php echo encoded(2)?>">我要分销</option>
                    <option value="<?php echo encoded(3)?>">我要代销</option>
                </select><span style="color: darkgrey"> （必填）</span>
            </div>
        </div>
        <div class="index_list"><i class="fa fa-lock index-user" style="font-size: 27px"> </i>
            <input type="password" name="password" id="password" class="index-input" placeholder="请填写6-8位数字或字母的密码">
        </div>
        <div class="index_list"><i class="fa fa-unlock-alt index-user" style="font-size: 27px"> </i>
            <input type="password" name="repassword" id="repassword" class="index-input" placeholder="请再次填写密码">
        </div>
        <div style="text-align: right;margin-right: 27px;">
            <a href="<?php echo U('Login/login');?>">已有账号，我要登录</a>
        </div>
        <div class="index-sub">
            <input type="button" class="index-submit" value="提交">
        </div>
    </form>
</div>
</body>
<script type="text/javascript" src="<?php echo (ADMIN_URL); ?>/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    $(".index-submit").click(function() {
        var name = $('#name').val();
        var iphone = $('#iphone');
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        var index_select = $('.index_select').val();
        if (name == '') {
            alert('姓名不能为空');
            exit();
        } else if (iphone.value == '') {
            alert('手机号码不能为空');
            exit();
        }
        var myreg = /^1[3|4|5|7|8|][0-9]{8}[0-9]$/;
        var pattern = /^[\w-\.]{6,8}$/;
        if (!myreg.test($("#iphone").val())) {
            alert('请输入有效的手机号码！');
            exit();
        }
        if (!pattern.test($("#password").val())) {
            alert('请填写6-8位数字或字母的密码!');
            exit();
        }
        if (password != repassword) {
            alert('两次输入密码不一致，请重新填写!');
            exit();
        }
        if (index_select == 'aTowOw') {
            alert('请选择用户类别!');
            exit();
        }
        $('#form-product').submit();
    })
})
</script>

</html>