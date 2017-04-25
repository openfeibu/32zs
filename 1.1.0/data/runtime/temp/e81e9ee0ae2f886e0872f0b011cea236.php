<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:72:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\member\member_edit.html";i:1493127066;s:65:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\public\base.html";i:1489327654;s:67:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\public\header.html";i:1493127171;s:69:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\public\left_nav.html";i:1492917079;s:69:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\public\head_nav.html";i:1492917366;s:67:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\public\footer.html";i:1492917366;}*/ ?>
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
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
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

				<li class="purple">
					<a data-info="确定要清理缓存吗？" class="confirm-rst-btn" href="<?php echo url('admin/Sys/clear'); ?>">
						清除缓存
					</a>
				</li>


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
	<div id="sidebar" class="sidebar responsive sidebar-fixed ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>
	<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">

		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"><i class="ace-icon fa fa-signal"></i></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"><i class="ace-icon fa fa-pencil"></i></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="会员列表"><i class="ace-icon fa fa-users"></i></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="会员列表"></a>
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
			<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse breadcrumbs-fixed" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
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
			
<style>
.personal_table{background: #fff;margin: 0 auto;width: 656px;}

.personal_table table input{width: 100%;height: 100%;border:none;outline:none;text-align: center;color: #666;}
.line-table-height{
    height:30px;
}
.line-table-height2{
    height: 90px;
}
.low_width_1{
    width:100px;
}
.low_width_2{
    width:110px;
}
.low_width_3{
    width:100px;
}
.low_width_4{
    width:110px;
}
.low_width_5{
    width:100px;
}
.low_width_6{
    width:100px;
}
.low_width_7{
    width:120px;
}
.title{
    text-align: center;
    font-weight: bold;
    font-size: 12px;
}
.content{
    text-align: center;
    font-family: 仿宋;
    font-size: 14px;
}
.content_area{
    text-align: left;
    font-family: 仿宋;
    font-size: 14px;
}

.k-s-content{
    border:1px solid #999;
    text-align: center;
}
.k-w-table {
    border-style:solid;
    border-color:rgb(148, 192, 210);
/*  border-color:#ccc; */
    border-width:1px;
    border-collapse:collapse;
}
</style>
	<div class="page-content">
		<!--主题-->
		<div class="page-header">
			<h1>
				您当前操作
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					修改中职学生信息
				</small>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal memberform" name="member_list_edit" method="post" action="<?php echo url('admin/Member/member_runedit'); ?>">
					<input type="hidden" name="member_list_id" id="member_list_id" value="<?php echo $member_list_edit['member_list_id']; ?>" />
					<!-- <div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 所属用户组： </label>
						<div class="col-sm-10">
							<select name="member_list_groupid"  class="col-sm-4 selector" required>
								<option value="">请选择所属用户组</option>
								<?php if(is_array($member_group) || $member_group instanceof \think\Collection || $member_group instanceof \think\Paginator): if( count($member_group)==0 ) : echo "" ;else: foreach($member_group as $key=>$v): ?>
									<option  value="<?php echo $v['member_group_id']; ?>" <?php if($member_list_edit['member_list_groupid'] == $v['member_group_id']): ?>selected<?php endif; ?>><?php echo $v['member_group_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="space-4"></div> -->

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 用户名：  </label>
						<div class="col-sm-10">
							<input type="text" name="member_list_username" id="member_list_username" value="<?php echo $member_list_edit['member_list_username']; ?>" placeholder="输入登录用户名" class="col-xs-10 col-sm-4" required/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填，用户名必须是以字母开头，数字、符号组合</span>
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 登入密码：  </label>
						<div class="col-sm-10">
							<input type="text" name="member_list_pwd" id="member_list_pwd" placeholder="输入登录密码" class="col-xs-10 col-sm-4" maxlength="15" minlength="5"/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填，密码必须大于6位，小于15位</span>
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 昵称：  </label>
						<div class="col-sm-10">
							<input type="text" name="member_list_nickname" id="member_list_nickname" value="<?php echo $member_list_edit['member_list_nickname']; ?>"  placeholder="输入昵称" class="col-xs-10 col-sm-4" />
						</div>
					</div>
					<div class="space-4"></div>
                    <?php if($admin['major_id']): ?>
                    <div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 所属中职专业: </label>
						<div class="col-sm-10">
							<select name="major_id"  class="col-sm-5" id="major" required>
								<?php if(is_array($major_list) || $major_list instanceof \think\Collection || $major_list instanceof \think\Paginator): if( count($major_list)==0 ) : echo "" ;else: foreach($major_list as $key=>$v): ?>
									<option value="<?php echo $v['major_id']; ?>" <?php if($v['major_id'] == $member_list_edit['major_id']): ?>selected<?php endif; ?> ><?php echo $v['major_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="space-4"></div>
                    <?php else: ?>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 所属中职: </label>
						<div class="col-sm-10">
							<select name="school_id"  class="col-sm-5" id="school" required>
								<option value="">请选择所属中职</option>
								<?php if(is_array($school_list) || $school_list instanceof \think\Collection || $school_list instanceof \think\Paginator): if( count($school_list)==0 ) : echo "" ;else: foreach($school_list as $key=>$v): ?>
									<option value="<?php echo $v['school_id']; ?>" <?php if($v['school_id'] == $member_list_edit['school_id']): ?>selected<?php endif; ?> ><?php echo $v['school_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="space-4"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 所属中职专业: </label>
						<div class="col-sm-10">
							<select name="major_id"  class="col-sm-5" id="major" required>
								<?php if(is_array($major_list) || $major_list instanceof \think\Collection || $major_list instanceof \think\Paginator): if( count($major_list)==0 ) : echo "" ;else: foreach($major_list as $key=>$v): ?>
									<option value="<?php echo $v['major_id']; ?>" <?php if($v['major_id'] == $member_list_edit['major_id']): ?>selected<?php endif; ?> ><?php echo $v['major_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="space-4"></div>
                    <?php endif; ?>
					<!-- <div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否开启（禁止后用户将不能登录）： </label>
						<div class="col-sm-10" style="padding-top:5px;">
							<input name="member_list_open" <?php if($member_list_edit['member_list_open'] == 1): ?>checked<?php endif; ?> id="member_list_open" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
							<span class="lbl">&nbsp;&nbsp;默认关闭</span>
						</div>
					</div>
					<div class="space-4"></div> -->

					<!-- <div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 审核： </label>
						<div class="col-sm-10" style="padding-top:5px;">
							<input name="user_status" <?php if($member_list_edit['user_status'] == 1): ?>checked<?php endif; ?> id="user_status" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
							<span class="lbl">&nbsp;&nbsp;默认未通过</span>
						</div>
					</div>
					<div class="space-4"></div>-->

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								保存
							</button>

							&nbsp; &nbsp; &nbsp;
							<button class="btn" type="reset" onclick="window.history.go(-1);" onclick="window.history.go(-1);">
								<i class="ace-icon fa fa-undo bigger-110"></i>
								返回
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php if($member_list_edit['user_status']): 		$auth=new app\admin\model\AuthRule;
		$id_curr=$auth->get_url_id();
        if($auth->check_auth($id_curr))
		{
		?>
		<!-- <div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal" name="score_edit" method="post" action="<?php echo url('admin/Score/score_runedit'); ?>">
					<?php if(is_array($major_score) || $major_score instanceof \think\Collection || $major_score instanceof \think\Paginator): if( count($major_score)==0 ) : echo "" ;else: foreach($major_score as $key=>$v): ?>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <?php echo $v; ?>: </label>
						<div class="col-sm-10">
							<input type="text" name="score[]" value="" class="col-xs-10 col-sm-4" required/>
						</div>
					</div>
					<div class="space-4"></div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								保存
							</button>

							&nbsp; &nbsp; &nbsp;
							<button class="btn" type="reset" onclick="window.history.go(-1);">
								<i class="ace-icon fa fa-undo bigger-110"></i>
								返回
							</button>
						</div>
					</div>
				</form>
			</div>
		</div> -->
		<?php
		}
		endif; ?>
		<div class="row">
			<div class="col-xs-12">
			<div class="personal_table">
            <input type="hidden" name="member_list_id" value="<?php echo $member_list_edit['member_list_id']; ?>" />
			<table width="656px" class="k-w-table line_table">
				<tbody><tr class="line-table-height">
					<td class="k-s-content low_width_1 title" style="text-align: center;">姓&nbsp;&nbsp;名</td>
					<td class="k-s-content low_width_2 content"><input type="text" name="name" value="<?php echo $info['member_list_nickname']; ?>" disabled/></td>
					<td class="k-s-content low_width_3 title">性&nbsp;&nbsp;别</td>
					<td class="k-s-content low_width_4 content"><input type="text" name="sex" value="<?php echo $info['sex']; ?>" /></td>
					<td class="k-s-content low_width_5 title">高考考生号</td>
					<td class="k-s-content low_width_6 content"><input type="text" name="GexamineeNumber" value="<?php echo $info['GexamineeNumber']; ?>" /></td>
					<td class="k-s-content low_width_7" rowspan="5" style="text-align: center;position:relative">
						<img id="studentPicture_herf_show" style="width: 125px; height: 175px; display: inline;" src="<?php if($member_list_edit['member_list_headpic']): ?><?php echo $member_list_edit['member_list_headpic']; else: ?>/public/img/defaultGraph.jpg<?php endif; ?> " height="175px" width="125px">
						<input type="file" class="upload" value="" style="width:100%;height:100%;position:absolute;top:0;left:0;opacity:0;cursor:pointer;">
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content low_width_1 title">出生年月</td>
					<td class="k-s-content content"><input type="text" name="date" value="<?php echo $info['date']; ?>" /></td>
					<td class="k-s-content low_width_3 title">民&nbsp;&nbsp;族</td>
					<td class="k-s-content content"><input type="text" name="nation" value="<?php echo $info['nation']; ?>" /></td>
					<td class="k-s-content title">政治面貌</td>
					<td class="k-s-content content"><input type="text" name="politicalOutlook" value="<?php echo $info['politicalOutlook']; ?>" /></td>
				</tr>
				<tr class="line-table-height">
					 <td class="k-s-content title">证件类型</td>
					<td class="k-s-content content">
						<input type="text" name="documentType" value="<?php echo $info['documentType']; ?>" />
					</td>
					<td class="k-s-content low_width_1 title">身份证号</td>
					<td class="k-s-content content" colspan="3"><input type="text" name="cardId" value="<?php echo $info['member_list_username']; ?>" disabled/></td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content content title">户籍地</td>
					<td class="k-s-content content"><input type="text" name="domicile" value="<?php echo $info['domicile']; ?>" /></td>
					<td class="k-s-content low_width_1 title">所在专业</td>
					<td class="k-s-content content">
						<input type="text" name="nowProfessional" value="<?php echo $info['nowProfessional']; ?>" disabled/>
					</td>
					<td class="k-s-content low_width_3 title">所在学校</td>
					<td class="k-s-content content">
						<input type="text" name="school" value="<?php echo $info['school']; ?>"  disabled/>
					</td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content low_width_1 title">报考专业</td>
					<td class="k-s-content content" colspan="1">
						<input type="text" name="applyProfessional"  disabled/>
					</td>
					<td class="k-s-content title" colspan="1">中职考生号</td>
					<td class="k-s-content content">
					<input type="text" name="ZexamineeNumber" value="<?php echo $info['ZexamineeNumber']; ?>" />
					</td>
					 <td class="k-s-content title" colspan="1">考生类别</td>
					<td class="k-s-content content">
						<input type="text" name="candidateCategory" value="<?php echo $info['candidateCategory']; ?>" />
					</td>
				</tr>
				<!-- 第6行 -->
				<tr class="line-table-height">
					<td class="k-s-content low_width_1 title " colspan="2">接收邮寄通知书地址</td>
					<td class="k-s-content content" colspan="3">
						<input type="text" name="address" value="<?php echo $info['address']; ?>" />
					</td>
					<td class="k-s-content title">邮编</td>
					<td class="k-s-content content" colspan="1">
						<input type="text" name="zipCode" value="<?php echo $info['zipCode']; ?>" />
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content low_width_1 title"  colspan="2">收件人</td>
					<td class="k-s-content content" colspan="2">
						<input type="text" name="addressee" value="<?php echo $info['addressee']; ?>" />
					</td>
					<td class="k-s-content title" colspan="1">联系电话</td>
					<td class="k-s-content content" colspan="2">
						<input type="text" name="tell" value="<?php echo $info['tell']; ?>" />
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2">技能证书名称</td>
					<td class="k-s-content title" colspan="1">级别</td>
					<td class="k-s-content title" colspan="2">颁发单位</td>
					<td class="k-s-content title" colspan="2">获得时间</td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateName_0" value="<?php echo $info['certificate']['0']['certificateName']; ?>" /></td>
					<td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_0" value="<?php echo $info['certificate']['0']['certificateLevel']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateCompany_0" value="<?php echo $info['certificate']['0']['certificateCompany']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateDate_0" value="<?php echo $info['certificate']['0']['certificateDate']; ?>" /></td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateName_1" value="<?php echo $info['certificate']['1']['certificateName']; ?>" /></td>
					<td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_1" value="<?php echo $info['certificate']['1']['certificateLevel']; ?>"value="<?php echo $info['certificate']['0']['certificateName']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateCompany_1" value="<?php echo $info['certificate']['1']['certificateCompany']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateDate_1" value="<?php echo $info['certificate']['1']['certificateDate']; ?>" /></td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateName_2" value="<?php echo $info['certificate']['2']['certificateName']; ?>" /></td>
					<td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_2" value="<?php echo $info['certificate']['2']['certificateLevel']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateCompany_2" value="<?php echo $info['certificate']['2']['certificateCompany']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="certificateDate_2" value="<?php echo $info['certificate']['2']['certificateDate']; ?>" /></td>
				</tr>

				<tr class="line-table-height">
					<td class="k-s-content title" colspan="7" style="text-align:left;text-indent:1em">简历（从初中开始学起）</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2">自何年何月</td>
					<td class="k-s-content title" colspan="2">至何年何月</td>
					<td class="k-s-content title" colspan="2">在何地、何单位学习或工作</td>
					<td class="k-s-content title" colspan="1">任何职务</td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeBeforeDate_0" value="<?php echo $info['resume']['0']['resumeBeforeDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeAfterDate_0" value="<?php echo $info['resume']['0']['resumeAfterDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeWork_0" value="<?php echo $info['resume']['0']['resumeWork']; ?>" /></td>
					<td class="k-s-content title" colspan="1"><input type="text" name="resumePost_0" value="<?php echo $info['resume']['0']['resumePost']; ?>" /></td>

				</tr>
				<tr class="line-table-height">
					 <td class="k-s-content title" colspan="2"><input type="text" name="resumeBeforeDate_1" value="<?php echo $info['resume']['1']['resumeBeforeDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeAfterDate_1" value="<?php echo $info['resume']['1']['resumeAfterDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeWork_1" value="<?php echo $info['resume']['1']['resumeWork']; ?>" /></td>
					<td class="k-s-content title" colspan="1"><input type="text" name="resumePost_1" value="<?php echo $info['resume']['1']['resumePost']; ?>" /></td>

				</tr>
				<tr class="line-table-height">
					  <td class="k-s-content title" colspan="2"><input type="text" name="resumeBeforeDate_2" value="<?php echo $info['resume']['2']['resumeBeforeDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeAfterDate_2" value="<?php echo $info['resume']['2']['resumeAfterDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="resumeWork_2" value="<?php echo $info['resume']['2']['resumeWork']; ?>" /></td>
					<td class="k-s-content title" colspan="1"><input type="text" name="resumePost_2" value="<?php echo $info['resume']['2']['resumePost']; ?>" /></td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="7" style="text-align:left;text-indent:1em">获奖情况：</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="2">时间</td>
					<td class="k-s-content title" colspan="2">奖项</td>
					<td class="k-s-content title" colspan="3">发证单位</td>

				</tr>
				 <tr class="line-table-height">
					<td class="k-s-content title" colspan="2"><input type="text" name="prizeDate_0"  value="<?php echo $info['prize']['0']['prizeDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="prizeName_0"  value="<?php echo $info['prize']['0']['prizeName']; ?>" /></td>
					<td class="k-s-content title" colspan="3"><input type="text" name="prizeCompany_0"  value="<?php echo $info['prize']['0']['prizeCompany']; ?>" /></td>

				</tr>
				 <tr class="line-table-height">
					<td class="k-s-content title" colspan="2"><input type="text" name="prizeDate_1"  value="<?php echo $info['prize']['1']['prizeDate']; ?>" /></td>
					<td class="k-s-content title" colspan="2"><input type="text" name="prizeName_1"  value="<?php echo $info['prize']['1']['prizeName']; ?>" /></td>
					<td class="k-s-content title" colspan="3"><input type="text" name="prizeCompany_1"  value="<?php echo $info['prize']['1']['prizeCompany']; ?>" /></td>
				</tr>
				 <tr class="line-table-height">
					<td class="k-s-content title" colspan="1">处分情况</td>
					<td class="k-s-content title" colspan="6">
						<input type="text" name="punishment"  />
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" style="text-align:left;text-indent:1em" colspan="7">家庭主要社会关系</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="1">关系</td>
					<td class="k-s-content title" colspan="1">姓名</td>
					<td class="k-s-content title" colspan="3">工作单位</td>
					<td class="k-s-content title" colspan="2">电话</td>
				</tr>
				 <tr class="line-table-height">
				   <td class="k-s-content title" colspan="1">
						<input type="text" name="familyPunishment_0" value="<?php echo $info['family']['0']['familyPunishment']; ?>" />
					</td>
					<td class="k-s-content title" colspan="1">
						<input type="text" name="familyName_0" value="<?php echo $info['family']['0']['familyName']; ?>" />
					</td>
					<td class="k-s-content title" colspan="3">
						<input type="text" name="familyWork_0" value="<?php echo $info['family']['0']['familyWork']; ?>" />
					</td>
					<td class="k-s-content title" colspan="2">
						<input type="text" name="familyTell_0" value="<?php echo $info['family']['0']['familyTell']; ?>" />
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="1">
						<input type="text" name="familyPunishment_1" value="<?php echo $info['family']['1']['familyPunishment']; ?>"  />
					</td>
					<td class="k-s-content title" colspan="1">
						<input type="text" name="familyName_1" value="<?php echo $info['family']['1']['familyName']; ?>" />
					</td>
					<td class="k-s-content title" colspan="3">
						<input type="text" name="familyWork_1" value="<?php echo $info['family']['1']['familyWork']; ?>" />
					</td>
					<td class="k-s-content title" colspan="2">
						<input type="text" name="familyTell_1" value="<?php echo $info['family']['1']['familyTell']; ?>" />
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" colspan="1">
						<input type="text" name="familyPunishment_2" value="<?php echo $info['family']['2']['familyPunishment']; ?>" />
					</td>
					<td class="k-s-content title" colspan="1">
						<input type="text" name="familyName_2" value="<?php echo $info['family']['2']['familyName']; ?>" />
					</td>
					<td class="k-s-content title" colspan="3">
						<input type="text" name="familyWork_2" value="<?php echo $info['family']['2']['familyWork']; ?>" />
					</td>
					<td class="k-s-content title" colspan="2">
						<input type="text" name="familyTell_2" value="<?php echo $info['family']['2']['familyTell']; ?>" />
					</td>
				</tr>


				<tr class="line-table-height2">
					<td class="k-s-content title">中职学校报考审核 意见</td>
					<td class="k-s-content content_area" colspan="3">
					   （盖公章）
					</td>
					<td class="k-s-content title">高职学校审核意见</td>
					<td class="k-s-content content_area" colspan="2">

					</td>
				</tr>
				</tbody>
			</table>
			</div>
			</div>

		</div>
        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-9"  href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $member_list_edit['member_list_id']; ?>">
                <?php if($member_list_edit['user_status'] == 1): ?>
                <button class="btn btn-info btn-danger member_status_btn" type="button">
                    审核不通过
                </button>
                <?php else: ?>
                <button class="btn btn-info btn-primary member_status_btn" type="button">
                    审核通过
                </button>
                <?php endif; ?>


            </div>
        </div>
	</div><!-- /.page-content -->



			<!-- 右侧下主要内容结束 -->
		</div>
	</div><!-- 主要内容结束 -->
	<!-- 页脚开始 -->
	<div class="footer">
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

	<script type="text/javascript" src="__PUBLIC__/others/region.js"></script>

<!-- 与此页相关的js -->
</body>
</html>
