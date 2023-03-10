<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:61:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\model\model_edit.html";i:1491546838;s:56:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\base.html";i:1489327654;s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\header.html";i:1494035501;s:60:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\left_nav.html";i:1494035501;s:60:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\head_nav.html";i:1494035501;s:58:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\public\footer.html";i:1494035501;}*/ ?>
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
		<link rel="stylesheet" href="__PUBLIC__/bootstrap-select/css/bootstrap-select.min.css">
		<!--主题-->
		<div class="page-header">
			<h1>
				您当前操作
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					编辑模型
				</small>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal modelform" name="model_edit" method="post" action="<?php echo url('admin/Model/model_runedit'); ?>">
					<input name="model_id" id="model_id" type="hidden" value="<?php echo $model['model_id']; ?>" />
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 模型标识：  </label>
						<div class="col-sm-10">
							<input type="text" name="model_name" onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')" id="model_name" onblur="auto_pk()" class="col-xs-6 col-sm-6" value="<?php echo $model['model_name']; ?>" required/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填，标识必须是以字母开头,字母或数字组合</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 模型标题：  </label>
						<div class="col-sm-10">
							<input type="text" name="model_title" id="model_title" value="<?php echo $model['model_title']; ?>" class="col-xs-6 col-sm-6" required/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填,可以英文和中文</span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 引擎类型： </label>
						<div class="col-sm-10">
							<select name="model_engine"  class="col-xs-6 col-sm-6 selector" required>
								<option value="MyISAM" <?php if($model['model_engine'] == 'MyISAM'): ?>selected<?php endif; ?>>MyISAM</option>
								<option value="InnoDB" <?php if($model['model_engine'] == 'InnoDB'): ?>selected<?php endif; ?>>InnoDB</option>
							</select>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必选</span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段列表：  </label>
						<div class="col-sm-10">
							<label class="col-sm-12 no-padding-left">
								<a class="purple new-row" href="" data-toggle="modal" data-target="#myModal" title="插入到最后">
									<i class="ace-icon fa fa-plus-circle bigger-130"></i>
								</a>
							</label>
							<div class="col-sm-10 col-xs-12 no-padding-left">
								<table class="table table-striped table-bordered table-hover" id="dynamic-table">
									<thead>
									<tr>
										<th>名称</th>
										<th>标题</th>
										<th>类型</th>
										<th class="hidden">数据</th>
										<th class="hidden">说明</th>
										<th class="hidden">长度</th>
										<th>规则</th>
										<th class="hidden">默认值</th>
										<th style="border-right:#CCC solid 1px;">操作</th>
									</tr>
									</thead>

									<tbody id="fields-data">
										<?php if(is_array($fields) || $fields instanceof \think\Collection || $fields instanceof \think\Paginator): if( count($fields)==0 ) : echo "" ;else: foreach($fields as $key=>$v): ?>
										<tr>
											<td><?php echo $v['name']; ?></td>
											<td><?php echo $v['title']; ?></td>
											<td><?php echo $v['type']; ?></td>
											<td class="hidden"><?php echo $v['data']; ?></td>
											<td class="hidden"><?php echo $v['description']; ?></td>
											<td class="hidden"><?php echo $v['length']; ?></td>
											<td><?php echo $v['rules']; ?></td>
											<td class="hidden"><?php echo $v['default']; ?></td>
											<td style="border-right:#CCC solid 1px;">
												<div class="action-buttons">
													<a class="blue" href="javascript:void(0)" onclick="insert_field(this)" data-toggle="tooltip" title="插入字段"><i class="ace-icon fa fa-plus-circle bigger-130"></i></a>
													<a class="green" href="javascript:void(0)" onclick="edit_field(this)" data-toggle="tooltip" title="修改"><i class="ace-icon fa fa-pencil bigger-130"></i></a>
													<a class="red" href="javascript:void(0)" onclick="delete_field(this)" data-info="你确定要删除吗？" data-toggle="tooltip" title="删除"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
													<a class="green" href="javascript:void(0)" onclick="up_field(this)" data-toggle="tooltip" title="上移"><i class="ace-icon fa fa-arrow-up bigger-130"></i></a>
													<a class="green" href="javascript:void(0)" onclick="down_field(this)" data-toggle="tooltip" title="下移"><i class="ace-icon fa fa-arrow-down bigger-130"></i></a>
												</div>
											</td>
										</tr>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 模型主键：  </label>
                        <div class="col-sm-10">
                            <input type="text" name="model_pk" id="model_pk" value="<?php echo $model['model_pk']; ?>" class="col-xs-6 col-sm-6" required/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填,单字段，不应包含在上述字段列表内</span>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 模型栏目字段：  </label>
						<div class="col-sm-10">
							<input type="text" name="model_cid" id="model_cid" value="<?php echo $model['model_cid']; ?>" class="col-xs-6 col-sm-6" required/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填,单字段，不应包含在上述字段列表内</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 默认排序字段：  </label>
						<div class="col-sm-10">
							<input type="text" name="model_order" id="model_order" value="<?php echo $model['model_order']; ?>" class="col-xs-6 col-sm-6" required/>
							<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填,单字段，不应包含在上述字段列表内</span>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 列表显示字段：  </label>
                        <div class="col-sm-10">
                            <input type="text" name="model_list" id="model_list" value="<?php echo $model['model_list']; ?>" class="col-xs-6 col-sm-6"/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red"></span>格式：'字段a,字段b',可以包含多个字段,为空显示全部</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 可编辑字段：  </label>
                        <div class="col-sm-10">
                            <input type="text" name="model_edit" id="model_edit" value="<?php echo $model['model_edit']; ?>" class="col-xs-6 col-sm-6"/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red"></span>格式：'字段a,字段b',可以包含多个字段,为空除主键外均可编辑</span>
                        </div>
                    </div>					
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 列表排序：  </label>
                        <div class="col-sm-10">
                            <input type="text" name="model_sort" id="model_sort" value="<?php echo $model['model_sort']; ?>" class="col-xs-6 col-sm-6"/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red"></span>格式：'字段a desc,字段b',默认上面设置的'xxx_order'</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 模型索引：  </label>
                        <div class="col-sm-10">
                            <input type="text" name="model_indexes" id="model_indexes" value="<?php echo $model['model_indexes']; ?>" class="col-xs-6 col-sm-6"/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red"></span>格式：'字段a,字段b',可以包含多个字段</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 模型搜索字段：  </label>
                        <div class="col-sm-10">
                            <input type="text" name="search_list" id="search_list" value="<?php echo $model['search_list']; ?>" class="col-xs-6 col-sm-6"/>
                            <span class="lbl">&nbsp;&nbsp;<span class="red"></span>格式：'字段a,字段b',可以包含多个字段</span>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否启用： </label>
						<div class="col-sm-10" style="padding-top:5px;">
							<input name="model_status" id="model_status" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" <?php if($model['model_status'] == 1): ?>checked<?php endif; ?>/>
							<span class="lbl">&nbsp;&nbsp;默认启用</span>
						</div>
					</div>


					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info save-model" type="submit">
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
		</div>
		<!-- 显示添加模态框（Modal） -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">×
						</button>
						<h4 class="modal-title" id="myModalLabel">
							添加字段
						</h4>
					</div>
					<div class="modal-body">


						<div class="row">
							<div class="col-xs-12">
                                <input name="tr_index" id="tr_index" type="hidden" value="" />
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段名称：  </label>
									<div class="col-sm-10">
										<input type="text" onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')" name="field_name" id="field_name" placeholder="输入字段名称" class="col-xs-10 col-sm-5" required/><span class="lbl">*必填 以英文开头</span>
									</div>
								</div>
								<div class="space-4 col-xs-12"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段标题：  </label>
									<div class="col-sm-10">
										<input type="text" name="field_title" id="field_title" placeholder="输入字段标题" class="col-xs-10 col-sm-5" required/><span class="lbl">*必填</span>
									</div>
								</div>
								<div class="space-4 col-xs-12"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段类型：  </label>
									<div class="col-sm-10">
										<select name="field_type"  id="field_type" class="col-xs-10 col-sm-5 selector field_type" required>
											<option value="">请选择字段类型</option>
											<option value="text">文本</option>
											<option value="baidu_map">百度地图坐标</option>
											<option value="imagefile">单图片</option>
											<option value="images">多图片</option>
											<option value="file">单文件</option>
											<option value="files">多文件</option>
											<option value="selecttext">选择文本</option>
											<option value="currency">货币</option>
											<option value="large_number">长整数</option>
											<option value="number">整数</option>
											<option value="datetime">日期时间</option>
											<option value="date">日期</option>
											<option value="selectnumber">选择数字</option>
											<option value="richtext">富文本</option>
											<option value="bigtext">文本域</option>
											<option value="switch">开关</option>
											<option value="checkbox">多选框</option>
										</select>
										<span class="lbl">*必选</span>
									</div>
								</div>
								<div class="space-4 col-xs-12"></div>
								<div id="input_data">
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段数据：  </label>
										<div class="col-sm-10">
											<input type="text" name="field_data" id="field_data" placeholder="输入字段数据" class="col-xs-10 col-sm-5"/><span class="lbl">格式:'1:text1,2:text2,3:text3'或'数据表名|值字段名|标题字段名(|排序字段)(|条件)'</span>
										</div>
									</div>
									<div class="space-4 col-xs-12"></div>
								</div>
								<div id="input_length">
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段长度：  </label>
										<div class="col-sm-10">
											<input type="number" name="field_length" id="field_length" placeholder="输入字段长度" class="col-xs-10 col-sm-5"/><span class="lbl"></span>
										</div>
									</div>
									<div class="space-4 col-xs-12"></div>
								</div>
								<div id="input_default">
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段默认值：  </label>
										<div class="col-sm-10">
											<input type="text" name="field_default" id="field_default" placeholder="输入字段默认值" class="col-xs-10 col-sm-5"/><span class="lbl">地图类型时'lng,lat'</span>
										</div>
									</div>
									<div class="space-4 col-xs-12"></div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段说明：  </label>
									<div class="col-sm-10">
										<input type="text" name="field_desc" id="field_desc" placeholder="输入字段说明" class="col-xs-10 col-sm-5"/><span class="lbl"></span>
									</div>
								</div>
								<div class="space-4 col-xs-12"></div>
								<div class="form-group" id="input-rules">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段规则：</label>
									<div class="col-sm-10">
										<select class="selectpicker" multiple data-width="fit">
										    <option title="lengthfixed">lengthfixed</option>
										    <option title="required">required</option>
										    <option title="unsigned">unsigned</option>
										    <option title="unique">unique</option>
											<option title="readonly">readonly</option>
										</select>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary insert-field">
							确认
						</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">
							关闭
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
        <!-- 显示编辑模态框（Modal） -->
        <div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            编辑字段
                        </h4>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-xs-12">
                                <input name="tr_index" id="tr_index" type="hidden" value="" />
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段名称：  </label>
                                    <div class="col-sm-10">
                                        <input type="text" onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')" name="field_name" id="field_name" placeholder="输入字段名称" class="col-xs-10 col-sm-5" required/><span class="lbl">*必填 以英文开头</span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段标题：  </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="field_title" id="field_title" placeholder="输入字段标题" class="col-xs-10 col-sm-5" required/><span class="lbl">*必填</span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段类型：  </label>
                                    <div class="col-sm-10">
                                        <select name="field_type"  id="field_type" class="col-xs-10 col-sm-5 selector field_type" required>
                                            <option value="">请选择字段类型</option>
                                            <option value="text">文本</option>
											<option value="baidu_map">百度地图坐标</option>
                                            <option value="imagefile">单图片</option>
                                            <option value="images">多图片</option>
											<option value="file">单文件</option>
											<option value="files">多文件</option>
                                            <option value="selecttext">选择文本</option>
                                            <option value="currency">货币</option>
                                            <option value="large_number">长整数</option>
                                            <option value="number">整数</option>
                                            <option value="datetime">日期时间</option>
                                            <option value="date">日期</option>
                                            <option value="selectnumber">选择数字</option>
                                            <option value="richtext">富文本</option>
                                            <option value="bigtext">文本域</option>
                                            <option value="switch">开关</option>
                                            <option value="checkbox">多选框</option>
                                        </select>
                                        <span class="lbl">*必选</span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div id="input_data">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段数据：  </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="field_data" id="field_data" placeholder="输入字段数据" class="col-xs-10 col-sm-5"/><span class="lbl">格式:'1:text1,2:text2,3:text3'或'数据表名|值字段名|标题字段名(|排序字段)(|条件)'</span>
                                        </div>
                                    </div>
                                    <div class="space-4 col-xs-12"></div>
                                </div>
                                <div id="input_length">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段长度：  </label>
                                        <div class="col-sm-10">
                                            <input type="number" name="field_length" id="field_length" placeholder="输入字段长度" class="col-xs-10 col-sm-5"/><span class="lbl"></span>
                                        </div>
                                    </div>
                                    <div class="space-4 col-xs-12"></div>
                                </div>
                                <div id="input_default">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段默认值：  </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="field_default" id="field_default" placeholder="输入字段默认值" class="col-xs-10 col-sm-5"/><span class="lbl">地图类型时'lng,lat'</span>
                                        </div>
                                    </div>
                                    <div class="space-4 col-xs-12"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段说明：  </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="field_desc" id="field_desc" placeholder="输入字段说明" class="col-xs-10 col-sm-5"/><span class="lbl"></span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group" id="input-rules">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段规则：</label>
                                    <div class="col-sm-10">
                                        <select class="selectpicker" multiple data-width="fit">
                                            <option title="lengthfixed">lengthfixed</option>
                                            <option title="required">required</option>
                                            <option title="unsigned">unsigned</option>
                                            <option title="unique">unique</option>
                                            <option title="readonly">readonly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary edit-field">
                            确认
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            关闭
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
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

<script src="__PUBLIC__/bootstrap-select/js/bootstrap-select.min.js"></script>
<script>
    //自动生成pk
    function auto_pk() {
        $('#model_pk').val($('#model_name').val()+'_id');
        $('#model_cid').val($('#model_name').val()+'_cid');
        $('#model_order').val($('#model_name').val()+'_order');
        $('#model_sort').val($('#model_name').val()+'_order');
    }
    //上移字段
    function up_field(obj) {
        var $tr = $(obj).parents("tr");
        if ($tr.index() != 0) {
            $tr.fadeOut().fadeIn();
            $tr.prev().before($tr);
        }
    }
    //下移字段
    function down_field(obj) {
        var $tr = $(obj).parents("tr");
        var $len=$("table#dynamic-table tr").length;
        if ($tr.index() != $len - 1) {
            $tr.fadeOut().fadeIn();
            $tr.next().after($tr);
        }
    }
    //插入字段
    function insert_field(obj) {
        var trs=$("table#dynamic-table tr");
        var index=trs.index($(obj).closest("tr"));
        var Modal=$('#myModal');
        Modal.find('#tr_index').val(index);
        Modal.modal();
    }
    //删除字段
    function delete_field(obj) {
        var trs=$("table#dynamic-table tr"),
            $index=trs.index($(obj).closest("tr")),
            $info=$(obj).data('info');
        layer.confirm($info, {icon: 3}, function (index) {
            layer.close(index);
            $('#fields-data').find('tr').eq($index-1).remove();
        });
        return false;
    }
    //修改字段
    function edit_field(obj) {
        var trs=$("table#dynamic-table tr");
        var tr=$(obj).closest("tr");
        var index=trs.index(tr);
        var tds=tr.find('td');
        var Modal=$('#myModaledit');
        var $data_arr=['selecttext','checkbox','selectnumber'];
        Modal.find('#tr_index').val(index);
        Modal.find('#field_name').val(tds.eq(0).text());
        Modal.find('#field_title').val(tds.eq(1).text());
        Modal.find('#field_type').val(tds.eq(2).text());
        Modal.find('#field_data').val(tds.eq(3).text());
        Modal.find('#field_desc').val(tds.eq(4).text());
        Modal.find('#field_length').val(tds.eq(5).text());
        Modal.find('.selectpicker').selectpicker('val',tds.eq(6).text().replace(/\s/g, "").split(','));
        Modal.find('#field_default').val(tds.eq(7).text());
        //初始化显示状态
        var $type=tds.eq(2).text();
        if($.inArray($type, $data_arr)>-1){
            Modal.find("#input_data").show();
            Modal.find("#input_length").hide();
        }else if($type == 'text'){
            Modal.find("#input_data").hide();
            Modal.find("#input_length").show();
        }else{
            Modal.find("#input_data").hide();
            Modal.find("#input_length").hide();
        }
        //是否图片
        if($type=='imagefile' || $type=='images' || $type=='file' || $type=='files'){
            Modal.find("#input_default").hide();
        }else{
            Modal.find("#input_default").show();
        }
        //是否切换开关
        if($type=='switch'){
            Modal.find("#input-rules").hide();
        }else{
            Modal.find("#input-rules").show();
        }
        Modal.modal();
    }
</script>
<script>
    //保存模型
    $('.save-model').click(function () {
		var args = {},$form=$('.modelform'),$url=$form.attr('action');
		$("#dynamic-table tr:gt(0)").each(function(i){  
			var data = new Object();  
			$(this).find("td").each(function(j){  
				if(j<8){
					data[j]= $(this).text(); 
				}
			});
			args[i]=data;
		});
		$.post($url, $form.serialize()+"&fields="+JSON.stringify(args), function (data) {
            if (data.code==1) {
                layer.alert(data.msg, {icon: 6}, function (index) {
                    layer.close(index);
                    window.location.href = data.url;
                });
            } else {
                layer.alert(data.msg, {icon: 5});
            }
        }, "json");
		return false;
	});
$(function () {
	var $data_arr=['selecttext','checkbox','selectnumber'];
	$("#input_data").hide();
	$("#input_length").hide();
	$("#input_default").hide();
	//插入字段
    $('.insert-field').click(function () {
        var Modal=$('#myModal');
        var $table=$('#fields-data'),
			$field_name = Modal.find('#field_name').val(),
			$field_title = Modal.find('#field_title').val(),
			$field_type = Modal.find('#field_type').val(),
			$html ='';
		if($field_name=='' || $field_title=='' || $field_type==''){
			layer.alert('字段名、字段标题、字段类型不能为空', {icon: 5}, function (index) {
				layer.close(index);
			});
		}else{
		var $field_data = Modal.find('#field_data').val(),
			$field_length = Modal.find('#field_length').val(),
			$field_default = Modal.find('#field_default').val(),
			$field_desc = Modal.find('#field_desc').val(),
			$field_rules = (Modal.find('.filter-option').html()=='未选择')?'':Modal.find('.filter-option').html();
			$html='<tr><td>'+$field_name+'</td><td>'+$field_title+'</td><td>'+$field_type+'</td><td class="hidden">'+$field_data+'</td><td class="hidden">'+$field_desc+'</td><td class="hidden">'+$field_length+'</td><td>'+$field_rules+'</td><td class="hidden">'+$field_default+'</td><td style="border-right:#CCC solid 1px;"><div class="action-buttons"><a class="blue" href="javascript:void(0)" onclick="insert_field(this)" data-toggle="tooltip" title="插入字段"><i class="ace-icon fa fa-plus-circle bigger-130"></i></a><a class="green" href="javascript:void(0)" onclick="edit_field(this)" data-toggle="tooltip" title="修改"><i class="ace-icon fa fa-pencil bigger-130"></i></a><a class="red" href="javascript:void(0)" onclick="delete_field(this)" data-info="你确定要删除吗？" data-toggle="tooltip" title="删除"><i class="ace-icon fa fa-trash-o bigger-130"></i></a><a class="green" href="javascript:void(0)" onclick="up_field(this)" data-toggle="tooltip" title="上移"><i class="ace-icon fa fa-arrow-up bigger-130"></i></a><a class="green" href="javascript:void(0)" onclick="down_field(this)" data-toggle="tooltip" title="下移"><i class="ace-icon fa fa-arrow-down bigger-130"></i></a></div></td></tr>';
            var $tr_index = Modal.find('#tr_index').val();
            if($tr_index>0){
                $table.find('tr').eq($tr_index-1).after($html);
            }else{
                $table.append($html);
            }
            Modal.modal('hide');
		}
    });
    //编辑字段
    $('.edit-field').click(function () {
        var Modal=$('#myModaledit');
        var $table=$('#fields-data'),
            $field_name = Modal.find('#field_name').val(),
            $field_title = Modal.find('#field_title').val(),
            $field_type = Modal.find('#field_type').val(),
            $html ='';
        if($field_name=='' || $field_title=='' || $field_type==''){
            layer.alert('字段名、字段标题、字段类型不能为空', {icon: 5}, function (index) {
                layer.close(index);
            });
        }else{
            var $field_data = Modal.find('#field_data').val(),
            $field_length = Modal.find('#field_length').val(),
            $field_default = Modal.find('#field_default').val(),
            $field_desc = Modal.find('#field_desc').val(),
            $field_rules = (Modal.find('.filter-option').html()=='未选择')?'':Modal.find('.filter-option').html();
            $html='<td>'+$field_name+'</td><td>'+$field_title+'</td><td>'+$field_type+'</td><td class="hidden">'+$field_data+'</td><td class="hidden">'+$field_desc+'</td><td class="hidden">'+$field_length+'</td><td>'+$field_rules+'</td><td class="hidden">'+$field_default+'</td><td style="border-right:#CCC solid 1px;"><div class="action-buttons"><a class="blue" href="javascript:void(0)" onclick="insert_field(this)" data-toggle="tooltip" title="插入字段"><i class="ace-icon fa fa-plus-circle bigger-130"></i></a><a class="green" href="javascript:void(0)" onclick="edit_field(this)" data-toggle="tooltip" title="修改"><i class="ace-icon fa fa-pencil bigger-130"></i></a><a class="red" href="javascript:void(0)" onclick="delete_field(this)" data-info="你确定要删除吗？" data-toggle="tooltip" title="删除"><i class="ace-icon fa fa-trash-o bigger-130"></i></a><a class="green" href="javascript:void(0)" onclick="up_field(this)" data-toggle="tooltip" title="上移"><i class="ace-icon fa fa-arrow-up bigger-130"></i></a><a class="green" href="javascript:void(0)" onclick="down_field(this)" data-toggle="tooltip" title="下移"><i class="ace-icon fa fa-arrow-down bigger-130"></i></a></div></td>';
            var $tr_index = Modal.find('#tr_index').val();
            var tr=$table.find('tr').eq($tr_index-1);
            tr.html($html);
            Modal.modal('hide');
        }
    });
	//隐藏模态框时清空,removeData无效,不清楚为啥
	$('#myModal').on('hide.bs.modal', function () {
		$(this).find('#field_name').val('');
        $(this).find('#field_title').val('');
        $(this).find('#field_type').val('');
        $(this).find('#field_data').val('');
        $(this).find('#field_length').val('');
        $(this).find('#field_default').val('');
        $(this).find('#field_desc').val('');
        $(this).find('#tr_index').val('');
        $(this).find('.selectpicker').selectpicker('deselectAll');
	});
	//字段类型选择时,动态显示表单
	$('.field_type').change(function () {
		var $type=$(this).val(),Modal=$(this).parents('.modal');
		if($.inArray($type, $data_arr)>-1){
            Modal.find("#input_data").show(400);
            Modal.find("#input_length").hide(400);
		}else if($type == 'text'){
            Modal.find("#input_data").hide(400);
            Modal.find("#input_length").show(400);
		}else{
            Modal.find("#input_data").hide(400);
            Modal.find("#input_length").hide(400);
		}
		//是否图片
		if($type=='imagefile' || $type=='images'){
            Modal.find("#input_default").hide(400);
		}else{
            Modal.find("#input_default").show(400);
		}
        //是否切换开关
        if($type=='switch'){
            Modal.find("#input-rules").hide();
        }else{
            Modal.find("#input-rules").show();
        }
	});
});
</script>

<!-- 与此页相关的js -->
</body>
</html>
