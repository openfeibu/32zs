<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/score/ajax_major_score_import.html";i:1525062622;}*/ ?>
<input name="major_id" value="<?php echo input('major_id',''); ?>" type="hidden" />
<?php if(isset($data) && $data): ?>

<tr>
    <th></th>
    <th>考生ID</th>
    <th>姓名</th>
    <th>身份证</th>
    <th>中职专业</th>
    <?php if(is_array($major_score) || $major_score instanceof \think\Collection || $major_score instanceof \think\Paginator): if( count($major_score)==0 ) : echo "" ;else: foreach($major_score as $key=>$v): ?>
    <th align="center"><?php echo $v; ?> </th>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</tr>

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td></td>
    <td><input name="n_id[]" class="ace" type="hidden" value="<?php echo $v['member_list_id']; ?>"><?php echo $v['member_list_id']; ?></td>
    <td><?php echo $v['member_list_nickname']; ?></td>
    <td height="28" ><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <?php if(is_array($v['major_score_arr']) || $v['major_score_arr'] instanceof \think\Collection || $v['major_score_arr'] instanceof \think\Paginator): if( count($v['major_score_arr'])==0 ) : echo "" ;else: foreach($v['major_score_arr'] as $key=>$val): ?>
    <td data-id="<?php echo $v['member_list_id']; ?>"><input name="major_score_<?php echo $v['member_list_id']; ?>[]" value="<?php echo $val; ?>" class="major_score score_input"> </td>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr ><td colspan="20" align="center"><button class="btn btn-fb-blue fb-radio" type="submit" style="width:100px;">确认后提交</button></td></tr>
<?php else: endif; ?>
