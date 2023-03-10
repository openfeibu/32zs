<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"/home/vagrant/Code/32zs/2.0.0/app/admin/view/examination/ticket.html";i:1526993590;}*/ ?>
<style>
.main{width: 630px;margin: 0 auto;}
.k-w-table {
    /* border-style:solid; */
    border-color:rgb(148, 192, 210);
/*  border-color:#ccc; */
    /* border-width:0px; */
    border-collapse:collapse;
    /* width: 630px; */
}
.k-s-content{
    border:1px solid #999;
    text-align: left;
    padding-left: 5px;
}
.header_title{
    border:none;
    font-size: 18px;
    text-align: center;
    line-height: 13px;
}
.title{
    text-align: left;
    font-size: 14px;
    height:30px;
    line-height: 30px;
}
.content{
    text-align: left;
    font-size: 14px;
    height:30px;
    line-height: 30px;
}
.content-p{
    text-align: left;
    font-size: 14px;
    line-height: 25px;
}
</style>
    <div class="main w1000 clearfix" style="background:#fff;">
        <p class="header_title">广东农工商职业技术学院<?php echo date('Y'); ?>三二分段转段考核</p>
        <p class="header_title">准考证</p>
        <table class="k-w-table">
            <tr>
                <td class="k-s-content title" width="100px">考生姓名</td>
                <td class="k-s-content content" colspan="2"  width="200px"><?php echo $member['member_list_nickname']; ?></td>
                <td class="k-s-content title" width="100px">性别</td>
                <td class="k-s-content content" width="100px"><?php echo get_sex($member['member_list_username']); ?></td>
                <td width="150px" rowspan="7" class="k-s-content" style="padding-left: 5px;text-align:center"><img src="<?php echo get_imgurl2($member['member_list_headpic'],1); ?>"  style="height:200px;width:150px;"></td>
            </tr>
            <tr>
                <td class="k-s-content title">身份证号</td>
                <td colspan="4" class="k-s-content content"><?php echo $member['member_list_username']; ?></td>
            </tr>
            <tr>
                <td class="k-s-content title">报考学校</td>
                <td colspan="4" class="k-s-content content">广东农工商职业技术学院</td>
            </tr>
            <tr>
                <td class="k-s-content title">报考专业</td>
                <td colspan="4" class="k-s-content content"><?php echo $recruit_major['recruit_major_name']; ?></td>
            </tr>
            <tr>
                <td class="k-s-content title">考试科目</td>
                <td colspan="4" class="k-s-content content">专业技能考核</td>
            </tr>
            <tr>
                <td class="k-s-content title">考试地点</td>
                <td colspan="2" class="k-s-content content"><?php echo $member['room_name']; ?></td>
                <td class="k-s-content title">座位号</td>
                <td class="k-s-content content"><?php echo $member['room_no']; ?></td>
            </tr>
            <tr>
                <td class="k-s-content title">考试时间</td>
                <td colspan="4" class="k-s-content content"><?php echo formatdate($examination['date']); ?> <?php echo $examination['starttime']; ?>-<?php echo $examination['endtime']; ?></td>
            </tr>
            <tr>
                <td colspan="6" class="k-s-content content-p" >
                    考生须知：<br>
                    1、考试前20分钟，凭准考证和身份证进入考场，对号入座。<br>
                    2、考生请自备黑色钢笔、签字笔、铅笔、橡皮等考试用品。 <br>
                    3、严禁携带各种电子、通信、计算器等设备进入考场。 <br>
                    4、考试迟到30分钟以上者，不得再进入考场，视同缺考。<br>
                    5、严禁将答题卡、试卷、草稿纸、实训设备等带出考场。<br>
                    6、考生须遵守考场规则，若有作弊行为按严重违纪行为处理。
                </td>
            </tr>
        </table>
</div>
