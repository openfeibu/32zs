<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/member/university_ajax_member_list.html";i:1542348609;}*/ ?>
<?php if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr>
		<td class="hidden-xs" height="28" >
			<label class="pos-rel">
				<input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
				<span class="lbl"></span>
			</label>
		</td>
		<td><?php echo $v['member_list_id']; ?></td>
		<td><a class=""  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改"><?php echo $v['member_list_nickname']; ?></a></td>
		<td><?php echo $v['ZexamineeNumber']; ?></td>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo $v['major_name']; ?>(<?php echo $v['major_code']; ?>)</td>
		<td><?php echo $v['recruit_major_name']; ?>(<?php echo $v['recruit_major_code']; ?>)</td>
		<td class="hidden-xs">
			<?php echo config("status")[$v['user_status']] ?>
		</td>
		<td>
			<div class="hidden-sm hidden-xs action-buttons">
				<a class=""  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改">
					<i class="ace-icon fa fa-edit bigger-130"></i>
				</a>
			</div>
		</td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr><td colspan="20"><div class="fb-page"><?php echo $page; ?></div></td></tr>
