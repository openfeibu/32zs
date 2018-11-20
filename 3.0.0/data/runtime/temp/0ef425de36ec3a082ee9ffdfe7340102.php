<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:63:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/admin/profile.html";i:1524555978;s:61:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/base.html";i:1526927309;s:63:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/header.html";i:1527162833;s:65:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/left_nav.html";i:1524749285;s:65:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/head_nav.html";i:1524746093;s:63:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/footer.html";i:1525328647;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>三二分段招生管理系统</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="Bookmark" href="__ROOT__/favicon.ico" >
    <link rel="Shortcut Icon" href="__ROOT__/favicon.ico" />
	<!-- bootstrap & fontawesome必须的css -->
	<link rel="stylesheet" href="__PUBLIC__/ace/css/bootstrap.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/datePicker/bootstrap-datepicker.css" />
	<link rel="stylesheet" href="__PUBLIC__/datetimepicker/bootstrap-datetimepicker.css" />
	<!-- 此页插件css -->

	<!-- ace的css -->
	<link rel="stylesheet" href="__PUBLIC__/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />


	<!-- IE版本小于9的ace的css -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" href="__PUBLIC__/ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
	<![endif]-->

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="__PUBLIC__/ace/css/ace-ie.css" />
	<![endif]-->

	<link rel="stylesheet" href="__PUBLIC__/yfcmf/yfcmf.css?20180522" />
	<!-- 此页相关css -->

	<!-- ace设置处理的js -->
	<script src="__PUBLIC__/ace/js/ace-extra.js"></script>
	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="__PUBLIC__/others/html5shiv.min.js"></script>
	<script src="__PUBLIC__/others/respond.min.js"></script>
	<![endif]-->
    <!-- 引入基本的js -->
    <script type="text/javascript">
        var admin_ueditor_handle = "<?php echo url('admin/Ueditor/upload'); ?>";
        var admin_ueditor_lang ='zh-cn';
    </script>
    <!--[if !IE]> -->
    <script src="__PUBLIC__/others/jquery.min-2.2.1.js"></script>
    <!-- <![endif]-->
    <!-- 如果为IE,则引入jq1.12.1 -->
    <!--[if IE]>
    <script src="__PUBLIC__/others/jquery.min-1.12.1.js"></script>
    <![endif]-->
	<!-- 通用css/JS/后增加 -->
	<link rel="stylesheet" href="__PUBLIC__/common/css/common.css?v=201805241"/>
	<script src="__PUBLIC__/common/js/common.js"></script>
    <!-- 如果为触屏,则引入jquery.mobile -->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='__PUBLIC__/others/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="__PUBLIC__/others/bootstrap.min.js"></script>

	<style>
	.table-hover > tbody > tr:hover > td,
	.table-hover > tbody > tr:hover > th {
	  background-color: #ccccef;
	}
	</style>
</head>

<body class="no-skin">
<!-- 导航栏开始 -->
<div id="navbar" class="navbar navbar-default navbar-fixed-top printHide">
	<div class="navbar-container" id="navbar-container">
		<!-- 导航左侧按钮手机样式开始 -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button><!-- 导航左侧按钮手机样式结束 -->
		<button data-target="#sidebar2" data-toggle="collapse" type="button" class="pull-left navbar-toggle collapsed">
			<span class="sr-only">Toggle sidebar</span>
			<i class="ace-icon fa fa-dashboard white bigger-125"></i>
		</button>
		<!-- 导航左侧正常样式开始 -->
		<div class="navbar-header pull-left">
			<!-- logo -->
			<a href="<?php echo url('admin/Index/index'); ?>" class="navbar-brand" title="管理后台首页">
					<i ><img src="__PUBLIC__/img/login-logo.png" alt="" style="width: 50px;height: 50px;"></i>
					<p >
						<span>广东农工商职业技术学院</span><br/>
						三二分段招生管理系统
					</p>
			</a>
			<span class="admin_title_span"><?php echo $admin['title']; ?> <?php echo $head_title; ?></span>
		</div><!-- 导航左侧正常样式结束 -->

		<!-- 导航栏开始 -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey">
					<a href="<?php echo url('home/Index/index'); ?>" target="_blank" class="fb-transition">
						打开首页
					</a>
				</li>
				<?php if($admin['id'] == 1 || $admin['id'] == 5): ?>
				<li class="purple">
					<a data-info="确定要清除缓存吗？" class="confirm-rst-btn fb-transition" href="<?php echo url('admin/Sys/clear'); ?>">
						清除缓存
					</a>
				</li>
				<?php endif; ?>
				<li class="logOut">
					<a class="confirm-btn fb-transition" href="<?php echo url('admin/Login/logout'); ?>"  data-info="确定要退出系统吗？" >
						退出系统
					</a>
				</li>
				<!-- 用户菜单开始 -->
				<li class="light-blue dropdown-modal">
					<a  href="<?php echo url('admin/Admin/profile'); ?>" class="dropdown-toggle fb-adminInfo">

						<span class="user-info">
							<?php echo session('admin_auth.admin_username'); ?>
						</span>
						<img class="nav-user-photo" src="<?php echo get_imgurl($admin_avatar,2); ?>" alt="<?php echo session('admin_auth.admin_username'); ?>" />

						<!-- <i class="ace-icon fa fa-angle-down"></i> -->
					</a>
<!--
					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo url('admin/Admin/profile'); ?>">
								<i class="ace-icon fa fa-user"></i>
								个人中心
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="<?php echo url('admin/Login/logout'); ?>"  data-info="确定要退出吗？" class="confirm-btn">
								<i class="ace-icon fa fa-power-off"></i>
								注销
							</a>
						</li>
					</ul> -->
				</li><!-- 用户菜单结束 -->
			</ul>
		</div><!-- 导航栏结束 -->
	</div><!-- 导航栏容器结束 -->
</div><!-- 导航栏结束 -->


<!-- 整个页面内容开始 -->
<div class="main-container" id="main-container">
	<!-- 菜单栏开始 -->
	<div id="sidebar" class="sidebar responsive sidebar-fixed ace-save-state printHide">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>
	<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">

		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"><i class="ace-icon fa fa-signal"></i></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"><i class="ace-icon fa fa-pencil"></i></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="考生列表"><i class="ace-icon fa fa-users"></i></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="考生列表"></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"></a>
		</div>
	</div> -->
	<!-- 菜单列表开始 -->
	<ul class="nav nav-list">
		<!--一级菜单遍历开始-->
		<?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$v): if(!empty($v['_child'])): ?>
				<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>open<?php endif; ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<i class="menu-icon fa <?php echo $v['css']; ?>"></i>
				<span class="menu-text"><?php echo $v['title']; ?></span>
				<b class="arrow fa fa-angle-down"></b>
			</a>
			<ul class="submenu">
				<!--二级菜单遍历开始-->
				<?php if(is_array($v['_child']) || $v['_child'] instanceof \think\Collection || $v['_child'] instanceof \think\Paginator): if( count($v['_child'])==0 ) : echo "" ;else: foreach($v['_child'] as $key=>$vv): if(!empty($vv['_child'])): ?>
						<li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active open<?php endif; ?>">
					<a href="javascript:void(0);" class="dropdown-toggle">
						<!-- <i class="menu-icon fa <?php if($v['css']): ?><?php echo $v['css']; else: ?>fa-caret-right<?php endif; ?>"></i> -->
						<?php echo $vv['title']; ?>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<!--三级菜单遍历开始-->
						<?php if(is_array($vv['_child']) || $vv['_child'] instanceof \think\Collection || $vv['_child'] instanceof \think\Paginator): if( count($vv['_child'])==0 ) : echo "" ;else: foreach($vv['_child'] as $key=>$vvv): ?>
							<li class="<?php if((count($menus_curr) >= 3) AND ($menus_curr[2] == $vvv['id'])): ?>active<?php endif; ?>">
							<a href="<?php echo url($vvv['name']); ?>">
								<!-- <i class="menu-icon fa <?php if($v['css']): ?><?php echo $v['css']; else: ?>fa-caret-right<?php endif; ?>"></i> -->
								<?php echo $vvv['title']; ?>
							</a>
							<b class="arrow"></b>
							</li>
						<?php endforeach; endif; else: echo "" ;endif; ?><!--三级菜单遍历结束-->
					</ul>
					</li>
					<?php else: ?>
					<li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active<?php endif; ?>">
					<a href="<?php echo url($vv['name']); ?>">
						<!-- <i class="menu-icon fa <?php if($v['css']): ?><?php echo $v['css']; else: ?>fa-caret-right<?php endif; ?>"></i> -->
						<?php echo $vv['title']; ?>
					</a>
					<b class="arrow"></b>
					</li>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?><!--二级菜单遍历结束-->
			</ul>
			</li>
			<?php else: ?>
			<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">
			<a href="<?php echo url($v['name']); ?>">
				<i class="menu-icon fa <?php if($v['css']): ?><?php echo $v['css']; else: ?>fa-caret-right<?php endif; ?>"></i>
				<?php echo $v['title']; ?>
			</a>
			<b class="arrow"></b>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?><!--一级菜单遍历结束-->
	</ul><!-- 菜单列表结束 -->
</div>

	<!-- 菜单栏结束 -->

	<!-- 主要内容开始 -->
	<div class="main-content">
		<div class="main-content-inner">
			<!-- 右侧主要内容页顶部标题栏开始 -->
			<!-- <div id="sidebar2" class="sidebar h-sidebar navbar-collapse  breadcrumbs-fixed printHide" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
	<div class="nav-wrap-up pos-rel">
		<div class="nav-wrap">
			<ul class="nav nav-list">
				<?php if(($id_curr != '') AND (!empty($menus_child))): if(is_array($menus_child) || $menus_child instanceof \think\Collection || $menus_child instanceof \think\Paginator): if( count($menus_child)==0 ) : echo "" ;else: foreach($menus_child as $key=>$k): ?>
				<li class="<?php if($id_curr == $k['id']): ?>fb-active<?php endif; ?>">
					<a href="<?php echo url(''.$k['name'].''); ?>">
					<o class="font12 "><?php echo $k['title']; ?></o>
					</a>
					<b class="arrow"></b>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; else: ?>
				<li>
					<a href="<?php echo url('admin/Index/index'); ?>">
						<o class="font12">欢迎使用三二分段招生管理系统</o>
					</a>
					<b class="arrow"></b>
				</li>
				<?php endif; ?>
			</ul>
		</div>
	</div><!-- /.nav-list 
</div>
 -->
			<!-- 右侧主要内容页顶部标题栏结束 -->
			<!-- 右侧下主要内容开始 -->
			
            <div class="page-content">
                <!--主题-->
                <div class="page-header">
                    <span>个人中心</span>
                </div>
                <div>
                    <div id="user-profile-1" class="user-profile row">
                        <div class="col-xs-12 col-sm-3 center">
                            <div>
                                <!-- #section:pages/profile.picture -->
								<span class="profile-picture">
									<a href="#">
                                        <img id="avatar" class="editable" src="<?php echo get_imgurl($admin['admin_avatar'],1); ?>" width="150"  data-toggle="modal" data-target="#myModal" />
                                    </a>
								</span>

                                <!-- /section:pages/profile.picture -->
                                <div class="space-4"></div>
                                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                    <div class="inline position-relative">
                                        <a  class="user-title-label" >
                                            <i class="ace-icon fa fa-circle light-green"></i>
                                            &nbsp;
                                            <span class="white"><?php echo $admin['title']; ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                          <div class="profile-contact-info">
                                <div class="profile-contact-links align-center">
                                    <span id="edit" class="btn btn-link" data-toggle="modal" data-target="#myModaledit">
                                        修改密码
                                    </span>
                                </div>
                                <div class="space-6"></div>
                            </div>

                            <!-- #section:pages/profile.contact -->


                        </div>

                        <div class="col-xs-12 col-sm-9">


                            <!-- #section:pages/profile.info -->
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 用户名 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="username"><?php echo $admin['admin_username']; ?></span>													</div>
                                </div>

                                <!-- <div class="profile-info-row">
                                    <div class="profile-info-name"> 联系电话 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="tel"><?php echo (isset($admin['admin_tel']) && ($admin['admin_tel'] !== '')?$admin['admin_tel']:'未设置'); ?></span>													</div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 真实姓名 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="realname"><?php echo (isset($admin['admin_realname']) && ($admin['admin_realname'] !== '')?$admin['admin_realname']:'未设置'); ?></span>													</div>
                                </div> -->

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 上次登录时间 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="lasttime"><?php if($admin['admin_last_time'] == ''): ?>未登陆过<?php else: ?><?php echo date("Y-m-d H:i:s",$admin['admin_last_time']); endif; ?></span>													</div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 上次登录IP </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="lastip"><?php if($admin['admin_ip'] == ''): ?>未登陆过<?php else: ?><?php echo $admin['admin_ip']; endif; ?></span>													</div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 本次登录IP </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="loginip"><?php echo $admin['admin_ip']; ?></span>													</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <link href="__PUBLIC__/shearphoto/css/ShearPhoto.css" rel="stylesheet" type="text/css" media="all">
                <script  type="text/javascript" src="__PUBLIC__/shearphoto/js/ShearPhoto.js" ></script>
                <script  type="text/javascript"  src="__PUBLIC__/shearphoto/js/alloyimage.js" ></script>
                <script  type="text/javascript"  src="__PUBLIC__/shearphoto/js/handle.js" ></script>
                <script type="text/javascript">
                    var SHEAR = {
                        PATH_RES: '__PUBLIC__',
                        PATH_AVATAR: '__ROOT__/data/upload/avatar',
                        URL:"<?php echo url('admin/Admin/avatar'); ?>",
                    };
                </script>

                <!-- 显示修改资料模态框（Modal） -->
                <div class="modal fade in" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <form class="form-horizontal ajaxForm2" name="admin_runedit" method="post" action="<?php echo url('admin/Admin/admin_runedit'); ?>">
                        <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>" />
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="gb"  data-dismiss="modal"
                                            aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel2">
                                        修改用户信息
                                    </h4>
                                </div>
                                <div class="modal-body">


                                    <div class="row">
                                        <div class="col-xs-12">


                                            <!--<div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 用户邮箱：  </label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="admin_email" id="admin_email" value="<?php echo $admin['admin_email']; ?>" class="col-xs-10 col-sm-5" required/>
                                                    <span class="lbl col-xs-12 col-sm-7"><span class="red">*</span>用于密码找回，请认真填写</span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div> -->
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 登录密码：  </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="admin_pwd" id="admin_pwd" maxlength="15" minlength="6" placeholder="为空不修改密码" class="col-xs-10 col-sm-5" />
                                                    <span class="lbl col-xs-12 col-sm-7"><span class="red">*</span>密码必须大于6位，小于15位</span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div>
                                            <!-- <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 手机号码：  </label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="admin_tel" id="admin_tel" value="<?php echo $admin['admin_tel']; ?>" class="col-xs-10 col-sm-5" required/>
                                                    <span class="lbl col-xs-12 col-sm-7"><span class="red">*</span>只能填写数字</span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 通用网名：  </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="admin_realname" id="admin_realname" value="<?php echo $admin['admin_realname']; ?>"  class="col-xs-10 col-sm-5" required/>
                                                    <span class="lbl col-xs-12 col-sm-7"><span class="red">*</span>用于发布信息所有人，且在前端显示</span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div> -->
                                            <!-- <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否审核： </label>
                                                <div class="col-sm-10" style="padding-top:5px;">
                                                    <input name="admin_open" id="admin_open" <?php if($admin['admin_open'] == 1): ?>checked<?php endif; ?>  value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
                                                    <span class="lbl">默认关闭</span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">
                                        提交保存
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        关闭
                                    </button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </form>
                </div><!-- /.modal -->
            </div>

			<!-- 右侧下主要内容结束 -->
		</div>
	</div><!-- 主要内容结束 -->
	<!-- 页脚开始 -->
	<div class="footer printHide">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<!-- <span class="blue bolder">三二分段</span> -->
				网络中心 &copy; 2017-<?php echo date('Y'); ?>
				<p>为了更好的体验，建议您使用谷歌、火狐、IE9及以上版本、360极速模式等高版本的浏览器！</p>
			</span>
		</div>
	</div>
</div>

	<!-- 页脚结束 -->
	<!-- 返回顶端开始 -->
	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
	<!-- 返回顶端结束 -->
</div><!-- 整个页面内结束 -->

<!-- ace的js,可以通过打包生成,避免引入文件数多 -->
<script src="__PUBLIC__/ace/js/ace.js"></script>
<script src="__PUBLIC__/ace/js/ace.min.js"></script>
<!-- jquery.form、layer、三二分段的js -->
<script src="__PUBLIC__/others/jquery.form.js"></script>
<script src="__PUBLIC__/others/maxlength.js"></script>
<script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
<script src="__PUBLIC__/datePicker/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/datetimepicker/bootstrap-datetimepicker.js"></script>
<script src="__PUBLIC__/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="__PUBLIC__/yfcmf/yfcmf.js?<?php echo time(); ?>"></script>
<script src="__PUBLIC__/laydate5/laydate.js"></script>
<!-- 此页相关插件js -->

<!-- 与此页相关的js -->
</body>
</html>