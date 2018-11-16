<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/home/vagrant/Code/32zs/3.0.0/app/admin/view/score/ajax_score_list.html";i:1542204467;}*/ ?>
<?php if($data): ?>

<tr>
    <th  width="60px">
        <label class="pos-rel">
            <input type="checkbox" class="ace" id="chkAll" onclick="CheckAll(this.form)" value="全选">
            <span class="lbl"></span>
        </label>

    </th>
    <th width="60px">ID</th>
    <th>姓名</th>
    <th>中职考生号</th>
    <th>身份证</th>
    <th>中职专业</th>
    <?php if(is_array($major_subject_name_arr) || $major_subject_name_arr instanceof \think\Collection || $major_subject_name_arr instanceof \think\Paginator): if( count($major_subject_name_arr)==0 ) : echo "" ;else: foreach($major_subject_name_arr as $key=>$v): ?>
    <th align="center"><?php echo $v; ?> </th>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <th>核定理论成绩</th>
    <th>成绩审核状态</th>
</tr>

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td height="28" >
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
            <span class="lbl"></span>
        </label>
    </td>
    <td><?php echo $v['member_list_id']; ?></td>
    <td><?php if($v['major_score_status'] ==1): ?><?php echo $v['member_list_nickname']; else: ?><a href="<?php echo url('admin/score/score_add',array('member_list_id'=>$v['member_list_id'])); ?>"><?php echo $v['member_list_nickname']; ?></a><?php endif; ?></td>
    <td><?php echo $v['ZexamineeNumber']; ?></td>
    <td height="28" ><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <?php if(is_array($v['major_subject_score_arr']) || $v['major_subject_score_arr'] instanceof \think\Collection || $v['major_subject_score_arr'] instanceof \think\Paginator): if( count($v['major_subject_score_arr'])==0 ) : echo "" ;else: foreach($v['major_subject_score_arr'] as $key=>$val): ?>
    <td data-id="<?php echo $v['member_list_id']; ?>" subject-id="<?php echo $val['subject_id']; ?>" status="<?php echo $val['major_score_status']; ?>"><input name="major_score[]" value="<?php echo $val['score']; ?>" <?php if($val['major_score_status']==1): ?>disabled<?php endif; ?> class="major_score score_input" > </td>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
    <td><?php echo $v['major_score_total']; ?></td>
    <td class="status_<?php echo $v['member_list_id']; ?>"><?php echo $v['status_desc']; ?></td>
    <!-- <td>
        <div class="hidden-sm hidden-xs action-buttons">
            <a href="<?php echo url('admin/score/score_add',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改">
                <i class="ace-icon fa fa-edit bigger-130"></i>
            </a>
            <a class=" confirm-rst-url-btn" data-info="确定要删除吗？" href="<?php echo url('admin/score/score_del',array('member_list_id'=>$v['member_list_id'])); ?>" title="删除">
                <i class="ace-icon fa fa-trash-o bigger-130"></i>
            </a>
        </div>
    </td> -->
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr><td colspan="20"><div class="fb-page"><?php echo $page; ?></div></td></tr>
<?php else: ?>
<tr>
    <td height="50" colspan="20" align="center">暂无数据</td>
</tr>
<?php endif; ?>
<!-- <tr><td colspan="20"><div class="fb-page"><?php echo $page; ?></div></td></tr> -->
