<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\score\ajax_recruit_score_all.html";i:1495100573;}*/ ?>
<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td class="hidden-xs" height="28" >
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
            <span class="lbl"></span>
        </label><?php echo $v['member_list_id']; ?>
    </td>
    <td><?php echo $v['ZexamineeNumber']; ?></td>
    <td><?php echo $v['member_list_nickname']; ?></td>
    <td height="28" ><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['school_name']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <td><?php echo $v['recruit_major_name']; ?></td>
    <td>
        <?php echo $v['recruit_score']; ?>
    </td>
    <td><?php echo $v['status_desc']; ?></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td height="50" align="center">
        <!-- <button  class="btn btn-primary btn-sm hidden-xs btn-active">通过</button> -->
        <button id="btnsubmit" class="btn btn-danger btn-sm hidden-xs btn-unactive">驳回审核</button>
    </td>
    <td colspan="20" align="center"><?php echo $page; ?></td>
</tr>
