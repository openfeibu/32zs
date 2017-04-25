<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/home/view/default/\\ajax_list.html";i:1490540414;}*/ ?>
<ul class="fb-list-ul">
		<?php if(is_array($lists['news']) || $lists['news'] instanceof \think\Collection || $lists['news'] instanceof \think\Paginator): $i = 0; $__LIST__ = $lists['news'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<li><a href="<?php echo url('home/News/index',array('id'=>$vo['n_id'])); ?>"><p><?php echo $vo['news_title']; ?></p><span><?php echo date("Y-m-d",$vo['news_time']); ?></span></a></li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<div class="fb-page">
		<?php echo $page_html; ?>
</div>
