<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"D:\UPUPW\htdocs\zs\1.1.0/app/admin\view\score\ajax_score_list.html";i:1495084390;}*/ ?>
<?php if($data): ?>

<tr>
    <th class="hidden-xs ">
        <label class="pos-rel">
            <input type="checkbox" class="ace" id="chkAll" onclick="CheckAll(this.form)" value="全选">
            <span class="lbl"></span>
        </label>
        ID
    </th>
    <th>姓名</th>
    <th>中职考生号</th>
    <th>身份证</th>
    <th>中职专业</th>
    <?php if(is_array($major_score) || $major_score instanceof \think\Collection || $major_score instanceof \think\Paginator): if( count($major_score)==0 ) : echo "" ;else: foreach($major_score as $key=>$v): ?>
    <th><?php echo $v; ?> </th>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <th>核定理论成绩</th>
    <th>成绩审核状态</th>
</tr>

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$v): ?>
<tr>
    <td class="hidden-xs" height="28" >
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $v['member_list_id']; ?>">
            <span class="lbl"></span>
        </label><?php echo $v['member_list_id']; ?>
    </td>
    <td><?php if($v['major_score_status'] ==1): ?><?php echo $v['member_list_nickname']; else: ?><a href="<?php echo url('admin/score/score_add',array('member_list_id'=>$v['member_list_id'])); ?>"><?php echo $v['member_list_nickname']; ?></a><?php endif; ?></td>
    <td><?php echo $v['ZexamineeNumber']; ?></td>
    <td height="28" ><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <?php if(is_array($v['major_score_arr']) || $v['major_score_arr'] instanceof \think\Collection || $v['major_score_arr'] instanceof \think\Paginator): if( count($v['major_score_arr'])==0 ) : echo "" ;else: foreach($v['major_score_arr'] as $key=>$val): ?>
    <td data-id="<?php echo $v['member_list_id']; ?>"><input name="major_score[]" value="<?php echo $val; ?>" <?php if($v['major_score_status']==1): ?>disabled<?php endif; ?> class="major_score score_input" > </td>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
    <td><?php echo $v['major_score_total']; ?></td>
    <td class="status_<?php echo $v['member_list_id']; ?>"><?php echo $v['status_desc']; ?></td>
    <!-- <td>
        <div class="hidden-sm hidden-xs action-buttons">
            <a class="green" href="<?php echo url('admin/score/score_add',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改">
                <i class="ace-icon fa fa-pencil bigger-130"></i>
            </a>
            <a class="red confirm-rst-url-btn" data-info="你确定要删除吗？" href="<?php echo url('admin/score/score_del',array('member_list_id'=>$v['member_list_id'])); ?>" title="删除">
                <i class="ace-icon fa fa-trash-o bigger-130"></i>
            </a>
        </div>
    </td> -->
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td height="50" align="center">
        <button id="btnsubmit" class="btn btn-white btn-blue btn-sm hidden-xs btn-active">通过审核</button>
    </td>
    <td height="50" colspan="20" align="center"><?php echo $page; ?></td>
</tr>
<?php else: ?>
<tr>
    <td height="50" colspan="20" align="center">暂无数据</td>
</tr>
<?php endif; ?>
