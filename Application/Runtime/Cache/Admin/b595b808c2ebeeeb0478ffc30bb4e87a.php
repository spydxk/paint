<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:16:41 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>金聚云ZY2.02营销管理系统</title>

    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/animate.min.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle" ></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element" style="text-align: center;">
                            <span><img alt="image" class="img-circle" src="/Public/admin/img/head.png" style="width: 45px;background: #fff;margin-top: 5px" ></span>
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold"><?php echo ($auserinfo['mg_name']); ?></strong></span>
                                <span class="text-muted text-xs block"><?php echo ($auserinfo['role_name']); ?></span>
                                </span>
                        </div>
                        <div class="logo-element">H+
                        </div>
                    </li>
                    <?php foreach ($da_con1 as $k=>$v ):?>


                    <li>
                        <a href="#">
                            <i class="fa <?php echo ($v['auth_pic']); ?>" style="width: 15px"> </i>
                            <span class="nav-label"><?php echo ($v['auth_name']); ?></span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                         <?php foreach ($da_con2 as $kt =>$vt):?>
          <?php if($vt['auth_pid'] == $v['auth_id']):?>  
                            <li>
                                <a class="J_menuItem" href="<?php echo U($vt['auth_c'].'/'.$vt['auth_a']);?>" data-index="0"><?php echo ($vt['auth_name']); ?></a>
                            </li>
                             <?php endif;?>
          <?php endforeach;?>
                          
                        </ul>

                    </li>
                 
          <?php endforeach;?>

                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1" >
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;background: #fff">
                    <div class="navbar-header" style="background: #fff"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#" style="float: left;"><i class="fa fa-bars"></i> </a>
                    <p style="height: 45px;font-size: 20px;margin-left: 11px;vertical-align: middle;margin-top: 10px;float: left;">欢迎登录后台管理系统</p>
                    </div>
                </nav>
            </div>
            <div class="row content-tabs">
                <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="J_menuTab active" data-id="<?php echo U('Index/mydesktop');?>">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                    </button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="J_tabShowActive"><a>定位当前选项卡</a>
                        </li>
                        <li class="divider"></li>
                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                        </li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                        </li>
                    </ul>
                </div>
                <a href="<?php echo U('Usermanage/doLoginout');?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
            </div>
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php echo U('Index/mydesktop');?>" frameborder="0" data-id="<?php echo U('Index/mydesktop');?>" seamless></iframe>
            </div>
            <div class="footer">
                <div class="pull-right">&copy; <a href="#" target="_blank"><?php echo ($auserinfo['username']); ?></a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
        <!--右侧边栏开始-->
        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active">
                        <a data-toggle="tab" href="#tab-1">
                            <i class="fa fa-gear"></i> 主题
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> 主题设置</h3>
                            <small><i class="fa fa-tim"></i> 你可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small>
                        </div>
                        <div class="skin-setttings">
                            <div class="title">主题设置</div>
                            <div class="setings-item">
                                <span>收起左侧菜单</span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                        <label class="onoffswitch-label" for="collapsemenu">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>固定顶部</span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                        <label class="onoffswitch-label" for="fixednavbar">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>
                        固定宽度
                    </span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                        <label class="onoffswitch-label" for="boxedlayout">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="title">皮肤选择</div>
                            <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                         <a href="#" class="s-skin-0">
                             默认皮肤
                         </a>
                    </span>
                            </div>
                            <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-1">
                            蓝色主题
                        </a>
                    </span>
                            </div>
                            <div class="setings-item yellow-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-3">
                            黄色/紫色主题
                        </a>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="<?php echo (ADMIN_JS_URL); ?>/jquery.min.js?v=2.1.4"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>/bootstrap.min.js?v=3.3.6"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>/plugins/layer/layer.min.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>/hplus.min.js?v=4.1.0"></script>
    <script type="text/javascript" src="<?php echo (ADMIN_JS_URL); ?>/contabs.min.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>/plugins/pace/pace.min.js"></script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:17:11 GMT -->
</html>