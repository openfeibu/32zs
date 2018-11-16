<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\score\ajax_score_list.html";i:1493117659;}*/ ?>
<?php if($data): ?>

<tr>
    <th>中职考生号</th>
    <th>姓名</th>
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
    <td><a href="<?php echo url('admin/score/score_add',array('member_list_id'=>$v['member_list_id'])); ?>"><?php echo $v['ZexamineeNumber']; ?></a></td>
    <td height="28" ><?php echo $v['member_list_nickname']; ?></td>
    <td><?php echo $v['member_list_username']; ?></td>
    <td><?php echo $v['major_name']; ?></td>
    <?php if(is_array($v['major_score_arr']) || $v['major_score_arr'] instanceof \think\Collection || $v['major_score_arr'] instanceof \think\Paginator): if( count($v['major_score_arr'])==0 ) : echo "" ;else: foreach($v['major_score_arr'] as $key=>$val): ?>
    <td><?php echo $val; ?> </td>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
    <td><?php echo $v['major_score_total']; ?></td>
    <td><?php echo $v['status_desc']; ?></td>
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
    <td height="50" colspan="20" align="center"><?php echo $page; ?></td>
</tr>
<?php else: ?>
<tr>
    <td height="50" colspan="20" align="center">暂无数据，请选择中职学校及中职专业</td>
</tr>
<?php endif; ?>
