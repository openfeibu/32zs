<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\member\ajax_member_list.html";i:1493889003;}*/ ?>
<?php if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr>
		<td class="hidden-xs" height="28" >
			<label class="pos-rel">
				<input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
				<span class="lbl"></span>
			</label><?php echo $v['member_list_id']; ?>
		</td>
		<td><a class=""  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改"><?php echo $v['member_list_nickname']; ?></a></td>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo $v['school_name']; ?></td>
		<td><?php echo $v['major_name']; ?></td>
		<td><?php echo $v['recruit_major_name']; ?></td>
		<td><input type="text" name="GexamineeNumber" value="<?php echo $v['GexamineeNumber']; ?>"  class="member_GexamineeNumber" data-id="<?php echo $v['member_list_id']; ?>" url="<?php echo url('admin/Member/member_edit_GexamineeNumber',['member_list_id' => $v['member_list_id']]); ?>"/></td>

		<td class="hidden-xs">
			<?php if($v['user_status'] == 1): ?>
				<a class="red active-btn" href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="已通过">
					<div id="jh<?php echo $v['member_list_id']; ?>">
						<button class="btn btn-minier btn-yellow">已通过</button>
					</div>

				</a>
				<?php else: ?>
				<a class="red active-btn" href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="未通过">
					<div id="jh<?php echo $v['member_list_id']; ?>">
						<button class="btn btn-minier btn-danger">未通过</button>
					</div>

				</a>
			<?php endif; ?>
		</td>
		<td>
			<div class="hidden-sm hidden-xs action-buttons">
				<a class="green"  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改">
					<i class="ace-icon fa fa-pencil bigger-130"></i>
				</a>
				<a class="red confirm-rst-url-btn" href="<?php echo url('admin/Member/member_del',array('member_list_id'=>$v['member_list_id'],'p'=>input('p',1))); ?>" data-info="你确定要删除吗？" title="删除">
					<i class="ace-icon fa fa-trash-o bigger-130"></i>
				</a>
			</div>
			<div class="hidden-md hidden-lg">
				<div class="inline position-relative">
					<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
						<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
					</button>
					<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="修改">
											<span class="green">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</span>
							</a>
						</li>

						<li>
							<a href="<?php echo url('admin/Member/member_del',array('member_list_id'=>$v['member_list_id'],'p'=>input('p',1))); ?>"  class="tooltip-error confirm-rst-url-btn" data-info="你确定要删除吗？" data-rel="tooltip" title="" data-original-title="删除">
											<span class="red">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
	<td align="left" class="hidden-xs center"><button id="btnsubmit" class="btn btn-white btn-blue btn-sm hidden-xs">删除</button>&nbsp;</td>
	<td colspan="12" align="center" class="hidden-xs"><?php echo $page; ?></td>
</tr>
