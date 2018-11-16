<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\matriculate\ajax_list.html";i:1492828493;}*/ ?>
<?php if(!empty($member_list)): if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo $v['member_list_nickname']; ?></td>
		<td><?php echo $v['recruit_major_name']; ?></td>
		<td><?php echo $v['major_score_total']; ?></td>
		<td><?php echo $v['recruit_score']; ?></td>
		<td><?php echo $v['total_score']; ?></td>
        <td><?php echo $v['ranking']; ?></td>
		<td><?php echo $v['admission_status_desc']; ?></td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; else: ?>
	<tr>
		<td colspan="8" align="center">暂无数据，请选择学校及高职专业</td>
	</tr>
<?php endif; ?>
