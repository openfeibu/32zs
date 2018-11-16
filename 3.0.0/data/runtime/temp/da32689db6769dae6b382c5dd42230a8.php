<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/wechat\view\we\menu_list.html";i:1489327654;s:56:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\base.html";i:1489327654;s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\header.html";i:1494035501;s:60:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\left_nav.html";i:1494035501;s:60:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\head_nav.html";i:1494035501;s:63:"D:\UPUPW\htdocs\zs\1.1.0/app/wechat\view\we\ajax_menu_list.html";i:1489327654;s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\footer.html";i:1494035501;}*/ ?>
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
	<link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css" />
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
				<small>
					<i class="fa fa-leaf"></i>
					三二分段招生管理系统
				</small>
			</a>
			<span class="admin_title_span"><?php echo $admin['title']; ?> <?php echo $head_title; ?></span>
		</div><!-- 导航左侧正常样式结束 -->

		<!-- 导航栏开始 -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey">
					<a href="<?php echo url('home/Index/index'); ?>" target="_blank">
						前台首页
					</a>
				</li>
				<?php if($admin['id'] == 1 || $admin['id'] == 5): ?>
				<li class="purple">
					<a data-info="确定要清理缓存吗？" class="confirm-rst-btn" href="<?php echo url('admin/Sys/clear'); ?>">
						清除缓存
					</a>
				</li>
				<?php endif; ?>
				<!-- 用户菜单开始 -->
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?php echo get_imgurl($admin_avatar,2); ?>" alt="<?php echo session('admin_auth.admin_username'); ?>" />
								<span class="user-info">
									欢迎您,	<?php echo session('admin_auth.admin_username'); ?>
								</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

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
					</ul>
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
						<i class="menu-icon fa fa-caret-right"></i>
						<?php echo $vv['title']; ?>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<!--三级菜单遍历开始-->
						<?php if(is_array($vv['_child']) || $vv['_child'] instanceof \think\Collection || $vv['_child'] instanceof \think\Paginator): if( count($vv['_child'])==0 ) : echo "" ;else: foreach($vv['_child'] as $key=>$vvv): ?>
							<li class="<?php if((count($menus_curr) >= 3) AND ($menus_curr[2] == $vvv['id'])): ?>active<?php endif; ?>">
							<a href="<?php echo url($vvv['name']); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
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
						<i class="menu-icon fa fa-caret-right"></i>
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
				<i class="menu-icon fa fa-caret-right"></i>
				<?php echo $v['title']; ?>
			</a>
			<b class="arrow"></b>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?><!--一级菜单遍历结束-->
	</ul><!-- 菜单列表结束 -->

	<!-- 菜单栏缩进开始 -->
	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div><!-- 菜单栏缩进结束 -->
</div>

	<!-- 菜单栏结束 -->

	<!-- 主要内容开始 -->
	<div class="main-content">
		<div class="main-content-inner">
			<!-- 右侧主要内容页顶部标题栏开始 -->
			<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse breadcrumbs-fixed printHide" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
	<div class="nav-wrap-up pos-rel">
		<div class="nav-wrap">
			<ul class="nav nav-list">
				<?php if(($id_curr != '') AND (!empty($menus_child))): if(is_array($menus_child) || $menus_child instanceof \think\Collection || $menus_child instanceof \think\Paginator): if( count($menus_child)==0 ) : echo "" ;else: foreach($menus_child as $key=>$k): ?>
				<li>
					<a href="<?php echo url(''.$k['name'].''); ?>">
					<o class="font12 <?php if($id_curr == $k['id']): ?>rigbg<?php endif; ?>"><?php echo $k['title']; ?></o>
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
		<div class="row maintop">
			<div class="col-xs-12">
				<button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal">
					<i class="ace-icon fa fa-plus bigger-110"></i>
					添加自定义菜单
				</button>
				<a class="red rst-url-btn" href="<?php echo url('wechat/We/menu_make'); ?>">
					<button class="btn btn-xs btn-info">
						<i class="ace-icon fa fa-bolt bigger-110"></i>
						生成菜单
					</button>
				</a>
				<a class="red rst-url-btn" href="<?php echo url('wechat/We/menu_get'); ?>">
					<button class="btn btn-xs btn-info">
						<i class="ace-icon fa fa-refresh bigger-110"></i>
						同步菜单
					</button>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div>
					<form class="ajaxForm2" name="leftnav" method="post" action="<?php echo url('wechat/We/menu_order'); ?>" >
						<table id="dynamic-table" class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>排序</th>
								<th>ID</th>
								<th>菜单标题</th>
								<th>类型</th>
								<th>操作值</th>
								<th>开启状态</th>
								<th style="border-right:#CCC solid 1px;">操作</th>
							</tr>
							</thead>

							<tbody id="ajax-data">
								<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$v): ?>
	<tr>
		<td><input name="<?php echo $v['we_menu_id']; ?>" value="<?php echo $v['we_menu_order']; ?>" class="list_order center"/></td>
		<td><?php echo $v['we_menu_id']; ?></td>
		<td style=padding-left:<?php if($v['leftpin'] != 0): ?><?php echo $v['leftpin']; endif; ?>px; ><?php echo $v['lefthtml']; ?><?php echo $v['we_menu_name']; ?></span></td>
		<td><?php if($v['we_menu_type'] == 1): ?>URL菜单链接<?php else: ?>关键词回复菜单<?php endif; ?></td>
		<td><?php echo $v['we_menu_typeval']; ?></td>
		<td>
			<?php if($v['we_menu_open'] == 1): ?>
				<a class="red open-btn" href="<?php echo url('wechat/We/menu_state'); ?>" data-id="<?php echo $v['we_menu_id']; ?>" title="已开启">
					<div><button class="btn btn-minier btn-yellow">开启</button></div>
				</a>
				<?php else: ?>
				<a class="red open-btn" href="<?php echo url('wechat/We/menu_state'); ?>" data-id="<?php echo $v['we_menu_id']; ?>" title="已禁用">
					<div><button class="btn btn-minier btn-danger">禁用</button></div>
				</a>
			<?php endif; ?>
		</td>
		<td>
			<div class="hidden-sm hidden-xs action-buttons">
				<a class="green menuedit-btn" href="<?php echo url('wechat/We/menu_edit'); ?>" data-id="<?php echo $v['we_menu_id']; ?>" data-toggle="tooltip" title="修改">
					<i class="ace-icon fa fa-pencil bigger-130"></i>																</a>
				<a class="red confirm-rst-url-btn" href="<?php echo url('wechat/We/menu_del',array('we_menu_id'=>$v['we_menu_id'])); ?>" data-info="若存在子菜单，则子菜单将一起被删除，你确定要删除吗？" data-toggle="tooltip" title="删除">
					<i class="ace-icon fa fa-trash-o bigger-130"></i>																</a>
				<?php if($v['we_menu_leftid'] == 0): ?>
				<a class="blue" href="javascript:;" onclick="return add_we_menu(<?php echo $v['we_menu_id']; ?>);"  data-toggle="tooltip" title="添加子类">
					<i class="ace-icon fa fa-plus-circle bigger-130"></i>																</a>
				<?php endif; ?>
			</div>
			<div class="hidden-md hidden-lg">
				<div class="inline position-relative">
					<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
						<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
					</button>
					<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo url('wechat/We/menu_edit'); ?>" data-id="<?php echo $v['we_menu_id']; ?>" class="tooltip-success menuedit-btn" data-rel="tooltip" title="修改" data-original-title="修改">
										<span class="green">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</span>
							</a>
						</li>

						<li>
							<a href="<?php echo url('wechat/We/menu_del',array('we_menu_id'=>$v['we_menu_id'])); ?>"  data-info="若存在子菜单，则子菜单将一起被删除，你确定要删除吗？" class="tooltip-error confirm-rst-url-btn" data-rel="tooltip" title="删除" data-original-title="删除">
										<span class="red">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</span>
							</a>
						</li>
						<?php if($v['we_menu_leftid'] == 0): ?>
						<li>
							<a href="javascript:;" onclick="return add_we_menu(<?php echo $v['we_menu_id']; ?>);"  class="tooltip-success" data-rel="tooltip" title="添加子类" data-original-title="添加子类">
										<span class="green">
											<i class="ace-icon fa fa-plus-circle bigger-120"></i>
										</span>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
	<td colspan="10" align="left"><button  id="btnorder" class="btn btn-white btn-yellow btn-sm">排序</button></td>
</tr>

							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
		<!-- 显示模态框（Modal）-->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form class="form-horizontal ajaxForm2" name="we_menu_runadd" id="we_menu_runadd" method="post" action="<?php echo url('wechat/We/menu_runadd'); ?>">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
									aria-hidden="true">×
							</button>
							<h4 class="modal-title" id="myModalLabel">
								添加自定义菜单
							</h4>
						</div>
						<div class="modal-body">

							<div class="row">
								<div class="col-xs-12">

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 上级栏目： </label>
										<div class="col-sm-10">
											<select name="we_menu_leftid"  id="we_menu_leftid" class="col-sm-4 selector" required>
												<option value="0">顶级栏目</option>
												<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$v): ?>
												<option value="<?php echo $v['we_menu_id']; ?>"><?php echo $v['lefthtml']; ?><?php echo $v['we_menu_name']; ?></option>
												<?php endforeach; endif; else: echo "" ;endif; ?>
											</select>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 菜单名称：  </label>
										<div class="col-sm-10">
											<input type="text" name="we_menu_name" id="we_menu_name" placeholder="输入菜单名称" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 菜单类型： </label>
										<div class="col-sm-10">
											<select name="we_menu_type"  class="col-sm-4" required>
												<option value="1" selected>URL菜单链接</option>
												<option value="2">关键词回复菜单</option>
											</select>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> URL/操作值：  </label>
										<div class="col-sm-10">
											<input type="text" name="we_menu_typeval" id="we_menu_typeval" placeholder="如果url必须http://或https://开头" class="col-xs-10 col-sm-5" required/>
											<span class="lbl">&nbsp;&nbsp;<span class="red"></span>如果为url必须http://或https://开头</span>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 排序：  </label>
										<div class="col-sm-10">
											<input type="text" name="we_menu_order" id="we_menu_order" value="50" class="col-xs-10 col-sm-2" required/>
											<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>从小到大排序</span>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否开启： </label>
										<div class="col-sm-10" style="padding-top:5px;">
											<input name="we_menu_open" id="we_menu_open" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
											<span class="lbl">&nbsp;&nbsp;默认关闭</span>
										</div>
									</div>
									<div class="space-4"></div>

								</div>
							</div>
					</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">
								提交保存
							</button>
							<button class="btn btn-info" type="reset">
								重置
							</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">
								关闭
							</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</form>
		</div><!-- /.modal -->
		<!-- 修改自定义菜单模态框（Modal） -->
		<div class="modal fade in" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-backdrop fade in" id="gbbb" style="height: 100%;"></div>
			<form class="form-horizontal ajaxForm2" name="we_menu_runedit" id="we_menu_runedit" method="post" action="<?php echo url('wechat/We/menu_runedit'); ?>">
				<input type="hidden" name="we_menu_id" id="editwe_menu_id" value="" />
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" id="gb"  data-dismiss="modal"
									aria-hidden="true">×
							</button>
							<h4 class="modal-title" id="myModalLabel">
								修改菜单
							</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-12">

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 上级栏目： </label>
										<div class="col-sm-10">
											<select name="we_menu_leftid"  id="editwe_menu_leftid"  class="col-sm-4 selector" required>
												<option value="0">顶级栏目</option>
												<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$v): ?>
												<option value="<?php echo $v['we_menu_id']; ?>"><?php echo $v['lefthtml']; ?><?php echo $v['we_menu_name']; ?></option>
												<?php endforeach; endif; else: echo "" ;endif; ?>
											</select>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 菜单名称：  </label>
										<div class="col-sm-10">
											<input type="text" name="we_menu_name" id="editwe_menu_name" placeholder="输入菜单名称" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 菜单类型： </label>
										<div class="col-sm-10">
											<select name="we_menu_type"  class="col-sm-4" id="editwe_menu_type" required>
												<option value="1" selected>URL菜单链接</option>
												<option value="2">关键词回复菜单</option>
											</select>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> URL/操作值：  </label>
										<div class="col-sm-10">
											<input type="text" name="we_menu_typeval" id="editwe_menu_typeval" placeholder="如果url必须http://或https://开头" class="col-xs-10 col-sm-5" required/>
											<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>如果为url必须http://或https://开头</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 排序：  </label>
										<div class="col-sm-10">
											<input type="text" name="we_menu_order" id="editwe_menu_order" value="50" class="col-xs-10 col-sm-2"  required/>
											<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>从小到大排序</span>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否开启： </label>
										<div class="col-sm-10" style="padding-top:5px;">
											<input name="we_menu_open" id="editwe_menu_open" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
											<span class="lbl">&nbsp;&nbsp;默认关闭</span>
										</div>
									</div>
									<div class="space-4"></div>

								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">
								提交保存
							</button>
							<button type="button" class="btn btn-default" id="gbb" >
								关闭
							</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</form>
		</div><!-- /.modal -->
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

<!-- 与此页相关的js -->
</body>
</html>
