<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/member/member_table.html";i:1526060534;}*/ ?>
<style>
.personal_table{background: #fff;margin: auto 10%;width: 656px;}

.personal_table table input{width: 100%;height: 100%;border:none;outline:none;text-align: center;color: #666;font-weight: bolder;}
.line-table-height{
    height:30px;
}
.line-table-height2{
    height: 90px;
}
 .low_width_1{
    width:85px;
}
.low_width_2{
    width:85px;
}
.low_width_3{
    width:95px;
}
.low_width_4{
    width:95px;
}
.low_width_5{
    width:95px;
}
.low_width_6{
    width:105px;
}
.low_width_7{
    width:130px;
}
.title{
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    height:30px;
    line-height: 30px;
}
.content1{
    text-align: center;
    font-family: 仿宋;
    font-size: 12px;
    height:30px;
    line-height: 20px;
}
.content{
    text-align: center;
    font-family: 仿宋;
    font-size: 12px;
    height:30px;
    line-height: 30px;
}
.content_area{
    text-align: left;
    font-family: 仿宋;
    font-size: 14px;
}

.k-s-content{
    border:1px solid #999;
    text-align: center;
}
.k-w-table {
    border-style:solid;
    border-color:rgb(148, 192, 210);
/*  border-color:#ccc; */
    border-width:1px;
    border-collapse:collapse;
}


</style>
    <p style="text-align:center;">广东农工商职业技术学院</p>
    <p style="text-align:center">2018年中高职衔接三二分段招生报名表</p>

<table width="700px" class="k-w-table line_table member_table">
    <tbody><tr class="line-table-height">
        <td class="k-s-content low_width_1 title">姓  名</td>
        <td class="k-s-content low_width_2 content" style="font-weight: bold;
    font-size: 12px;"><?php echo $info['member_list_nickname']; ?></td>
        <td class="k-s-content low_width_3 title">性  别</td>
        <td class="k-s-content low_width_4 content"><?php echo $info['sex']; ?></td>
        <td class="k-s-content low_width_5 title">高考考生号</td>
        <td class="k-s-content low_width_6 content"><?php echo $info['GexamineeNumber']; ?></td>
        <td class="k-s-content low_width_7" rowspan="5" height='175px' width="120px"><img src="<?php echo get_imgurl2($info['member_list_headpic'],1); ?>"  style="height:175px;width:120px;"></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title">出生年月</td>
        <td class="k-s-content content"><?php echo $info['date']; ?></td>
        <td class="k-s-content title">民  族</td>
        <td class="k-s-content content"><?php echo $info['nation']; ?></td>
        <td class="k-s-content title">政治面貌</td>
        <td class="k-s-content content"><?php echo $info['politicalOutlook']; ?></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title">所在学校</td>
        <td class="k-s-content content1"  colspan="2">
            <?php echo $info['school_name']; ?>
        </td>
        <td class="k-s-content title">身份证号</td>
        <td class="k-s-content content" colspan="2"><?php echo $info['member_list_username']; ?></td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title">生源地</td>
       <td class="k-s-content content"><?php echo $info['documentType']; ?></td>
        <td class="k-s-content content title">户籍地</td>
        <td class="k-s-content content"><?php echo $info['domicile']; ?></td>
        <td class="k-s-content title">所在专业</td>
        <td class="k-s-content content"><?php echo $info['major_name']; ?></td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title">报考专业</td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['recruit_major_name']; ?></td>
        <td class="k-s-content title" colspan="1">中职考生号</td>
        <td class="k-s-content content1"><?php echo $info['ZexamineeNumber']; ?></td>
        <td class="k-s-content title" colspan="1">考生类别</td>
        <td class="k-s-content content1"><?php echo $info['candidateCategory']; ?></td>
    </tr>
    <!-- 第6行 -->
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="2">接收邮寄通知书地址</td>
        <td class="k-s-content content" colspan="5"><?php echo $info['address']; ?></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title">邮编</td>
        <td class="k-s-content content" colspan="1"><?php echo $info['zipCode']; ?></td>
        <td class="k-s-content title"  colspan="1">收件人</td>
        <td class="k-s-content content" colspan="1"><?php echo $info['addressee']; ?></td>
        <td class="k-s-content title" colspan="1">联系电话</td>
        <td class="k-s-content content" colspan="2"><?php echo $info['tell']; ?></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="3">技能证书名称</td>
        <td class="k-s-content title" colspan="1">级别</td>
        <td class="k-s-content title" colspan="2">颁发单位</td>
        <td class="k-s-content title" colspan="1">获得时间</td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content content1" colspan="3"><?php echo $info['certificate']['0']['certificateName']; ?></td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['certificate']['0']['certificateLevel']; ?></td>
        <td class="k-s-content content1" colspan="2"><?php echo $info['certificate']['0']['certificateCompany']; ?></td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['certificate']['0']['certificateDate']; ?></td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content content1" colspan="3"><?php echo $info['certificate']['1']['certificateName']; ?></td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['certificate']['1']['certificateLevel']; ?></td>
        <td class="k-s-content content1" colspan="2"><?php echo $info['certificate']['1']['certificateCompany']; ?></td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['certificate']['1']['certificateDate']; ?></td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content content1" colspan="3"><?php echo $info['certificate']['2']['certificateName']; ?></td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['certificate']['2']['certificateLevel']; ?></td>
        <td class="k-s-content content1" colspan="2"><?php echo $info['certificate']['2']['certificateCompany']; ?></td>
        <td class="k-s-content content1" colspan="1"><?php echo $info['certificate']['2']['certificateDate']; ?></td>
    </tr>

    <tr class="line-table-height">
        <td class="k-s-content title" colspan="7" style="text-align:left;text-indent:1em">简历（从初中开始写起）</td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="1">自何年何月</td>
        <td class="k-s-content title" colspan="1">至何年何月</td>
        <td class="k-s-content title" colspan="4">在何地、何单位学习或工作</td>
        <td class="k-s-content title" colspan="1">任何职务</td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['0']['resumeBeforeDate']; ?></td>
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['0']['resumeAfterDate']; ?></td>
        <td class="k-s-content content" colspan="4"><?php echo $info['resume']['0']['resumeWork']; ?></td>
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['0']['resumePost']; ?></td>

    </tr>
    <tr class="line-table-height">
         <td class="k-s-content content" colspan="1"><?php echo $info['resume']['1']['resumeBeforeDate']; ?></td>
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['1']['resumeAfterDate']; ?></td>
        <td class="k-s-content content" colspan="4"><?php echo $info['resume']['1']['resumeWork']; ?></td>
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['1']['resumePost']; ?></td>

    </tr>
    <tr class="line-table-height">
          <td class="k-s-content content" colspan="1"><?php echo $info['resume']['2']['resumeBeforeDate']; ?></td>
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['2']['resumeAfterDate']; ?></td>
        <td class="k-s-content content" colspan="4"><?php echo $info['resume']['2']['resumeWork']; ?></td>
        <td class="k-s-content content" colspan="1"><?php echo $info['resume']['2']['resumePost']; ?></td>

    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="7" style="text-align:left;text-indent:1em">获奖情况：</td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="1">时间</td>
        <td class="k-s-content title" colspan="4">奖项</td>
        <td class="k-s-content title" colspan="2">发证单位</td>

    </tr>
     <tr class="line-table-height">
        <td class="k-s-content content" colspan="1"><?php echo $info['prize']['0']['prizeDate']; ?></td>
        <td class="k-s-content content" colspan="4"><?php echo $info['prize']['0']['prizeName']; ?></td>
        <td class="k-s-content content" colspan="2"><?php echo $info['prize']['0']['prizeCompany']; ?></td>

    </tr>
     <tr class="line-table-height">
        <td class="k-s-content content" colspan="1"><?php echo $info['prize']['1']['prizeDate']; ?></td>
        <td class="k-s-content content" colspan="4"><?php echo $info['prize']['1']['prizeName']; ?></td>
        <td class="k-s-content content" colspan="2"><?php echo $info['prize']['1']['prizeCompany']; ?></td>
    </tr>
     <tr class="line-table-height">
        <td class="k-s-content title" colspan="1">处分情况</td>
        <td class="k-s-content content" colspan="6">

        </td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" style="text-align:left;text-indent:1em" colspan="7">家庭主要社会关系</td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="1">关系</td>
        <td class="k-s-content title" colspan="1">姓名</td>
        <td class="k-s-content title" colspan="4">工作单位</td>
        <td class="k-s-content title" colspan="1">电话</td>
    </tr>
     <tr class="line-table-height">
       <td class="k-s-content title" colspan="1"><?php echo $info['family']['0']['familyPunishment']; ?></td>
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['0']['familyName']; ?></td>
        <td class="k-s-content title" colspan="4"><?php echo $info['family']['0']['familyWork']; ?></td>
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['0']['familyTell']; ?></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['1']['familyPunishment']; ?></td>
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['1']['familyName']; ?></td>
        <td class="k-s-content title" colspan="4"><?php echo $info['family']['1']['familyWork']; ?></td>
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['1']['familyTell']; ?></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['2']['familyPunishment']; ?></td>
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['2']['familyName']; ?></td>
        <td class="k-s-content title" colspan="4"><?php echo $info['family']['2']['familyWork']; ?></td>
        <td class="k-s-content title" colspan="1"><?php echo $info['family']['2']['familyTell']; ?></td>
    </tr>
    <tr class="line-table-height2">
        <td class="k-s-content title" colspan="2" style="height: 90px;line-height: 40px;">中职学校报考审核 意见</td>
        <td class="k-s-content content_area" colspan="2" style="height: 90px;line-height: 40px;">（盖公章）</td>
        <td class="k-s-content title" style="height: 90px;line-height: 40px;">高职学校审核意见</td>
        <td class="k-s-content content_area" colspan="2">

        </td>
    </tr>
    </tbody>
</table>
