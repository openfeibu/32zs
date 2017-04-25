<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/admin\view\school\ajax_major_list.html";i:1493056367;}*/ ?>
<?php if(is_array($major_list) || $major_list instanceof \think\Collection || $major_list instanceof \think\Paginator): if( count($major_list)==0 ) : echo "" ;else: foreach($major_list as $key=>$v): ?>
    <tr>
        <td height="28" ><?php echo $v['school_name']; ?></td>
        <td><?php echo $v['major_name']; ?></td>
        <td><?php echo $v['major_code']; ?></td>
        <td><?php echo $v['recruit_major_name']; ?></td>
        <td><?php echo $v['number']; ?></td>
        <td>
            <?php if(is_array($v['major_score']) || $v['major_score'] instanceof \think\Collection || $v['major_score'] instanceof \think\Paginator): if( count($v['major_score'])==0 ) : echo "" ;else: foreach($v['major_score'] as $key=>$val): ?>
                <span><?php echo $val; ?></span>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </td>
        <td>
            <div class="hidden-sm hidden-xs action-buttons">
                <a class="green" href="<?php echo url('admin/School/major_edit',array('major_id'=>$v['major_id'])); ?>" title="修改">
                    <i class="ace-icon fa fa-pencil bigger-130"></i>																</a>
                    <a class="red confirm-rst-url-btn" data-info="你确定要删除吗？" href="<?php echo url('admin/School/major_del',array('major_id'=>$v['major_id'])); ?>" title="删除">
                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                    </a>
            </div>
        </td>
    </tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td height="50" colspan="20" align="center"><?php echo $page; ?></td>
</tr>
