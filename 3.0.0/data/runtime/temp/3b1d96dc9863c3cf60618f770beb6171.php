<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:64:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/news/news_back.html";i:1524588235;s:61:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/base.html";i:1524556754;s:63:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/header.html";i:1524624333;s:65:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/left_nav.html";i:1524456538;s:65:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/head_nav.html";i:1524501980;s:69:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/news/ajax_news_back.html";i:1524730208;s:63:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/public/footer.html";i:1524730208;}*/ ?>
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
					<i ><img src="__PUBLIC__/img/logo.jpg" alt="" style="width: 50px;height: 50px;"></i>
					<p>
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
		<link rel="stylesheet" type="text/css" media="all" href="__PUBLIC__/sldate/daterangepicker-bs3.css" />
		<div class="row maintop">
		<button id="btnsubmit" class="btn btn-white btn-yellow btn-sm">批量删除</button>
		<form name="admin_list_sea" class="form-search " id="list-filter" method="post" action="<?php echo url('admin/News/news_back'); ?>">

				<div class="fb-state-search">
					筛选：
					<select name="keytype">
						<option value="news_title" <?php if(($keytype == 'news_title') or ($keytype == '')): ?>selected<?php endif; ?>>按标题搜</option>
						<option value="news_auto" <?php if($keytype == 'news_auto'): ?>selected<?php endif; ?>>按发布人ID</option>
					</select>
					<?php if(config('lang_switch_on')): ?>
					<select name="news_l" class="ajax_change">
						<option value="">按语言</option>
						<option value="zh-cn" <?php if($news_l == 'zh-cn'): ?>selected="selected"<?php endif; ?>>中文</option>
						<option value="en-us" <?php if($news_l == 'en-us'): ?>selected="selected"<?php endif; ?> >英语</option>
					</select>
					<?php endif; ?>
					<select name="diyflag" class="ajax_change">
						<option value="">按属性</option>
						<?php if(is_array($diyflag) || $diyflag instanceof \think\Collection || $diyflag instanceof \think\Paginator): if( count($diyflag)==0 ) : echo "" ;else: foreach($diyflag as $key=>$v): ?>
							<option value="<?php echo $v['diyflag_value']; ?>" <?php if($diyflag_check == $v['diyflag_value']): ?>selected<?php endif; ?>><?php echo $v['diyflag_name']; ?>【<?php echo $v['diyflag_value']; ?>】</option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					<select name="opentype_check" class="ajax_change">
						<option value="">状态</option>
						<option value="1" <?php if($opentype_check == '1'): ?>selected="selected"<?php endif; ?>>已审</option>
						<option value="0" <?php if($opentype_check == '0'): ?>selected="selected"<?php endif; ?> >未审</option>
					</select>
				</div>

				<div class="col-xs-12 col-sm-3  hidden-xs btn-sespan">
					<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
										</span>
						<input type="text"  name="reservation" id="reservation" class="sl-date" value="<?php echo $sldate; ?>" placeholder="点击选择日期范围"/>
					</div>
				</div>


				<div class="col-xs-12 col-sm-3 btn-sespan">
					<div class="input-group">
									<span class="input-group-addon">
										<i class="ace-icon fa fa-search"></i>
									</span>
						<input type="text" name="key" id="key" class="form-control search-query admin_sea" value="<?php echo $keyy; ?>" placeholder="输入需查询的关键字" />

					</div>
				</div>

		</form>
		</div>


		<div class="row">
			<div class="col-xs-12">
				<div>
					<form id="alldel" name="alldel" method="post" action="<?php echo url('admin/News/news_back_alldel'); ?>" >
						<input name="p" id="p" value="<?php echo input('page',input('p',1)); ?>" type="hidden" />
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dynamic-table">
								<thead>
								<tr>
									<th width="60px">
										<label class="pos-rel">
											<input type="checkbox" class="ace"  id='chkAll' onclick='CheckAll(this.form)' value="全选"/>
											<span class="lbl"></span>															</label>														</th>
									<th  width="60px">序号</th>
									<th>文章标题</th>
									<th class="hidden-sm hidden-xs">所属栏目</th>
									<th class="hidden-sm hidden-xs">文章属性</th>
									<th class="hidden-xs">点击</th>
									<th class="hidden-xs">状态</th>
									<th class="hidden-xs">发布时间</th>
									<th width="150px">操作</th>
								</tr>
								</thead>

								<tbody id="ajax-data">
									<?php if(is_array($news) || $news instanceof \think\Collection || $news instanceof \think\Paginator): if( count($news)==0 ) : echo "" ;else: foreach($news as $key=>$v): ?>
	<tr>
		<td  align="center">
			<label class="pos-rel">
				<input name='n_id[]' id="navid" class="ace"  type='checkbox' value='<?php echo $v['n_id']; ?>'>
				<span class="lbl"></span>														</label>														</td>
		<td  align="center"><?php echo $v['n_id']; ?></td>
		<td><a href="" target="_blank" title="<?php echo $v['news_title']; ?>"><?php echo subtext($v['news_title'],25); ?></a>【<?php echo (isset($v['member_list_nickname']) && ($v['member_list_nickname'] !== '')?$v['member_list_nickname']:$v['member_list_username']); ?>】</td>
		<td class="hidden-sm hidden-xs"><?php echo $v['menu_name']; ?></td>
		<!-- <td class="hidden-sm hidden-xs">
			<?php if(strstr($v['news_flag'],'h') == true): ?><span style="color:#03C">头</span><?php endif; if(strstr($v['news_flag'],'c') == true): ?><span style="color:#060">荐</span><?php endif; if(strstr($v['news_flag'],'f') == true): ?><span style="color:#09F">幻</span><?php endif; if(strstr($v['news_flag'],'a') == true): ?><span style="color:#63C">特</span><?php endif; if(strstr($v['news_flag'],'s') == true): ?><span style="color:#C0C">滚</span><?php endif; if(strstr($v['news_flag'],'p') == true): ?><span style="color:#960">图</span><?php endif; if(strstr($v['news_flag'],'j') == true): ?><span style="color:#C00">跳</span><?php endif; if(strstr($v['news_flag'],'d') == true): ?><span style="color:#630">原</span><?php endif; ?>														</td> -->
		<td class="hidden-xs"><?php echo $v['news_hits']; ?></td>
		<td class="hidden-xs">
			<?php if($v['news_open'] == 1): ?>
				<a class="red state-btn" href="<?php echo url('admin/News/news_state'); ?>" data-id="<?php echo $v['n_id']; ?>" title="已审">
					<div id="zt<?php echo $v['n_id']; ?>"><button class="btn btn-minier btn-yellow">已审</button></div>
				</a>
				<?php else: ?>
				<a class="red state-btn" href="<?php echo url('admin/News/news_state'); ?>" data-id="<?php echo $v['n_id']; ?>" title="未审">
					<div id="zt<?php echo $v['n_id']; ?>"><button class="btn btn-minier btn-danger">未审</button></div>
				</a>
			<?php endif; ?>
		</td>
		<td class="hidden-xs"><?php echo date('Y-m-d',$v['news_time']); ?></td>
		<td>
			<div class="action-buttons">
				<a class="red confirm-rst-url-btn" data-info="确定要还原文章到文章列表吗？" href="<?php echo url('admin/News/news_back_open',array('n_id'=>$v['n_id'],'p'=>input('p',1))); ?>" title="还原">
					<i class="ace-icon fa fa-check bigger-130"></i>																</a>
				<a class="red confirm-rst-url-btn" data-info="确定要彻底删除文章吗？" href="<?php echo url('admin/News/news_back_del',array('n_id'=>$v['n_id'],'p'=>input('p',1))); ?>" title="删除">
					<i class="ace-icon fa fa-close bigger-130"></i>																</a>												</div>
			<div class="hidden-md hidden-lg hidden-sm hidden-xs">
				<div class="inline position-relative">
					<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
						<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
					</button>
					<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo url('admin/News/news_back_open',array('n_id'=>$v['n_id'],'p'=>input('p',1))); ?>" class="tooltip-success confirm-rst-url-btn" data-info="确定要还原文章到文章列表吗？" data-rel="tooltip" title="" data-original-title="还原">
											<span class="green">
												<i class="ace-icon fa fa-check bigger-120"></i>
											</span>
							</a>
						</li>

						<li>
							<a href="<?php echo url('admin/News/news_back_del',array('n_id'=>$v['n_id'],'p'=>input('p',1))); ?>"  class="tooltip-error confirm-rst-url-btn" data-info="确定要彻底删除文章吗？" data-rel="tooltip" title="" data-original-title="删除">
											<span class="red">
												<i class="ace-icon fa fa-close bigger-120"></i>
											</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>

								</tbody>
							</table>
						</div>
					</form>
					<div class="fb-page"><?php echo $page; ?></div>
				</div>
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
				广州飞步信息科技有限公司 &copy; 2017-<?php echo date('Y'); ?>
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
<!-- 此页相关插件js -->

	<script type="text/javascript" src="__PUBLIC__/sldate/moment.js"></script>
	<script type="text/javascript" src="__PUBLIC__/sldate/daterangepicker.js"></script>
	<script type="text/javascript">
		$('#reservation').daterangepicker(null, function (start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
	</script>

<!-- 与此页相关的js -->
</body>
</html>
