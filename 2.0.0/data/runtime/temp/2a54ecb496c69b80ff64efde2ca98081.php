<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:69:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\score\recruit_score_list.html";i:1495126787;s:56:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\base.html";i:1489327654;s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\header.html";i:1494035501;s:60:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\left_nav.html";i:1494035501;s:60:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\head_nav.html";i:1494035501;s:74:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\score\ajax_recruit_score_list.html";i:1495008228;s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\footer.html";i:1494035501;}*/ ?>
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

			<form name="admin_list_sea" class="form-search" id="list-filter" method="post" action="<?php echo url('admin/score/recruit_score_list'); ?>">
				<div class="col-xs-12 col-sm-6  margintop5">

					<select name="recruit_score_status" class="ajax_change" id="recruit_score_status">
						<option value="">所有审核状态</option>
						<option value="0" <?php if($recruit_score_status == '0'): ?>selected="selected"<?php endif; ?>>审核中</option>
						<option value="1" <?php if($recruit_score_status == '1'): ?>selected="selected"<?php endif; ?>>已审核</option>
					</select>
					<select name="school_id" class="ajax_change" id="school_id">
						<option value="">选择学校</option>
						<?php if(is_array($school_list) || $school_list instanceof \think\Collection || $school_list instanceof \think\Paginator): if( count($school_list)==0 ) : echo "" ;else: foreach($school_list as $key=>$v): ?>
							<option value="<?php echo $v['school_id']; ?>" <?php if($school_id == $v['school_id']): ?>selected="selected"<?php endif; ?>><?php echo $v['school_name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					<a href="javascript:;" onclick="javascript:var school_id = $('#school_id').val();var recruit_score_status = $('#recruit_score_status').val();window.location.href='<?php echo url('admin/Score/recruit_score_list_export'); ?>?school_id='+school_id+'&recruit_score_status='+recruit_score_status;" title="成绩导出">成绩导出：<i class="fa fa-download export" style="float:none;"></i></a>
				</div>
				<div class="col-xs-12 col-sm-3  margintop5">
					<div class="input-group">
						<input type="text" name="search_key" id="key" class="form-control" value="<?php echo $search_key; ?>" placeholder="请输入身份证、姓名、中职考生号" />
						<span class="input-group-btn">
							<button type="submit" class="btn btn-sm  btn-purple ajax-search-form">
								<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
								搜索
							</button>
						</span>
					</div>
				</div>
				<div class="col-xs-4 col-sm-3 margintop5">
					<div class="input-group-btn">
						<a href="<?php echo url('admin/Score/recruit_score_list'); ?>">
							<button type="button" class="btn btn-sm  btn-purple ajax-display-all">
								<span class="ace-icon fa fa-globe icon-on-right bigger-110"></span>
								显示全部
							</button>
						</a>
					</div>
				</div>
			</form>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div>
					<form id="score_form" class="ajaxForm" name="leftnav" method="post" action="<?php echo url('admin/Score/recruit_score_active'); ?>" >
                        <input name="p" id="p" value="<?php echo input('p',1); ?>" type="hidden" />
						<input type="hidden" name="checkk" id="checkk" value="1" /><!--用于判断操作类型-->
						<table class="table table-striped table-bordered table-hover" id="dynamic-table">
							<thead>
							<tr>
								<th class="hidden-xs ">
                                    <label class="pos-rel">
                                        <input type="checkbox" class="ace" id="chkAll" onclick="CheckAll(this.form)" value="全选">
                                        <span class="lbl"></span>
                                    </label>
                                    ID
                                </th>
								<th>姓名</th>
								<th>中职考生号</th>
								<th>身份证</th>
                                <th>中职学校</th>
                                <th>中职专业</th>
                                <th width="300px;">技能成绩</th>
                                <th>成绩审核状态</th>
							</tr>
							</thead>
							<tbody id="ajax-data">
								
<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td class="hidden-xs" height="28" >
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
            <span class="lbl"></span>
        </label><?php echo $v['member_list_id']; ?>
    </td>
    <td height="28" ><?php echo $v['member_list_nickname']; ?></td>
    <td><?php echo $v['ZexamineeNumber']; ?></td>
    <td><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['school_name']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <td><input type="text" name="recruit_score" value="<?php echo $v['recruit_score']; ?>" class="recruit_score score_input" data-id="<?php echo $v['member_list_id']; ?>" <?php if($v['recruit_score_status'] ==1): ?>disabled<?php endif; ?>></td>
   <td><span class="status_<?php echo $v['member_list_id']; ?>"><?php echo $v['status_desc']; ?></span></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td height="50" align="center">
        <button id="btnsubmit" class="btn btn-white btn-blue btn-sm hidden-xs btn-active">通过</button>
    </td>
    <td colspan="20" align="center"><?php echo $page; ?></td>
</tr>
<input name="school_id"  value="<?php echo input('school_id',''); ?>" type="hidden" />
<input name="major_id"  value="<?php echo input('major_id',''); ?>" type="hidden" />

							</tbody>

						</table>
					</form>
				</div>
			</div>
		</div>

	</div><!-- /.page-content -->
<script>
	$('body').on('click','.btn-unactive',function(){
		url = "<?php echo url('admin/score/score_unactive'); ?>";
		$("#score_form").attr('action',url);
		return true;
	})
	$('body').on('blur','.recruit_score',function(){
        member_list_id = $(this).attr('data-id');
        recruit_score = $.trim($(this).val());
		$this = $(this);
		var html = '<img src="/public/img/loading.gif" id="loading_img">';
        if(recruit_score.length > 0){
            var reg = /^[0-9]+.?[0-9]*$/;
            if(!reg.test(recruit_score)){
                layer.alert('输入正确的数字格式！', {icon: 5});
            }
            else{
				$(this).after(html);
                $.ajax({
                    url: "/admin/score/recruit_score_runedit",
                    data:{'member_list_id':member_list_id,'recruit_score':recruit_score},
                    success: function(data){
						$('#loading_img').remove();
						$this.after('<span class="save_span">已保存</span>');
						$('.save_span').fadeOut('normal',function(){
							$('.save_span').remove();
						});
                        if (data.code == 1) {
							var html = '<span style="color:#3499DB;font-weight: bold;">审核中</span>';
                            $(".status_" + member_list_id).html(html);
                           //  layer.alert(data.msg, {icon: 6});
                        }else if(data.code == 0){
                            layer.alert(data.msg, {icon: 5});
                        }
                    }
                });
            }
        }
    });
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
