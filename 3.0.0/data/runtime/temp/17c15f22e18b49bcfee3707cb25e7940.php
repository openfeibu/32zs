<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:78:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/member/sec_vocat_member_edit.html";i:1542354898;s:61:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/base.html";i:1526927309;s:63:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/header.html";i:1527162833;s:65:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/left_nav.html";i:1524749285;s:65:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/head_nav.html";i:1524746093;s:63:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/public/footer.html";i:1525328647;}*/ ?>
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
			
<style>
.personal_table{background: #fff;margin: auto 10%;width: 656px;}

.personal_table table input{width: 100%;height: 100%;border:none;outline:none;text-align: center;color: #666;font-weight: bolder;}
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
<style type="text/css" media=print>
.printHide{display : none }
@page {
margin: 5px;
}
</style>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/shearphoto/css/ShearPhoto_f_zh-cn.css" />
	<div class="page-content ">
		<!--主题-->
		<div class="page-header printHide">
			<h1>
				您当前操作
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					修改中职考生信息
				</small>
			</h1>
		</div>
		<div class="row printHide">
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
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 身份证号码：  </label>
						<div class="col-sm-10">
							<input type="text" name="member_list_username" id="member_list_username" value="<?php echo $member_list_edit['member_list_username']; ?>" placeholder="输入登录用户名" class="col-xs-10 col-sm-4" required/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填</span>
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 登入密码：  </label>
						<div class="col-sm-10">
							<input type="text" name="member_list_pwd" id="member_list_pwd" placeholder="输入新的密码" class="col-xs-10 col-sm-4" maxlength="8" minlength="6"/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>如不修改请留空，密码必须大于6位，小于15位</span>
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 姓名：  </label>
						<div class="col-sm-10">
							<input type="text" name="member_list_nickname" id="member_list_nickname" value="<?php echo $member_list_edit['member_list_nickname']; ?>"  placeholder="输入姓名" class="col-xs-10 col-sm-4" required/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填</span>
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
                            <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填</span>
						</div>
					</div>
					<div class="space-4"></div>
                    <?php else: ?>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 所属中职: </label>
						<div class="col-sm-10">
							<select name="school_id"  class="col-sm-5" id="school2" required>
								<option value="">请选择所属中职</option>
								<?php if(is_array($school_list) || $school_list instanceof \think\Collection || $school_list instanceof \think\Paginator): if( count($school_list)==0 ) : echo "" ;else: foreach($school_list as $key=>$v): ?>
									<option value="<?php echo $v['school_id']; ?>" <?php if($v['school_id'] == $member_list_edit['school_id']): ?>selected<?php endif; ?> ><?php echo $v['school_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
                            <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填</span>
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
                            <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填</span>
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
							<button class="btn btn-fb-blue fb-radio" type="submit">
								保存
							</button>


							<button class="btn fb-radio btn-fb-orange" type="reset" onclick="window.history.go(-1);" onclick="window.history.go(-1);">

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
				}
		endif; ?>
        <!--startprint1-->
		<div class="row">
			<div class="col-xs-12">
			<div class="personal_table">
            <input type="hidden" name="member_list_id" value="<?php echo $member_list_edit['member_list_id']; ?>" />
			<table width="656px" class="k-w-table line_table member_table">
				<tbody><tr class="line-table-height">
					<td class="k-s-content low_width_1 title" style="text-align: center;">姓&nbsp;&nbsp;名</td>
					<td class="k-s-content low_width_2 content"><input type="text" name="name" value="<?php echo $info['member_list_nickname']; ?>" disabled/></td>
					<td class="k-s-content low_width_3 title">性&nbsp;&nbsp;别</td>
					<td class="k-s-content low_width_4 content"><input type="text" name="sex" value="<?php echo $info['sex']; ?>" disabled/></td>
					<td class="k-s-content low_width_5 title">高考考生号</td>
					<td class="k-s-content low_width_6 content"><input type="text" name="GexamineeNumber" value="<?php echo $info['GexamineeNumber']; ?>" /></td>
					<td class="k-s-content low_width_7" rowspan="5" style="text-align: center;position:relative">
						<img id="studentPicture_herf_show" style="width: 125px; height: 175px; display: inline;" src="<?php if($member_list_edit['member_list_headpic']): ?><?php echo get_imgurl($member_list_edit['member_list_headpic'],1); else: ?>/public/img/defaultGraph.jpg<?php endif; ?> " height="175px" width="125px" class="headicon"  <?php if($member_list_edit['user_status'] != 1): ?>data-toggle="modal" data-target="#myModal" title="建议使用ie9以上浏览器，360浏览器建议使用极速模式"<?php endif; ?>>
						<!-- <input type="file" class="upload" value="" style="width:100%;height:100%;position:absolute;top:0;left:0;opacity:0;cursor:pointer;"> -->
					</td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content low_width_1 title">出生年月</td>
					<td class="k-s-content content"><input type="text" name="date" value="<?php echo $info['date']; ?>" disabled/></td>
					<td class="k-s-content low_width_3 title">民&nbsp;&nbsp;族</td>
					<td class="k-s-content content"><input type="text" name="nation" value="<?php echo $info['nation']; ?>" /></td>
					<td class="k-s-content title">政治面貌</td>
					<td class="k-s-content content"><input type="text" name="politicalOutlook" value="<?php echo $info['politicalOutlook']; ?>" /></td>
				</tr>
				<tr class="line-table-height">
                    <td class="k-s-content low_width_3 title">所在学校</td>
					<td class="k-s-content content"  colspan="2">
						<input type="text" name="school" value="<?php echo $school['school_name']; ?>"  disabled/>
					</td>
					<td class="k-s-content low_width_1 title">身份证号</td>
					<td class="k-s-content content" colspan="2"><input type="text" name="cardId" value="<?php echo $info['member_list_username']; ?>" disabled/></td>

				</tr>
				<tr class="line-table-height">
                    <td class="k-s-content title">生源地</td>
                   <td class="k-s-content content">
                       <input type="text" name="documentType" value="<?php echo $info['documentType']; ?>" />
                   </td>
					<td class="k-s-content content title">户籍地</td>
					<td class="k-s-content content"><input type="text" name="domicile" value="<?php echo $info['domicile']; ?>" /></td>
					<td class="k-s-content low_width_1 title">所在专业</td>
					<td class="k-s-content content">
						<input type="text" name="nowProfessional" value="<?php echo $major['major_name']; ?>" disabled/>
					</td>

				</tr>
				<tr class="line-table-height">
					<td class="k-s-content low_width_1 title">报考专业</td>
					<td class="k-s-content content" colspan="1">
						<input type="text" name="applyProfessional"  value='<?php echo $recruit_major['recruit_major_name']; ?>' disabled/>
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
					<td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_1" value="<?php echo $info['certificate']['1']['certificateLevel']; ?>"/></td>
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
        <!--endtprint1-->
        <div class="clearfix form-actions printHide">
            <div class="col-md-offset-3 col-md-9"  href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $member_list_edit['member_list_id']; ?>">

                <?php if($admin['group_id'] == 3): if(isset($last_member_list_id)): ?>
                <button class="btn-button-page btn-fb-orange btn-fb-radio btn-height-40" type="button" <?php if($last_member_list_id): ?>onclick="javascript:window,location.href='<?php echo url('member/member_edit',['member_list_id' => $last_member_list_id]); ?>';"<?php else: ?>disabled<?php endif; ?>>
                    上一位
                </button>
                <?php endif; if(isset($next_member_list_id)): ?>
                <button class="btn-button-page btn-fb-orange btn-fb-radio btn-height-40" type="button" <?php if($next_member_list_id): ?>onclick="javascript:window,location.href='<?php echo url('member/member_edit',['member_list_id' => $next_member_list_id]); ?>';"<?php else: ?>disabled<?php endif; ?>>
                    下一位
                </button>
                <?php endif; ?>
                <!-- <button class="btn btn-info btn-primary printHide" onclick="preview(1)">打印</button> -->
                <?php endif; ?>
            </div>
        </div>
	</div><!-- /.page-content -->


    <script type="text/javascript">
     <?php if($member_list_edit['user_status'] == 1): ?>
     $('.personal_table').find('input').attr('disabled',true);
     <?php endif; ?>
    </script>

    <script  type="text/javascript" src="__PUBLIC__/shearphoto/js/ShearPhoto.js" ></script>
<script  type="text/javascript"  src="__PUBLIC__/shearphoto/js/alloyimage.js" ></script>
<script  type="text/javascript"  src="__PUBLIC__/shearphoto/js/handle_f.js" ></script>
<script type="text/javascript">
    var SHEAR = {
        PATH_RES: '__PUBLIC__',
        PATH_AVATAR: '__ROOT__/data/upload/avatar',
        URL:"<?php echo url('admin/Member/avatar',['member_list_id' => $member_list_edit['member_list_id']]); ?>",
    };
</script>

    <!-- 显示模态框（Modal） -->
        <div class="modal fade modal-avatar printHide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
            <div class="modal-dialog" style="width:60%;">
                <div class="modal-content"  style="min-width:620px;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            选择头像
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                    <div id="shearphoto_loading"><?php echo lang('program loading'); ?>......</div>
                                    <div id="shearphoto_main">

                                        <div class="primary">
                                            <div id="main">
                                                <div class="point"></div>
                                                <div id="SelectBox">
                                                    <form    id="ShearPhotoForm" enctype="multipart/form-data" method="post"  target="POSTiframe">
                                                        <a href="javascript:;" id="selectImage"><input type="file"  name="UpFile" autocomplete="off"/></a>
                                                    </form>

                                                </div>
                                                <div id="relat">
                                                    <div id="black"></div>
                                                    <div id="movebox">
                                                        <div id="smallbox">
                                                            <img src="__PUBLIC__/shearphoto/images/default.gif" class="MoveImg"  style="max-width:300%"/>
                                                        </div>
                                                        <i id="borderTop"></i>
                                                        <i id="borderLeft"></i>
                                                        <i id="borderRight"></i>
                                                        <i id="borderBottom"></i>
                                                        <i id="BottomRight"></i>
                                                        <i id="TopRight"></i>
                                                        <i id="Bottomleft"></i>
                                                        <i id="Topleft"></i>
                                                        <i id="Topmiddle"></i>
                                                        <i id="leftmiddle"></i>
                                                        <i id="Rightmiddle"></i>
                                                        <i id="Bottommiddle"></i>
                                                    </div>
                                                    <img src="__PUBLIC__/shearphoto/images/default.gif" class="BigImg" />
                                                </div>
                                            </div>
                                            <div style="clear: both"></div>
                                            <div id="Shearbar">
                                                <a id="LeftRotate" href="javascript:;"><em></em>向左转</a>
                                                <em class="hint L"></em>
                                                <div class="ZoomDist" id="ZoomDist">
                                                    <div id="Zoomcentre"></div>
                                                    <div id="ZoomBar"></div>
                                                    <span class="progress"></span>
                                                </div>
                                                <em class="hint R"></em>
                                                <a id="RightRotate" href="javascript:;">向右转<em></em></a>
                                                <p class="Psava">
                                                    <a id="againIMG"  href="javascript:;">重新选择</a>
                                                    <a id="saveShear" href="javascript:;">保存</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div style="clear: both"></div>
                                    </div>
                                    <div id="photoalbum">
                                        <i id="close"></i>
                                        <ul>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/1.jpg" serveUrl="file/photo/1.jpg" /></li>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/2.jpg" serveUrl="file/photo/2.jpg" /></li>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/3.jpg" serveUrl="file/photo/3.jpg" /></li>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/4.jpg" serveUrl="file/photo/4.jpg" /></li>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<script type="text/javascript">
function preview(oper)
{
if (oper < 10)
{
bdhtml=window.document.body.innerHTML;//获取当前页的html代码
sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
prnhtmlprnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
window.document.body.innerHTML=prnhtml;
window.print();
window.document.body.innerHTML=bdhtml;
} else {
window.print();
}
}
</script>

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

	<script type="text/javascript" src="__PUBLIC__/others/region.js"></script>

<!-- 与此页相关的js -->
</body>
</html>
