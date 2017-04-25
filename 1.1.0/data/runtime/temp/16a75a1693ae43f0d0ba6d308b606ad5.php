<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\score\ajax_recruit_score_list.html";i:1493051951;}*/ ?>
<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td><?php echo $v['ZexamineeNumber']; ?></td>
    <td height="28" ><?php echo $v['member_list_nickname']; ?></td>
    <td><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['school_name']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <td><input type="text" name="recruit_score" value="<?php echo $v['recruit_score']; ?>" class="recruit_score" data-id="<?php echo $v['member_list_id']; ?>" <?php if($v['recruit_score_status'] ==1): ?>disabled<?php endif; ?>></td>
   <td><span class="status_<?php echo $v['member_list_id']; ?>"><?php echo $v['status_desc']; ?></span></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td colspan="20" align="center"><?php echo $page; ?></td>
</tr>
