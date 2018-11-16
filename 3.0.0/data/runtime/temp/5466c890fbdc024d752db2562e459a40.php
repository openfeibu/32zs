<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/score/ajax_recruit_score_list.html";i:1524739191;}*/ ?>
<input name="school_id"  value="<?php echo input('school_id',''); ?>" type="hidden" />
<input name="major_id"  value="<?php echo input('major_id',''); ?>" type="hidden" />

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td class="hidden-xs" height="28" >
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
            <span class="lbl"></span>
        </label>
    </td>
    <td><?php echo $v['member_list_id']; ?></td>
    <td height="28" ><?php echo $v['member_list_nickname']; ?></td>
    <td><?php echo $v['ZexamineeNumber']; ?></td>
    <td><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['school_name']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <td><input type="text" name="recruit_score" value="<?php echo $v['recruit_score']; ?>" class="recruit_score score_input" data-id="<?php echo $v['member_list_id']; ?>" <?php if($v['recruit_score_status'] ==1): ?>disabled<?php endif; ?>></td>
   <td><span class="status_<?php echo $v['member_list_id']; ?>"><?php echo $v['status_desc']; ?></span></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr><td colspan="20"><div class="fb-page"><?php echo $page; ?></div></td></tr>
