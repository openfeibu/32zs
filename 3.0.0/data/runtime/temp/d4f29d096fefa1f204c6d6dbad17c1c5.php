<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/score/ajax_recruit_score_import.html";i:1526442578;}*/ ?>
<input name="school_id" value="<?php echo input('school_id',''); ?>" type="hidden" />
<?php if(isset($data) && $data): ?>
<tr>
    <th></th>
    <th width="60px">ID</th>
    <th>姓名</th>
    <th>身份证</th>
    <th>中职学校</th>
    <th>中职专业</th>
    <th>技能考核成绩</th>
</tr>
<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td></td>
    <td><input name="n_id[]" class="ace" type="hidden" value="<?php echo $v['member_list_id']; ?>"><?php echo $v['member_list_id']; ?></td>
    <td height="28" ><?php echo $v['member_list_nickname']; ?></td>
    <td><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['school_name']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <td><input type="text" name="recruit_score[]" value="<?php echo $v['recruit_score']; ?>" class="score_input" data-id="<?php echo $v['member_list_id']; ?>"></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr ><td colspan="20" align="center"><button class="btn btn-fb-blue fb-radio" type="submit" style="width:100px;">确认后提交</button></td></tr>
<?php else: endif; ?>
