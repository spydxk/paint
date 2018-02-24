<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo (ADMIN_CSS_URL); ?>/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo (ADMIN_CSS_URL); ?>/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="<?php echo (ADMIN_CSS_URL); ?>/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo (ADMIN_CSS_URL); ?>/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
<link href="<?php echo (ADMIN_CSS_URL); ?>/animate.min.css" rel="stylesheet">
<link href="<?php echo (ADMIN_CSS_URL); ?>/style.min862f.css?v=4.1.0" rel="stylesheet">
<title>金聚云ZY2.02营销管理系统</title>
</head>
<style>
.loginWraper {
    position: absolute;
    width: 100%;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    z-index: 1;
    background: #3283AC url(<?php echo (ADMIN_IMG_URL); ?>/main_bg.jpg) no-repeat center;
    background-size: 100% 100%;
}
.loginBox {
    position: absolute;
    width: 617px;
    height: 330px;
    background: url(<?php echo (ADMIN_IMG_URL); ?>/admin-loginform-bg.png) no-repeat;
    left: 50%;
    top: 50%;
    margin-left: -309px;
    margin-top: -184px;
    padding-top: 38px;
}
</style>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"><p style="font-size: 18px;padding-left: 10px;color: #FFF;width: 100%;text-align: center;">金聚云ZY2.02营销管理系统</p>
<p style="font-size: 18px;padding-left: 10px;color: #FFF;width: 100%;text-align: center;">欢迎登陆</p>
</div>
<div class="loginWraper">
  <div id="loginform" class="loginBox" style="height: 410px">
    <form class="form form-horizontal" action="<?php echo U('Usermanage/doLogin');?>" method="post">
      <div class="row cl">
        <label class="form-label col-3"><i class="fa fa-user" style="font-size: 22px;line-height: 34px;"></i></label>
        <div class="formControls col-8">
            <?php if($_COOKIE['online']== '1'): ?><input id="" name="username" type="text" placeholder="请输入账户" value="<?php echo (cookie('username')); ?>" class="input-text size-L">
              <?php else: ?>
              <input id="" name="username" type="text" placeholder="请输入账户" value="" class="input-text size-L"><?php endif; ?>
          
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-3"><i class="fa fa-navicon" style="font-size: 22px;line-height: 34px;"></i></label>
        <div class="formControls col-8">
           <?php if($_COOKIE['online']== '1'): ?><input id="" name="password" type="password" placeholder="请输入密码" value="<?php echo (cookie('password')); ?>" class="input-text size-L">
              <?php else: ?>
              <input id="" name="password" type="password" placeholder="请输入密码" value="" class="input-text size-L"><?php endif; ?>
          
        </div>
      </div>
            <div class="row cl">
        <label class="form-label col-3"><i class="fa fa-indent" style="font-size: 22px;line-height: 34px;"></i></label>
        <div class="formControls col-8">
           <?php if($_COOKIE['online']== '1'): ?><input id="" name="captcha" type="text" placeholder="请输入验证码" value="<?php echo (cookie('captcha')); ?>" class="input-text size-L" style="width: 205px;float: left;">
              <?php else: ?>
              <input id="" name="captcha" type="text" placeholder="请输入验证码" value="" class="input-text size-L"  style="width: 205px;float: left;"><?php endif; ?>
             <img src="<?php echo U('Usermanage/img');?>" alt="" style="float: left;width: 140px;height: 40px;margin-left: 15px;" onclick="this.src=this.src+'#'+Math.random()"  />
        </div>
      </div>
      <div class="row">
        <div class="formControls col-8 col-offset-3">
          <label for="online">
          <?php if($_COOKIE['online']== '1'): ?><input type="checkbox" name="online" id="online" value="1" checked/>
              使我保持登录状态
            <?php else: ?>
              <input type="checkbox" name="online" id="online" value="1" />
              使我保持登录状态<?php endif; ?> 
          </label>
        </div>
      </div>
      <div class="row">
        <div class="formControls col-8 col-offset-3" style="text-align: center;">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>