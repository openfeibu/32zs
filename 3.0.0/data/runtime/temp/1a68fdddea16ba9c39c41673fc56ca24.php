<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/member/ajax_member_list.html";i:1526916296;}*/ ?>
<?php if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr>
		<td  height="28" >
			<label class="pos-rel">
				<input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
				<span class="lbl"></span>
			</label>
		</td>
		<td><?php echo $v['member_list_id']; ?></td>

		<td><a class=""  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改"><?php echo $v['member_list_nickname']; ?></a></td>
		<td><?php echo $v['ZexamineeNumber']; ?></td>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo $v['school_name']; ?></td>
		<td><?php echo $v['major_name']; ?></td>
		<td><?php echo $v['recruit_major_name']; ?></td>
		<!-- <td><input type="text" name="GexamineeNumber" value="<?php echo $v['GexamineeNumber']; ?>"  class="member_GexamineeNumber" data-id="<?php echo $v['member_list_id']; ?>" url="<?php echo url('admin/Member/member_edit_GexamineeNumber',['member_list_id' => $v['member_list_id']]); ?>"/></td> -->

		<td >
			<?php if($v['user_status'] == 1): ?>
				<a class="red active-btn" href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="已通过">
					<div id="jh<?php echo $v['member_list_id']; ?>">
						<button class="btn btn-minier btn-fb-blue">已审核</button>
					</div>

				</a>
				<?php else: ?>
				<a class="red active-btn" href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="未通过">
					<div id="jh<?php echo $v['member_list_id']; ?>">
						<button class="btn btn-minier btn-fb-orange">未审核</button>
					</div>

				</a>
			<?php endif; ?>
		</td>
		<td>
			<div class="action-buttons">
				<a  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改">
					<i class="ace-icon fa fa-edit bigger-130"></i>
				</a>
				<a class=" confirm-rst-url-btn" href="<?php echo url('admin/Member/member_del',array('member_list_id'=>$v['member_list_id'],'p'=>input('p',1))); ?>" data-info="确定要删除吗？" title="删除">
					<i class="ace-icon fa fa-trash-o bigger-130"></i>
				</a>
			</div>

		</td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr><td colspan="20"><div class="fb-page"><?php echo $page; ?></div></td></tr>
