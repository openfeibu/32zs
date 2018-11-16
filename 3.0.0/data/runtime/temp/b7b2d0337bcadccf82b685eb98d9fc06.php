<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/matriculate/ajax_list.html";i:1524761350;}*/ ?>
<?php if(!empty($member_list)): $i=0; if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr <?php if($v['admission_status'] == 0 && $i == 0): ?> style=" border-top: 2px;border-top-color: #bb3f2b;border-top-style: double;"<?php endif; ?>>
		<td></td>
		<td><?php echo $v['member_list_nickname']; ?></td>
		<td><?php echo $v['ZexamineeNumber']; ?></td>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo $v['recruit_major_name']; ?></td>
		<td><?php echo $v['major_score_total']; ?></td>
		<td><?php echo $v['recruit_score']; ?></td>
		<td><?php echo $v['total_score']; ?></td>
        <td><?php echo $v['ranking']; ?></td>
		<td><?php echo $v['admission_status_desc']; ?></td>
	</tr>
	<?php if($v['admission_status'] == 0): $i++;endif; endforeach; endif; else: echo "" ;endif; else: ?>
	<tr>
		<td colspan="9" align="center">暂无数据，请选择中职学校及高职专业</td>
	</tr>
<?php endif; ?>
