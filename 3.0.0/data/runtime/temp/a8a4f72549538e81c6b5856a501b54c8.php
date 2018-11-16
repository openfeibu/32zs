<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/score/ajax_sec_vocat_recruit_score_list.html";i:1527078116;}*/ ?>
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
    <td><?php echo $recruit_major['recruit_major_name']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <td><?php echo $v['recruit_score']; ?></td>
    <td><span class="status_<?php echo $v['member_list_id']; ?>"><?php echo $v['status_desc']; ?></span></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr><td colspan="20"><div class="fb-page"><?php echo $page; ?></div></td></tr>
