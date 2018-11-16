<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:69:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/menu/news_menu_edit.html";i:1524456538;s:61:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/base.html";i:1524107890;s:63:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/header.html";i:1524466687;s:65:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/left_nav.html";i:1524456538;s:65:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/head_nav.html";i:1524456538;s:63:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/footer.html";i:1524107890;}*/ ?>
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

	<link rel="stylesheet" href="__PUBLIC__/yfcmf/yfcmf.css" />
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
	<link rel="stylesheet" href="__PUBLIC__/common/css/common.css"/>
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
					<i ><img src="__PUBLIC__/img/girl.jpg" alt="" style="width: 50px;height: 50px;"></i>
					三二分段招生管理系统
			</a>
			<span class="admin_title_span"><?php echo $admin['title']; ?> <?php echo $head_title; ?></span>
		</div><!-- 导航左侧正常样式结束 -->

		<!-- 导航栏开始 -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey">
					<a href="<?php echo url('home/Index/index'); ?>" target="_blank" class="fb-transition">
						招生首页
					</a>
				</li>
				<?php if($admin['id'] == 1 || $admin['id'] == 5): ?>
				<li class="purple">
					<a data-info="确定要清理缓存吗？" class="confirm-rst-btn fb-transition" href="<?php echo url('admin/Sys/clear'); ?>">
						清除缓存
					</a>
				</li>
				<?php endif; ?>
				<li class="logOut">
					<a class="confirm-btn fb-transition" href="<?php echo url('admin/Login/logout'); ?>"  data-info="你确定要退出吗？" >
						注销
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
							<a href="<?php echo url('admin/Login/logout'); ?>"  data-info="你确定要退出吗？" class="confirm-btn">
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
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="学生列表"><i class="ace-icon fa fa-users"></i></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="学生列表"></a>
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
			<div id="sidebar2" class="sidebar h-sidebar navbar-collapse  breadcrumbs-fixed printHide" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
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
	</div><!-- /.nav-list -->
</div>

			<!-- 右侧主要内容页顶部标题栏结束 -->
			<!-- 右侧下主要内容开始 -->
			
	<div class="page-content">
		<!--主题-->
		<div class="page-header">
			<span>编辑菜单</span>
</div>
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal ajaxForm2" name="runnews_menuedit" method="post" action="<?php echo url('admin/Menu/news_menu_runedit'); ?>">
					<input type="hidden" name="id" value="<?php echo $menu['id']; ?>" />
					<input type="hidden" name="lang_list" value="<?php echo $menu['menu_l']; ?>" />
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 上级栏目： </label>
						<div class="col-sm-9">
							<select name="parentid"  id="parentid" class="col-sm-3 selector">
								<option value="">请选择所属栏目</option>
								<?php if(is_array($menu_text) || $menu_text instanceof \think\Collection || $menu_text instanceof \think\Paginator): if( count($menu_text)==0 ) : echo "" ;else: foreach($menu_text as $key=>$vo): ?>
								<option value="<?php echo $vo['id']; ?>" <?php if($vo['id'] == $menu['parentid']): ?> selected <?php endif; if($vo['menu_type'] == 1): ?> class="bgccc"<?php else: ?>class="bgc"<?php endif; ?>><?php echo $vo['lefthtml']; ?><?php echo $vo['menu_name']; ?>(<?php if($vo['menu_l'] == 'zh-cn'): ?>中<?php else: ?>英<?php endif; ?>) <?php if($vo['menu_type'] == 1): ?>(频道页)<?php endif; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 菜单名称： </label>
						<div class="col-sm-9">
							<input type="text" name="menu_name" id="menu_name" value="<?php echo $menu['menu_name']; ?>" class="col-xs-10 col-sm-5" />
                                            <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle" id="resone"></span>
											</span>
						</div>
					</div>

					<?php if(config('lang_switch_on')): ?>
					<div id="menu_l" class="form-group <?php if($menu['parentid'] != '0'): ?>none<?php endif; ?>">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 菜单所属语言： </label>
						<div class="col-sm-9">
							<select name="menu_l"  class="col-sm-3 selector" required>
								<option value="">请选择所属语言</option>
								<option value="zh-cn" <?php if($menu['menu_l'] == 'zh-cn'): ?>selected<?php endif; ?>>中文</option>
								<option value="en-us" <?php if($menu['menu_l'] == 'en-us'): ?>selected<?php endif; ?>>英语</option>
							</select>
						</div>
					</div>
					<?php endif; ?>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 英文菜单名称： </label>
						<div class="col-sm-9">
							<input type="text" name="menu_enname" id="menu_enname" value="<?php echo $menu['menu_enname']; ?>" placeholder="英文菜单名称"  class="col-xs-10 col-sm-5" />
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否开启： </label>
						<div class="col-sm-9" style="padding-top:5px;">
							<input name="menu_open" id="menu_open" <?php if($menu['menu_open'] == 1): ?>checked<?php endif; ?> value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
							<span class="lbl">&nbsp;&nbsp;默认关闭</span>
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 排序（从小到大）： </label>
						<div class="col-sm-9">
							<input type="text" name="listorder" id="menu_order" value="<?php echo $menu['listorder']; ?>" class="col-xs-10 col-sm-1" />
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 菜单类型： </label>
						<div class="col-sm-9">
							<div class="radio">
								<label>
									<input name="menu_type" type="radio" class="ace" id="type1" value="1" <?php if($menu['menu_type'] == 1): ?>checked<?php endif; ?>/>
									<span class="lbl"> 作为频道页，不可作为栏目发布文章</span>
								</label>
							</div>

							<div class="radio">
								<label>
									<input name="menu_type" id="type2" type="radio" class="ace" value="2" <?php if($menu['menu_type'] == 2): ?>checked<?php endif; ?>/>
									<span class="lbl"> 不直接发布内容，用于跳转页面</span>
								</label>
							</div>

							<div class="radio">
								<label>
									<input name="menu_type" id="type3" type="radio" class="ace" value="3" <?php if($menu['menu_type'] == 3): ?>checked<?php endif; ?>/>
									<span class="lbl"> 作为发布栏目，文章列表模式</span>
								</label>
							</div>

							<div class="radio">
								<label>
									<input name="menu_type" id="type4" type="radio" class="ace" value="4" <?php if($menu['menu_type'] == 4): ?>checked<?php endif; ?>/>
									<span class="lbl"> 单页面模式，例如企业简介</span>
								</label>
							</div>
						</div>
					</div>


					<div class="form-group" id="address">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 跳转地址： </label>
						<div class="col-sm-9">
							<input type="text" name="menu_address" id="menu_address"  value="<?php echo $menu['menu_address']; ?>"  class="col-xs-10 col-sm-7" />
                                            <span class="help-inline col-xs-12 col-sm-5">
												<span class="middle">正确格式：http:// 开头</span>
											</span>
						</div>
					</div>

					<div class="form-group" id="model">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 使用模型选择： </label>
						<div class="col-sm-9">
							<select name="menu_modelid"  class="col-sm-3 selector">
								<option value="0">请选择模型</option>
								<?php if(is_array($model) || $model instanceof \think\Collection || $model instanceof \think\Paginator): if( count($model)==0 ) : echo "" ;else: foreach($model as $key=>$vo): ?>
								<option value="<?php echo $vo['model_id']; ?>" <?php if($vo['model_id'] == $menu['menu_modelid']): ?>selected<?php endif; ?>><?php echo $vo['model_title']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group" id="listtpl">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 列表页(单页)模板选择： </label>
						<div class="col-sm-9">
							<select name="menu_listtpl"  class="col-sm-3 selector">
								<option value="">请选择模板</option>
								<?php if(is_array($tpls) || $tpls instanceof \think\Collection || $tpls instanceof \think\Paginator): if( count($tpls)==0 ) : echo "" ;else: foreach($tpls as $key=>$vo): ?>
									<option value="<?php echo $vo; ?>" <?php if($vo == $menu['menu_listtpl']): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>


					<div class="form-group" id="newstpl">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 单文章页模板选择： </label>
						<div class="col-sm-9">
							<select name="menu_newstpl"  class="col-sm-3 selector">
								<option value="">请选择模板</option>
								<?php if(is_array($tpls) || $tpls instanceof \think\Collection || $tpls instanceof \think\Paginator): if( count($tpls)==0 ) : echo "" ;else: foreach($tpls as $key=>$vo): ?>
									<option value="<?php echo $vo; ?>" <?php if($vo == $menu['menu_newstpl']): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>


					<div class="form-group" id="pic_list">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 缩略图： </label>
						<div class="col-sm-9">
							<input type="hidden" name="checkpic" id="checkpic" value="<?php echo $menu['menu_img']; ?>" />
							<input type="hidden" name="oldcheckpic" id="oldcheckpic" value="<?php echo $menu['menu_img']; ?>" />
							<a href="javascript:;" class="file" title="点击选择所要上传的图片">
								<input type="file" name="file0" id="file0" multiple="multiple"/>
								选择上传文件
							</a>
							&nbsp;&nbsp;<a href="javascript:;" onclick="return backpic('<?php echo get_imgurl($menu['menu_img']); ?>');" title="还原修改前的图片" class="file">
							撤销上传
							</a>

							<div><img src="<?php echo get_imgurl($menu['menu_img']); ?>" height="70" id="img0" ></div>
						</div>
					</div>


					<div class="form-group" id="menu_content">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 单页面内容：</label>
						<div class="col-sm-9">
							<script src="__PUBLIC__/ueditor/ueditor.config.js" type="text/javascript"></script>
							<script src="__PUBLIC__/ueditor/ueditor.all.js" type="text/javascript"></script>
							<textarea name="menu_content" rows="100%" style="width:100%" id="myEditor"><?php echo $menu['menu_content']; ?></textarea>
							<script type="text/javascript">
								var editor = new UE.ui.Editor();
								editor.render("myEditor");
							</script>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> SEO标题： </label>
						<div class="col-sm-9">
							<input type="text" id="menu_title" name="menu_seo_title" value="<?php echo $menu['menu_seo_title']; ?>"  placeholder="SEO标题"  class="col-xs-10 col-sm-5" />

						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> SEO关键字： </label>
						<div class="col-sm-9">
							<input type="text" id="menu_key" name="menu_seo_key" value="<?php echo $menu['menu_seo_key']; ?>"  placeholder="SEO关键字" class="col-xs-10 col-sm-5" />
                                            <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">每个关键字用英文 , 号隔开</span>
											</span>
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> SEO描述： </label>
						<div class="col-sm-9">
							<input type="text" id="menu_des" name="menu_seo_des"  value="<?php echo $menu['menu_seo_des']; ?>" placeholder="SEO描述"  class="col-xs-10 col-sm-10" />
						</div>
					</div>


					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-fb-blue fb-radio" type="submit">
								保存
							</button>

 
								
 
							 <button class="btn fb-radio btn-fb-orange" type="reset" onclick="window.history.go(-1);">
                                返回
                            </button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div><!-- /.page-content -->

			<!-- 右侧下主要内容结束 -->
		</div>
	</div><!-- 主要内容结束 -->
	<!-- 页脚开始 -->
	<div class="footer printHide">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<!-- <span class="blue bolder">三二分段</span> -->
				三二分段招生管理系统 &copy; 2015-<?php echo date('Y'); ?>
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
<!-- jquery.form、layer、yfcmf的js -->
<script src="__PUBLIC__/others/jquery.form.js"></script>
<script src="__PUBLIC__/others/maxlength.js"></script>
<script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
<script src="__PUBLIC__/datePicker/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/datetimepicker/bootstrap-datetimepicker.js"></script>
<script src="__PUBLIC__/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="__PUBLIC__/yfcmf/yfcmf.js?<?php echo time(); ?>"></script>
<!-- 此页相关插件js -->

    <script>
        checkType();
        function checkType(){
            var $type=$("input[name='menu_type'][checked]").val();
            if($type==2){
                $('#address').show();
                $('#menu_content,#pic_list,#listtpl,#newstpl,#model').hide();
            }else if($type==1){
                $('#address,#menu_content,#pic_list,#model').hide();
                $('#listtpl,#newstpl').show();
            }else if($type==3){
                $('#address,#menu_content,#pic_list').hide();
                $('#listtpl,#newstpl,#model').show();
            }else{
                $('#address,#newstpl,#model').hide();
                $('#menu_content,#listtpl,#pic_list').show();
            }
        }
        $('#type2').click(function(){
            $('#address').show();
            $("input[name='menu_type'][checked]").attr("checked",false);
            $('#type2').attr("checked",true);
            checkType();
        });
        $('#type1,#type3,#type4').click(function(){
            $('#address').hide();
            $("input[name='menu_type'][checked]").attr("checked",false);
            $(this).attr("checked",true);
            checkType();
        });
        //语言
        $('#parentid').change(function(){
            var $parentid=$(this).children('option:selected').val();
            if($parentid){
                $('#menu_l').hide();
            }else{
                $('#menu_l').show();
            }
        });
    </script>

<!-- 与此页相关的js -->
</body>
</html>
