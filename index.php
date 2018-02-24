<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
// 定义应用目录
define('APP_PATH','./Application/');
// define('ROOT_PATH',__DIR__);
define('ROOT', substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')).'/');
// 定义后台样式
define('ADMIN_CSS_URL', ROOT.'Public/admin/css'); //css
define('ADMIN_JS_URL', ROOT.'Public/admin/js'); //js
define('ADMIN_IMG_URL', ROOT.'Public/admin/img'); //img

define('ADMIN_URL', ROOT.'Public/admin'); //img
define('HOME_CSS_URL', ROOT.'Public/home/css'); //css
define('HOME_JS_URL', ROOT.'Public/home/js'); //js
define('HOME_IMG_URL', ROOT.'Public/home/images'); //img
define('HOME_URL', ROOT.'Public/home'); //img
define('UP_URL', ROOT.'Public/Uploads'); //Uploads
define('BIND_MODULE','Home');
// 引入ThinkPHP入口文件
define('SHOW_PAGE_TRACE',true);
require './ThinkPHP/ThinkPHP.php';