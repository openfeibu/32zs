<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:67:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/user\forgot_pwd.html";i:1489327654;s:63:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\head.html";i:1490541958;s:67:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\function.html";i:1489327654;s:65:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\config.html";i:1489327654;s:62:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\nav.html";i:1489327654;s:65:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\footer.html";i:1493207649;s:66:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\scripts.html";i:1489327654;}*/ ?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo lang('forget password'); ?> <?php echo $site_name; ?> </title>
	<meta name="keywords" content="<?php echo (isset($menu['menu_seo_key']) && ($menu['menu_seo_key'] !== '')?$menu['menu_seo_key']:$site_seo_keywords); ?>" />
	<meta name="description" content="<?php echo (isset($menu['menu_seo_des']) && ($menu['menu_seo_des'] !== '')?$menu['menu_seo_des']:$site_seo_description); ?>">
	<?php 
/*这里只是一个模板函数库演示*/
function helloworld(){
	echo "hello YFCMF!";
}
 
//模板多语言
use think\Lang;

$lang_cn=array(
'positive'=>'客户评价',
'partner'=>'合作伙伴',
'see'=>'查看',
'recent news'=>'最近新闻',
'service items'=>'服务项目',
'successful case'=>'成功案例',
'successful case text'=>'以下案例均由雨飞工作室开发，部分设计灵感及素材来源于网络,如果您不希望贵司的案例显示在这里，请与我们联系。更多的成功案例正在整理中，请大家继续关注。如您有需要,随时可以联系我们……',
'index one'=>'我们的理念',
'index one text'=>'以客为尊、卓越服务、力争第一！',
'index two'=>'我们的目标',
'index two text'=>'平凡创造奇迹，业绩突破梦想！',
'index three'=>'我们的管理',
'index three text'=>'没有完美的个人，只有完美的团队！',
'about us'=>'关于我们',
'current location'=>'当前位置',
'home'=>'首页',
'team introduction'=>'团队介绍',
'our advantage'=>'我们的优势',
'our advantage one'=>'深厚的技术力量',
'our advantage two'=>'丰富的行业经验',
'our advantage three'=>'高效的作业流程',
'our advantage four'=>'完善的服务体系',
'our advantage five'=>'众多的成功案例',
'phone'=>'电话',
'email'=>'邮箱',
'address'=>'地址',
'homepage'=>'官网',
'personal center'=>'个人中心',
'sign out'=>'退出',
'login'=>'登录',
'weibo login'=>'微博登录',
'qq login'=>'QQ登录',
'register'=>'注册',
'scan QR code'=>'扫描二维码',
'scan'=>'扫一扫',
'contact us'=>'联系我们',
'link'=>'友情链接',
'search'=>'搜索',
'result'=>'条结果',
'search result'=>'搜索结果',
'news copyright'=>'注：本文转载自%s，转载目的在于传递更多信息，并不代表本网赞同其观点和对其真实性负责。如有侵权行为，请联系我们，我们会及时删除。',
'last news'=>'上一篇',
'next news'=>'下一篇',
'our location'=>'我们的位置',
'online message'=>'在线留言',
'username'=>'姓名',
'content'=>'内容',
'captcha'=>'验证码',
'click to get'=>'点击获取',
'send message'=>'发送留言',
'contact information'=>'联系方式',
'working hours'=>'工作时间',
'Monday ~ Friday'=>'周一~周五',
'Saturday'=>'周六',
'Sunday'=>'周日',
'rest'=>'休息',
'work flow'=>'工作流程',
'design'=>'协商设计',
'development phase'=>'开发阶段',
'test and acceptance'=>'测试验收',
'flow one'=>'1 双方协商网站建设内容，修改补充，达成共识 </br>2 我方制定《网站建设方案》 </br>3 双方确定建站细节及价格</br>4 双方签订《网站建设协议》</br>5 客户支付预付款(30%)</br>6 客户根据第一阶段调研表提供网站相关第一步内容资料完成样稿设计</br>',
'flow two'=>'1 我方根据《网站建设方案》完成网站样稿 </br>2 客户支付预付款(40%) </br>3 首页、频道首页、基本页、网站架构图 </br>4 客户审核确认样稿 </br>5 为客户注册域名</br>6 同时进行第二阶段调研	</br>',
'flow three'=>'1 我方完成全部网站制作 </br>2 我方完成网站测试，双方协商完善 </br>3 网站本地测试通过，客户确认 </br>4 客户验收网站，网站开通 </br>5 客户签发《网站建设验收合格确认书》 </br>6 客户支付余款，网站开通 	</br>',
'center'=>'个人中心',
'modify information'=>'修改资料',
'modify pwd'=>'修改密码',
'bind account'=>'绑定账号',
'my favorites'=>'我的收藏',
'my comments'=>'我的评论',
'hot articles'=>'热门文章',
'recent articles'=>'最近发布',
'recent comments'=>'最新评论',
'ads contribution'=>'广告赞助',
'error'=>'抱歉，出现错误了！',
'reason'=>'无法访问页面的原因：',
'automatically'=>'页面自动',
'jump'=>'跳转',
'wait second'=>'等待时间：',
'comments'=>'评论',
'send comments'=>'发表评论',
'need login to comment'=>'您需要登录后才可以评论',
'register immediately'=>'立即注册',
'anonymous'=>'匿名人',
'just'=>'刚刚',
'reply'=>'回复',
'cancel'=>'取消',
'ok'=>'确定',
'user login'=>'用户登录',
'username or email'=>'手机号/邮箱/用户名',
'remember'=>'记住登录',
'forget password'=>'忘记密码',
'nickname'=>'昵称',
'without filled'=>'未填写',
'score coin'=>'积分(金币)',
'last login'=>'最后登录',
'sex'=>'性别',
'ProMonkey'=>'程序猿',
'ProMM'=>'程序媛',
'secrecy'=>'保密',
'personal website'=>'个人网站',
'signature'=>'签名',
'news title'=>'原文标题',
'comment content'=>'评论内容',
'comment time'=>'评论时间',
'account activation'=>'账号激活',
'account not activated'=>'账号未激活',
'resend active email'=>'重发激活邮件?',
'resend now'=>'现在就重发吧！',
'bound qq'=>'已绑定腾讯QQ账号',
'bind new qq'=>'绑定腾讯QQ账号',
'bound sina weibo'=>'已绑定新浪微博账号',
'bind new sina weibo'=>'绑定新浪微博账号',
'member avatar'=>'会员头像',
'program loading'=>'程序加载中',
'pic effect'=>'截图效果',
'save capture'=>'保存截图',
'reselection'=>'重新选择',
'turn R'=>'右转',
'turn L'=>'左转',
'original'=>'原图',
'Skin effect'=>'美肤效果',
'Sketch effect'=>'素描效果',
'Enhancement effect'=>'自然增强',
'Purple effect'=>'紫调效果',
'Soft focus'=>'柔焦效果',
'Retro effect'=>'复古效果',
'Black-white effect'=>'黑白效果',
'Imitation LOMO'=>'仿lomo',
'Bright white effect'=>'亮白增强',
'Grey-white effect'=>'灰白效果',
'Grey effect'=>'灰色效果',
'Warm autumn effect'=>'暖秋效果',
'Wood carving effect'=>'木雕效果',
'Rough effect'=>'粗糙效果',
);
$lang_en=array(
'positive'=>'Customer evaluation',
'partner'=>'Partner',
'see'=>'See',
'recent news'=>'Recent news',
'service items'=>'Service Items',
'successful case'=>'Successful case',
'successful case text'=>'The following cases were developed by the rain fly studio, part of the design inspiration and material from the network, if you do not want to see your case here, please contact us. More successful case is finishing, please continue to pay attention to. If you have any need, you can contact us at any time......',
'index one'=>'Our philosophy',
'index one text'=>'Customer oriented, excellent service, and strive for the first!',
'index two'=>'Our goal',
'index two text'=>'Extraordinary to create a miracle, the results of a breakthrough in the dream!',
'index three'=>'Our management',
'index three text'=>'There is no perfect person, but only the perfect team!',
'about us'=>'About us',
'current location'=>'Current location',
'home'=>'Home',
'team introduction'=>'Team Introduction',
'our advantage'=>'Our advantage',
'our advantage one'=>'Deep technical strength',
'our advantage two'=>'Rich experience',
'our advantage three'=>'Efficient operation process',
'our advantage four'=>'Perfect service system',
'our advantage five'=>'Many successful cases',
'phone'=>'Phone',
'email'=>'Email',
'address'=>'Add',
'homepage'=>'Homepage',
'personal center'=>'Personal Center',
'sign out'=>'Sign out',
'login'=>'Login',
'weibo login'=>'Weibo login',
'qq login'=>'QQ login',
'register'=>'Register',
'scan QR code'=>'Scan QR code',
'scan'=>'Scan',
'contact us'=>'Contact us',
'link'=>'Friendship link',
'search'=>'Search',
'result'=>'News',
'search result'=>'Search result',
'news copyright'=>'Note: This article is reproduced from %s, reproduced in the purpose of passing more information, does not mean that this network agrees with its view and responsible for its authenticity. If there is infringement, please contact us, we will promptly delete.',
'last news'=>'Last news',
'next news'=>'Next news',
'our location'=>'Our location',
'online message'=>'Online Message',
'username'=>'Username',
'content'=>'Content',
'captcha'=>'Captcha',
'click to get'=>'Click to get',
'send message'=>'Send message',
'contact information'=>'Contact information',
'working hours'=>'Working hours',
'Monday ~ Friday'=>'Monday ~ Friday',
'Saturday'=>'Saturday',
'Sunday'=>'Sunday',
'rest'=>'Rest',
'work flow'=>'Work flow',
'design'=>'Design',
'development phase'=>'Development phase',
'test and acceptance'=>'Test and acceptance',
'flow one'=>'1 negotiation website content, modify and supplement, we set out to reach a consensus </br>2 website construction scheme </br>3 station to determine both the details and price </br>4 the two sides signed the "agreement on the construction site" </br>5 customer payment (30%) </br>6 customers according to the first phase of research provide website related information to complete the first step of sample design </br>',
'flow two'=>'1 according to our "website construction plan" to complete the site </br>2 sample customer payment in advance (40%) </br>3 home page, channel home page, basic page, website structure figure </br>4 customer verification sample </br>5 for customers to register the domain name </br>6 and second stage </br>',
'flow three'=>'1 we completed our website </br>2 to complete the site test, improve the </br>3 site local consultation between the two sides through testing, the customer to confirm customer acceptance of </br>4 website, the website customer </br>5 issued "website construction acceptance confirmation" </br>6 customers pay the balance, the net station opened </br>',
'center'=>'Center',
'modify information'=>'Modify info',
'modify pwd'=>'Modify password',
'bind account'=>'Bind account',
'my favorites'=>'My favorites',
'my comments'=>'My comments',
'hot articles'=>'Hot news',
'recent articles'=>'Last news',
'recent comments'=>'CMT',
'ads contribution'=>'Ads Contribution',
'error'=>'Error!',
'reason'=>'Reason:',
'automatically'=>'Automatically',
'jump'=>'Jump',
'wait second'=>'Wait second:',
'comments'=>'Comments',
'send comments'=>'Send comments',
'need login to comment'=>'You need to log in before you can comment',
'register immediately'=>'Register immediately',
'anonymous'=>'Anonymous',
'just'=>'Just',
'reply'=>'Reply',
'cancel'=>'Cancel',
'ok'=>'OK',
'user login'=>'User login',
'username or email'=>'phone/email/username',
'remember'=>'Remember',
'forget password'=>'Forget password',
'nickname'=>'Nickname',
'without filled'=>'Without filled',
'score coin'=>'score(coin)',
'last login'=>'Last login',
'sex'=>'Sex',
'ProMonkey'=>'ProMonkey',
'ProMM'=>'ProMM',
'secrecy'=>'Secrecy',
'personal website'=>'Website',
'signature'=>'Signature',
'news title'=>'News title',
'comment content'=>'Comment content',
'comment time'=>'Comment time',
'account activation'=>'Account activation',
'account not activated'=>'Account is not activated',
'resend active email'=>'Resend active email?',
'resend now'=>'Resend email now!',
'bound qq'=>'Have bound qq',
'bind new qq'=>'Bind new qq',
'bound sina weibo'=>'Have bound sina weibo',
'bind new sina weibo'=>'Bind new sina weibo',
'member avatar'=>'Member avatar',
'program loading'=>'Program loading',
'pic effect'=>'Picture effect',
'save capture'=>'Save capture',
'reselection'=>'Re-select',
'turn R'=>'R',
'turn L'=>'L',
'original'=>'Original',
'Skin effect'=>'Skin',
'Sketch effect'=>'Sketch',
'Enhancement effect'=>'Enhance',
'Purple effect'=>'Purple',
'Soft focus'=>'Soft',
'Retro effect'=>'Retro',
'Black-white effect'=>'Black-W',
'Imitation LOMO'=>'LOMO',
'Bright white effect'=>'Bright-W',
'Grey-white effect'=>'G-W',
'Grey effect'=>'Grey',
'Warm autumn effect'=>'Warm',
'Wood carving effect'=>'Wood',
'Rough effect'=>'Rough',
);
Lang::set($lang_cn,null,'zh-cn');
Lang::set($lang_en,null,'en-us');
//以下为模板栏目设置
$home_adtype_id="1";//首页幻灯片(广告位置)id
$link_footer="1";//页脚友链类型id
//根据语言选择
switch ($lang) {
	case 'en-us':
		$portal_index_lastnews="12";//首页最近新闻分类cid
		$positive_cid="13";//客户好评分类cid
		$client_cid="13";//客户分类cid
		$lastportfolios_cid="10";//最近案例分类cid
		$services_cid="9";//服务项目cid
		$about_id="8";//公司简介单页面菜单id
		$portal_hot_articles="12,10";//右侧边栏热门文章分类cid,多个cid中间英文逗号分隔
		$portal_last_post="12,10";//右侧边栏最近发布文章分类cid,多个cid中间英文逗号分隔
	break;
	//其它语言
	case 'zh-cn':
	default:
		$portal_index_lastnews="5";//首页最近新闻分类cid
		$positive_cid="6";//客户好评分类cid
		$client_cid="6";//客户分类cid
		$lastportfolios_cid="3";//最近案例分类cid
		$services_cid="2";//服务项目cid
		$about_id="1";//公司简介单页面菜单id
		$portal_hot_articles="5,3";//右侧边栏热门文章分类cid,多个cid中间英文逗号分隔
		$portal_last_post="5,3";//右侧边栏最近发布文章分类cid,多个cid中间英文逗号分隔
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="default"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title><?php echo (isset($menu['menu_seo_title']) && ($menu['menu_seo_title'] !== '')?$menu['menu_seo_title']:$site_seo_title); ?> <?php echo $site_name; ?></title>
    <meta name="keywords" content="<?php echo (isset($menu['menu_seo_key']) && ($menu['menu_seo_key'] !== '')?$menu['menu_seo_key']:$site_seo_keywords); ?>" />
    <meta name="description" content="<?php echo (isset($menu['menu_seo_des']) && ($menu['menu_seo_des'] !== '')?$menu['menu_seo_des']:$site_seo_description); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $yf_theme_path; ?>public/css/css.css">
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/main.js"></script>
</head>
<body>
    <!-- 头部 S -->
    <div class="header">

    </div>
    <!-- 头部 E -->
    <!-- 导航 -->
    <div class="nav">
      <?php echo get_menu("main","","<a href='\$href' class='sf-with-ul'>\$menu_name</a>","<a href='#' class='sf-with-ul'>\$menu_name<span class='sf-sub-indicator'>&nbsp;<i class='fa fa-angle-down'></i></span></a>","","","w1000","6","");?>

    </div>

</head>

<body class="body-white">
<div class="wrap">
	<header id="header">
    <div class="top-bar">
        <div class="slidedown collapse">
            <div class="container">
                <div class="phone-email pull-left">
                    <a><i class="fa fa-phone"></i><?php echo lang('phone'); ?>: <?php echo $site_tel; ?></a>
                    <a href="mailto:<?php echo $site_admin_email; ?>"><i class="fa fa-envelope"></i><?php echo lang('email'); ?>: <?php echo $site_admin_email; ?></a>
                </div>
                <div class="pull-right">
					<?php if(config('lang_switch_on')): ?>
                    <div class="phone-email pull-left">
                        <?php if($lang == 'en-us'): ?>
                        <a href="<?php echo url('home/Index/lang',array('lang_s'=>'cn')); ?>" class="js-lang-btn"><i class="fa fa-angle-double-right">中文简体</i></a>
                        <?php else: ?>
                        <a href="<?php echo url('home/Index/lang',array('lang_s'=>'en')); ?>" class="js-lang-btn"><i class="fa fa-angle-double-right">ENGLISH</i></a>
                        <?php endif; ?>
                    </div>
					<?php endif; ?>
                    <div id="search-form" class="pull-right">
                        <form action="<?php echo url('home/Listn/search'); ?>" class="search-ajaxform" method="post">
                            <input type="text" class="search-text-box" name="keyword" value="<?php echo input('keyword'); ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="topnav navbar-header">
                <a class="navbar-toggle down-button" data-toggle="collapse" data-target=".slidedown">
                    <i class="fa fa-angle-down icon-current"></i>
                </a>
            </div>
            <div class="logo pull-left">
                <h1>
                    <a href="__ROOT__/">
						<img src="<?php echo get_imgurl($site_logo); ?>" alt="logo" style="margin-top:-14px;height:86px;">
                    </a>
                </h1>
            </div>
            <div class="mobile navbar-header">
                <a class="navbar-toggle" data-toggle="collapse"  data-target=".menu">
                    <i class="fa fa-reorder icon-2x"></i>
                </a>
            </div>
            <nav class="collapse navbar-collapse menu">
                <?php echo get_menu("main","","<a href='\$href' class='sf-with-ul'>\$menu_name</a>","<a href='#' class='sf-with-ul'>\$menu_name<span class='sf-sub-indicator'>&nbsp;<i class='fa fa-angle-down'></i></span></a>","","","nav navbar-nav sf-menu","6","");?>
				<ul class="nav navbar-nav sf-menu">
                    <?php if(!empty($user['member_list_id'])): ?>
                        <li style="height:86px">
                            <a href="#" class="sf-with-ul menu-login">
								<img src="<?php echo get_imgurl($user['member_list_headpic'],1); ?>" class="img-thumbnail headicon"/>
                                <span class="user-nicename"><?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?></span>
							<span class="sf-sub-indicator">
                           <i class="fa fa-angle-down "></i>
                           </span>
                            </a>
                            <ul>
                                <li><a href="<?php echo url('home/Center/index'); ?>"><i class="fa fa-user"></i> &nbsp;<?php echo lang('personal center'); ?></a></li>
                                
								<?php if($is_admin): ?>
								<li><a href="<?php echo url('home/admin/Index/index'); ?>" target="_blank"><i class="fa fa-tachometer"></i> &nbsp;<?php echo lang('admin manage'); ?></a></li>
								<?php endif; ?>
								<li><a href="<?php echo url('home/Login/logout'); ?>"><i class="fa fa-sign-out"></i> &nbsp;<?php echo lang('sign out'); ?></a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="#" class="sf-with-ul menu-login">
                                <img src="<?php echo $yf_theme_path; ?>public/images/headicon.png" class="img-thumbnail headicon"/><?php echo lang('login'); ?>
						<span class="sf-sub-indicator">
                           <i class="fa fa-angle-down "></i>
                           </span>
                            </a>
                            <ul>
                                <?php if(config('think_sdk_sina.display')): ?>
								<li><a href="<?php echo url('home/Oauth/login',array('type'=>'sina')); ?>"><i class="fa fa-weibo"></i> &nbsp;<?php echo lang('weibo login'); ?></a></li>
								<?php endif; if(config('think_sdk_qq.display')): ?>
                                <li><a href="<?php echo url('home/Oauth/login',array('type'=>'qq')); ?>"><i class="fa fa-qq"></i> &nbsp;<?php echo lang('qq login'); ?></a></li>
								<?php endif; if(config('think_sdk_facebook.display')): ?>
                                <li><a href="<?php echo url('home/Oauth/login',array('type'=>'facebook')); ?>"><i class="fa fa-qq"></i> &nbsp;<?php echo lang('facebook login'); ?></a></li>
                                <?php endif; if(config('think_sdk_weixin.display')): ?>
                                <li><a href="<?php echo url('home/Oauth/login',array('type'=>'weixin')); ?>"><i class="fa fa-qq"></i> &nbsp;<?php echo lang('weixin login'); ?></a></li>
                                <?php endif; if(config('think_sdk_wechat.display')): ?>
                                <li><a href="<?php echo url('home/Oauth/login',array('type'=>'wechat')); ?>"><i class="fa fa-qq"></i> &nbsp;<?php echo lang('wechat login'); ?></a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo url('home/Login/index'); ?>"><i class="fa fa-sign-in"></i> &nbsp;<?php echo lang('login'); ?></a></li>
                                <li><a href="<?php echo url('home/Register/index'); ?>"><i class="fa fa-user"></i> &nbsp;<?php echo lang('register'); ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
	<div id="main-cmf">
		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-10 col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-1 animate_afr">
						<h2 class="text-center"><?php echo lang('forget password'); ?></h2>
						<div class="widget tabs">
							<div id="horizontal-tabs">
								<div class="contents">
									<div class="tabscontent" id="content1" style="display: block;">
										<form class="form-light verify-ajax-form" id="forgot" action="<?php echo url('home/Login/runforgot_pwd'); ?>" method="post">
											<div>
												<input type="text" id="input_username" name="member_list_username" placeholder="<?php echo lang('username or email'); ?>" class="form-control" required>
											</div>
											<div>&nbsp;</div>
											<div>
												<input type="email" id="input_email" name="member_list_email" placeholder="<?php echo lang('email'); ?>" class="form-control" required>
											</div>
											<div>&nbsp;</div>
											<div class="row">
												<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
													<input type="text" class="form-control" placeholder="" id="verify" style="height:40px;" name="verify" required>
												</div>
												<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<img class="verify_img" id="verify_img" src="<?php echo url('home/Login/verify_forgot'); ?>" onClick="this.src='<?php echo url('home/Login/verify_forgot'); ?>'+'?'+Math.random()" style="cursor: pointer;width:100%;border: 1px solid #d5d5d5;height:40px;" title="<?php echo lang('click to get'); ?>">
												</div>
											</div>
											<div>&nbsp;</div>
											<div>
												<button class="btn btn-primary col-lg-12 col-md-12 col-sm-12 col-xs-12" type="submit"><?php echo lang('ok'); ?></button>

											</div>
											<div>&nbsp;</div>
											<div style="text-align: center;">
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<a href="<?php echo url('home/Register/index'); ?>"><?php echo lang('register immediately'); ?></a>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<a href="<?php echo url('home/Login/index'); ?>"><?php echo lang('login'); ?></a>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer S -->
<div class="printHide footer">
    <p>学院微博：@广东农工商学院发布@广东农工商职业技术学院</p>
    <p>粤垦路校区地址：广州市天河区粤垦路198号 增城校区地址：广州增城市中新镇风光路393号</p>
    <p class="copy">版权所有：广东农工商职业技术学院 备案号：4401060500008</p>
</div>
<!-- footer E -->
</body>

<script>
    $(function(){
        var time = null,index=0;
        $(".banner ol li").on("click",function(){
            var i = $(this).index();
            $('.banner ul li').eq(i).fadeIn().siblings("li").fadeOut();
            $(this).addClass("active").siblings("li").removeClass("active");
            i = index;
        })
        run();
        function run (){
            time = setInterval(function(){
                i = ++index > $(".banner ol li").length-1 ? 0 : index;
                 $('.banner ul li').eq(i).fadeIn().siblings("li").fadeOut();
                 $(".banner ol li").eq(i).addClass("active").siblings("li").removeClass("active");
                i = index;
            },1000)
        }
        $(".banner").hover(function(){
            clearInterval(time);
        },function(){
            run();
        });
        var se_i =  $(".fb-seamless-con li").length;
        var se_t = null;
        var se_long = 0;
        $(".fb-seamless-con ul").append($(".fb-seamless-con ul").html());
        se_run();
        function se_run(){
            se_t = setInterval(function(){
                se_long += 1;
                $(".fb-seamless-con ul").css("left",-se_long);
                if(se_long >= se_i*195){
                    $(".fb-seamless-con ul").css("left",0);
                    se_long = 0;
                }
            },20)
        }
        $(".fb-seamless-con").hover(function(){
            clearInterval(se_t);
        },function(){
            se_run();
        })
    })
    function mbar(sobj){
        var docurl =sobj.options[sobj.selectedIndex].value;
        if (docurl != "") {
           open(docurl,'_blank');
           sobj.selectedIndex=0;
           sobj.blur();
        }
    }
</script>
<script>
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
   setInterval(function(){
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
   },1000);
   $(".personal_table input").blur(function(){
    var value  = $(this).val();
    var name = $(this).attr('name');
    if($(this).hasClass("noBlur")){
        return false;
    }else{
        $.post("<?php echo url('home/center/update_info'); ?>",{'name':name,'value':value},function(data){
            if($("."+name).length>0){
                $("."+name).text(value);
            }
            console.log(data);
         });
    }

   });
   $(".personal_table input").bind('input propertychange', function() {
        var valType = $(this).attr("valType");
        var leng = $(this).attr("leng");
        var val = $(this).val();
        if(valType == undefined){
            return false;
        }
        if(valType == "n"){
            //只能填数字
            if(isNaN(val)){
                if(isNaN(parseFloat(val))){
                    $(this).val("");
                }else {
                    $(this).val(parseFloat(val));
                }

            }
        }
        if(leng != undefined){
            $(this).val($(this).val().substring(0,leng));
        }
    });
    $("#sexSelect").change(function(){
        var val = $(this).val();
        $('[name="sex"]').val(val);
        $('[name="sex"]').blur();
    })
</script>
<script>

function check_preview(oper)
{
    if(confirm("只能打印一次，确定打印么？"))
    {
        preview(oper);
    }
}
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
/*
$(".pro_img").on('click','.img_close',function (e) {
        new upField($(this)).del();
    })

$("body").on('change','.upload',function (e) {
    var field=new upField($(this));
    var maxSize=500; //kb
    var name=$(this).attr('name');
    var pic = $(this).prop('files');
    var fordata=new FormData();
    fordata.append('imgFile',pic[0]); //添加字段



   if(pic[0].size/1024>maxSize) {
        field.addErr('图片不能超过'+maxSize+'kb')
        return false;
   }

    $.ajax({
        url:"<?php echo url('home/center/avatar'); ?>",
        //url:'http://183.71.200.186:8084/upload_json.asp',
        type:'POST',
        dataType:'json',
        data:fordata,
        processData: false,
        contentType: false,
        error: function(){
            field.addErr('未知错误')
        },


        success: function(data){
            if(data.error==0){
                // field.add(e.url,name);
                $("#studentPicture_herf_show").attr("src",data.url)
            }else{

                field.addErr(e.message);
            }
        }
    })

})

function upField(doc){
    var self=this;
    this.waitTime=3000;  //错误信息 显示时长
    this.doc=doc;

    this.addErr = function (message) {
        var error=this.doc.parent(".img").find('.error');
        error.html(message).show();
        setTimeout(function () {
            error.html('').hide();
        },3000)
    };

    this.add=function (img,name) {
          var template='<div class="img_close" name="'+name+'"></div>';
          template+='<img src="'+img+'" alt="">';
          this.doc.parent(".img").html(template);
          //添加input
          var input='<input name='+name+' type="hidden" value='+img+' class="up-item">';
          $("#myform").append(input);


    };
    this.del = function () {
            var img=this.doc.parent(".img");
            var name=img.find(".img_close").attr('name');
            var template='<input name="'+name+'" type="file" id="'+name+'" class="upload">';
            template+='<span>+</span>';
            template+='<div class="error"></div> ';
            img.html(template);
            $(".up-item[name="+name+"]")[0]&&$(".up-item[name="+name+"]").remove();
    };


}


*/
</script>
</html>

</div>
<script src="<?php echo $yf_theme_path; ?>public/js/jquery.min.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/bootstrap.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/jquery.parallax.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/modernizr-2.6.2.min.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/jquery.nivo.slider.pack.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/superfish.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/circularnav.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/jflickrfeed.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/waypoints.min.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/spectrum.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/tytabs.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/custom.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/portfolio.js"></script> 
<script src="<?php echo $yf_theme_path; ?>public/js/qrcode.min.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/jquery.sticky.js"></script>
<script src="__PUBLIC__/others/jquery.form.js"></script>
<script src="__PUBLIC__/layer/layer_<?php echo $lang; ?>.js"></script>



    
    
    

</body>
</html>