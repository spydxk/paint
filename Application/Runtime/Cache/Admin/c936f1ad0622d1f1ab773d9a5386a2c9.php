<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<!-- Mirrored from www.zi-han.net/theme/hplus/index_v1.html?v=4.0 by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:20:20 GMT -->

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!--360浏览器优先以webkit内核解析-->
    <title>
        H+ 后台主题UI框架 - 主页示例
    </title>
<link href="<?php echo (ADMIN_CSS_URL); ?>/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo (ADMIN_CSS_URL); ?>/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo (ADMIN_URL); ?>/lib/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo (ADMIN_URL); ?>/lib/iconfont/iconfont.css" rel="stylesheet" type="text/css" />
</head>

<body class="gray-bg">
    <div class="row border-bottom white-bg dashboard-header">
        <table class="table table-border table-bg">
            <tr>
                <th>
                    管理员名称：
                </th>
                <td>
                    <?php echo ($user['mg_name']); ?>
                </td>
            </tr>
            <tr>
                <td>
                    角色：
                </td>
                <td>
                    <?php echo ($user['role_name']); ?>
                </td>
            </tr>
            <tr>
                <td>
                    账户登录IP：
                </td>
                <td>
                    <?php echo ($user['ip']); ?>
                </td>
            </tr>
            <tr>
                <td>
                    登陆时间：
                </td>
                <td>
                    <?php echo (date('Y-m-d H:i:s',$user['time'])); ?>
                </td>
            </tr>
            <tr>
                <td>
                    当前时间：
                </td>
                <td>
                    <span id="date"></span>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<script src="<?php echo (ADMIN_JS_URL); ?>/jquery.min.js?v=2.1.4">
</script>
<script src="<?php echo (ADMIN_JS_URL); ?>/date.js">
</script>
<!-- Mirrored from www.zi-han.net/theme/hplus/index_v1.html?v=4.0 by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:20:20 GMT -->