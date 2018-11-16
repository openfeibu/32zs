<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/user\center.html";i:1494947304;s:70:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\head_center.html";i:1493458271;s:65:"D:\UPUPW\htdocs\zs\1.1.0/app/home/view/default/public\footer.html";i:1493207649;}*/ ?>
<link rel="stylesheet" href="<?php echo $yf_theme_path; ?>public/css/bootstrap.css">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="default"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title><?php echo (isset($menu['menu_seo_title']) && ($menu['menu_seo_title'] !== '')?$menu['menu_seo_title']:$site_seo_title); ?> <?php echo $site_name; ?></title>
    <meta name="keywords" content="<?php echo (isset($menu['menu_seo_key']) && ($menu['menu_seo_key'] !== '')?$menu['menu_seo_key']:$site_seo_keywords); ?>" />
    <meta name="description" content="<?php echo (isset($menu['menu_seo_des']) && ($menu['menu_seo_des'] !== '')?$menu['menu_seo_des']:$site_seo_description); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $yf_theme_path; ?>public/css/css.css">
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/main.js"></script>
</head>
<style type="text/css" media=print>
.printHide{display : none }
@page {
margin: 5px;
}
</style>
<body>
    <!-- <div class="center_header printHide">

    </div> -->
    <div class="personal_header printHide w1000">
        <div class="personal_logo">
            三二分段网上报名系统
        </div>
        <div class="personal_r">
            <span class="nowtime"></span>
            <p>欢迎你,<?php echo $user['member_list_nickname']; ?><a href="<?php echo url('home/login/logout'); ?>">退出系统</a></p>
        </div>
    </div>
      <div class="nav printHide">
        <ul class="w1000">
          <li ><a href="__ROOT__/">首页</a></li>
            <li ><a href="<?php echo url('home/center/index'); ?>">报名管理</a></li>
            <li><a href="<?php echo url('home/center/grade'); ?>">成绩查看</a></li>
            <li><a href="<?php echo url('home/center/setting'); ?>">密码更改</a></li>
        </ul>
    </div>

<script src="<?php echo $yf_theme_path; ?>public/js/bootstrap.js"></script>
<script src="<?php echo $yf_theme_path; ?>public/js/laydate.js"></script>
<script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
    <!--加载Css-->
    <?php switch($lang): case "zh-cn": ?><link rel="stylesheet" type="text/css" href="__PUBLIC__/shearphoto/css/ShearPhoto_f_zh-cn.css" /><?php break; case "en-us": ?><link rel="stylesheet" type="text/css" href="__PUBLIC__/shearphoto/css/ShearPhoto_f_en-us.css" /><?php break; default: ?><link rel="stylesheet" type="text/css" href="__PUBLIC__/shearphoto/css/ShearPhoto_f_zh-cn.css" />
    <?php endswitch; ?>
    <!-- 主体内容 S -->
    <div class="main w1000" style="background:#fff;">
        <!--startprint1-->
        <div class="personal_table">
                <table width="656px">
                    <tbody><tr style="height:30px;">
                        <td colspan="2">

                        </td>
                        <td colspan="1" style="text-align: right;">
                            <span style="font-size: 13px;color: grey;">广东农工商职业技术学院</span>
                        </td>
                    </tr>
                    <tr><td colspan="3" style="text-align: center;font-size: 25px;font-weight: bold;border-top:1px solid #000000;line-height:48px;">2017年三二分段报名表</td></tr>
                    <tr>
                        <td>报考序列号：<?php echo $num; ?></td>
                        <td width="200px"></td>
                        <td>填表日期：

                                <?php echo $date; ?>

                        </td>
                    </tr>
                </tbody></table>
                <br>
                <table width="656px" class="k-w-table line_table">
                    <tbody><tr class="line-table-height">
                        <td class="k-s-content low_width_1 title" style="text-align: center;">姓&nbsp;&nbsp;名</td>
                        <td class="k-s-content low_width_2 content"><input type="text" name="name" value="<?php echo $info['member_list_nickname']; ?>" disabled/></td>
                        <td class="k-s-content low_width_3 title">性&nbsp;&nbsp;别</td>
                        <td class="k-s-content low_width_4 content">
                            <input type="text" name="sex" value="<?php echo $info['sex']; ?>" valType="n" leng="18" disabled/>
                            <select class="" name="" id="sexSelect">
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </td>
                        <td class="k-s-content low_width_5 title">高考考生号</td>
                        <td class="k-s-content low_width_6 content"><input type="text" name="GexamineeNumber" value="<?php echo $info['GexamineeNumber']; ?>"/></td>
                        <td class="k-s-content low_width_7" rowspan="5" style="text-align: center;position:relative">


                                <img  style="width: 125px; height: 175px; display: inline;" src="<?php if($user['member_list_headpic']): ?><?php echo get_imgurl($user['member_list_headpic'],1); else: ?><?php echo $yf_theme_path; ?>public/images/defaultGraph.jpg<?php endif; ?> " height="175px" width="125px"  class="headicon" data-toggle="modal" data-target="#myModal"  title="建议使用ie9以上浏览器，360浏览器建议使用极速模式">


                        </td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content low_width_1 title">出生年月</td>
                        <td class="k-s-content content"><input type="text" class="noBlur" name="date" value="<?php echo $info['date']; ?>" id="birth" disabled/></td>
                        <td class="k-s-content low_width_3 title">民&nbsp;&nbsp;族</td>
                        <td class="k-s-content content"><input type="text" name="nation" value="<?php echo $info['nation']; ?>"/></td>
                        <td class="k-s-content title">政治面貌</td>
                        <td class="k-s-content content"><input type="text" name="politicalOutlook" value="<?php echo $info['politicalOutlook']; ?>"/></td>
                    </tr>
                    <tr class="line-table-height">

                        <td class="k-s-content low_width_1 title">所在学校</td>
                        <td class="k-s-content content" colspan="2">
                            <input type="text" name="school" value="<?php echo $school['school_name']; ?>" disabled/>
                        </td>
                        <td class="k-s-content low_width_1 title">身份证号</td>
                        <td class="k-s-content content" colspan="2"><input type="text" name="cardId" value="<?php echo $info['member_list_username']; ?>" disabled/></td>

                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title">生源地</td>
                       <td class="k-s-content content">
                           <input type="text" name="documentType" value="<?php echo $info['documentType']; ?>"/>
                       </td>
                        <td class="k-s-content  title">户籍地</td>
                        <td class="k-s-content content"><input type="text" name="domicile" value="<?php echo $info['domicile']; ?>"/></td>
                        <td class="k-s-content low_width_1 title">所在专业</td>
                        <td class="k-s-content content">
                            <?php echo $major['major_name']; ?>
                        </td>


                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content low_width_1 title">报考专业</td>
                        <td class="k-s-content content" colspan="1">
                            <?php echo $recruit_major['recruit_major_name']; ?>
                        </td>
                        <td class="k-s-content title" colspan="1">中职考生号</td>
                        <td class="k-s-content content">
                        <input type="text" name="ZexamineeNumber" value="<?php echo $info['ZexamineeNumber']; ?>"/>
                        </td>
                         <td class="k-s-content title" colspan="1">考生类别</td>
                        <td class="k-s-content content">
                            <input type="text" name="candidateCategory" value="<?php echo $info['candidateCategory']; ?>"/>
                        </td>
                    </tr>
                    <!-- 第6行 -->
                    <tr class="line-table-height">
                        <td class="k-s-content low_width_1 title " colspan="2">接收邮寄通知书地址</td>
                        <td class="k-s-content content" colspan="3">
                            <input type="text" name="address" value="<?php echo $info['address']; ?>"/>
                        </td>
                        <td class="k-s-content title">邮编</td>
                        <td class="k-s-content content" colspan="1">
                            <input type="text" name="zipCode" value="<?php echo $info['zipCode']; ?>"/>
                        </td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content low_width_1 title"  colspan="2">收件人</td>
                        <td class="k-s-content content" colspan="2">
                            <input type="text" name="addressee" value="<?php echo $info['addressee']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="1">联系电话</td>
                        <td class="k-s-content content" colspan="2">
                            <input type="text" name="tell" value="<?php echo $info['tell']; ?>"/>
                        </td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2">技能证书名称</td>
                        <td class="k-s-content title" colspan="1">级别</td>
                        <td class="k-s-content title" colspan="2">颁发单位</td>
                        <td class="k-s-content title" colspan="2">获得时间</td>

                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateName_0" value="<?php echo $info['certificate']['0']['certificateName']; ?>"/></td>
                        <td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_0" value="<?php echo $info['certificate']['0']['certificateLevel']; ?>"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateCompany_0" value="<?php echo $info['certificate']['0']['certificateCompany']; ?>"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateDate_0" value="<?php echo $info['certificate']['0']['certificateDate']; ?>"/></td>

                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateName_1" value="<?php echo $info['certificate']['1']['certificateName']; ?>"/></td>
                        <td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_1" value="<?php echo $info['certificate']['1']['certificateLevel']; ?>"value="<?php echo $info['certificate']['0']['certificateName']; ?>"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateCompany_1" value="<?php echo $info['certificate']['1']['certificateCompany']; ?>"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateDate_1" value="<?php echo $info['certificate']['1']['certificateDate']; ?>"/></td>

                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateName_2" value="<?php echo $info['certificate']['2']['certificateName']; ?>"/></td>
                        <td class="k-s-content title" colspan="1"><input type="text" name="certificateLevel_2" value="<?php echo $info['certificate']['2']['certificateLevel']; ?>"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateCompany_2" value="<?php echo $info['certificate']['2']['certificateCompany']; ?>"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="certificateDate_2" value="<?php echo $info['certificate']['2']['certificateDate']; ?>"/></td>
                    </tr>

                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="7" style="text-align:left;text-indent:1em">简历（从初中开始填起）</td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2">自何年何月</td>
                        <td class="k-s-content title" colspan="2">至何年何月</td>
                        <td class="k-s-content title" colspan="2">在何地、何单位学习或工作</td>
                        <td class="k-s-content title" colspan="1">任何职务</td>

                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeBeforeDate_0" value="<?php echo $info['resume']['0']['resumeBeforeDate']; ?>" class="noBlur" id="resumeBeforeDate_0"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeAfterDate_0" value="<?php echo $info['resume']['0']['resumeAfterDate']; ?>" class="noBlur" id="resumeAfterDate_0"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeWork_0" value="<?php echo $info['resume']['0']['resumeWork']; ?>"/></td>
                        <td class="k-s-content title" colspan="1"><input type="text" name="resumePost_0" value="<?php echo $info['resume']['0']['resumePost']; ?>"/></td>

                    </tr>
                    <tr class="line-table-height">
                         <td class="k-s-content title" colspan="2"><input type="text" name="resumeBeforeDate_1" value="<?php echo $info['resume']['1']['resumeBeforeDate']; ?>" class="noBlur" id="resumeBeforeDate_1"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeAfterDate_1" value="<?php echo $info['resume']['1']['resumeAfterDate']; ?>" class="noBlur" id="resumeAfterDate_1"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeWork_1" value="<?php echo $info['resume']['1']['resumeWork']; ?>"/></td>
                        <td class="k-s-content title" colspan="1"><input type="text" name="resumePost_1" value="<?php echo $info['resume']['1']['resumePost']; ?>"/></td>

                    </tr>
                    <tr class="line-table-height">
                          <td class="k-s-content title" colspan="2"><input type="text" name="resumeBeforeDate_2" value="<?php echo $info['resume']['2']['resumeBeforeDate']; ?>" class="noBlur" id="resumeBeforeDate_2"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeAfterDate_2" value="<?php echo $info['resume']['2']['resumeAfterDate']; ?>" class="noBlur" id="resumeAfterDate_2"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="resumeWork_2" value="<?php echo $info['resume']['2']['resumeWork']; ?>"/></td>
                        <td class="k-s-content title" colspan="1"><input type="text" name="resumePost_2" value="<?php echo $info['resume']['2']['resumePost']; ?>"/></td>

                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="7" style="text-align:left;text-indent:1em">获奖情况：</td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2">时间</td>
                        <td class="k-s-content title" colspan="2">奖项</td>
                        <td class="k-s-content title" colspan="3">发证单位</td>

                    </tr>
                     <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2"><input type="text" name="prizeDate_0"  value="<?php echo $info['prize']['0']['prizeDate']; ?>" class="noBlur" id="prizeDate_0"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="prizeName_0"  value="<?php echo $info['prize']['0']['prizeName']; ?>"/></td>
                        <td class="k-s-content title" colspan="3"><input type="text" name="prizeCompany_0"  value="<?php echo $info['prize']['0']['prizeCompany']; ?>"/></td>

                    </tr>
                     <tr class="line-table-height">
                        <td class="k-s-content title" colspan="2"><input type="text" name="prizeDate_1"  value="<?php echo $info['prize']['1']['prizeDate']; ?>" class="noBlur" id="prizeDate_1"/></td>
                        <td class="k-s-content title" colspan="2"><input type="text" name="prizeName_1"  value="<?php echo $info['prize']['1']['prizeName']; ?>"/></td>
                        <td class="k-s-content title" colspan="3"><input type="text" name="prizeCompany_1"  value="<?php echo $info['prize']['1']['prizeCompany']; ?>"/></td>
                    </tr>
                     <tr class="line-table-height">
                        <td class="k-s-content title" colspan="1">处分情况</td>
                        <td class="k-s-content title" colspan="6">
                            <input type="text" name="punishment" />
                        </td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" style="text-align:left;text-indent:1em" colspan="7">家庭主要社会关系</td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="1">关系</td>
                        <td class="k-s-content title" colspan="1">姓名</td>
                        <td class="k-s-content title" colspan="3">工作单位</td>
                        <td class="k-s-content title" colspan="2">电话</td>
                    </tr>
                     <tr class="line-table-height">
                       <td class="k-s-content title" colspan="1">
                            <input type="text" name="familyPunishment_0" value="<?php echo $info['family']['0']['familyPunishment']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="1">
                            <input type="text" name="familyName_0" value="<?php echo $info['family']['0']['familyName']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="3">
                            <input type="text" name="familyWork_0" value="<?php echo $info['family']['0']['familyWork']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="2">
                            <input type="text" name="familyTell_0" value="<?php echo $info['family']['0']['familyTell']; ?>"/>
                        </td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="1">
                            <input type="text" name="familyPunishment_1" value="<?php echo $info['family']['1']['familyPunishment']; ?>" />
                        </td>
                        <td class="k-s-content title" colspan="1">
                            <input type="text" name="familyName_1" value="<?php echo $info['family']['1']['familyName']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="3">
                            <input type="text" name="familyWork_1" value="<?php echo $info['family']['1']['familyWork']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="2">
                            <input type="text" name="familyTell_1" value="<?php echo $info['family']['1']['familyTell']; ?>"/>
                        </td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content title" colspan="1">
                            <input type="text" name="familyPunishment_2" value="<?php echo $info['family']['2']['familyPunishment']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="1">
                            <input type="text" name="familyName_2" value="<?php echo $info['family']['2']['familyName']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="3">
                            <input type="text" name="familyWork_2" value="<?php echo $info['family']['2']['familyWork']; ?>"/>
                        </td>
                        <td class="k-s-content title" colspan="2">
                            <input type="text" name="familyTell_2" value="<?php echo $info['family']['2']['familyTell']; ?>"/>
                        </td>
                    </tr>


                    <tr class="line-table-height2">
                        <td class="k-s-content title">中职学校报考审核 意见</td>
                        <td class="k-s-content content_area" colspan="3">
                           （盖公章）
                        </td>
                        <td class="k-s-content title">高职学校审核意见</td>
                        <td class="k-s-content content_area" colspan="2">

                        </td>
                    </tr>
                </tbody></table>
        </div>
        <!--endtprint1-->

        <?php if($user['user_status'] == 1): ?>
        <button class="print printHide" onclick="preview(1)">打印</button>
        <?php else: ?>
         <button class="unprint printHide" >请完善资料，审核通过后可打印</button>
        <?php endif; ?>
    </div>

    <script  type="text/javascript" src="__PUBLIC__/shearphoto/js/ShearPhoto.js" ></script>
<script  type="text/javascript"  src="__PUBLIC__/shearphoto/js/alloyimage.js" ></script>
<script  type="text/javascript"  src="__PUBLIC__/shearphoto/js/handle_f.js" ></script>
<script type="text/javascript">
    var SHEAR = {
        PATH_RES: '__PUBLIC__',
        PATH_AVATAR: '__ROOT__/data/upload/avatar',
        URL:"<?php echo url('home/Center/avatar'); ?>",
    };
</script>

    <!-- 显示模态框（Modal） -->
        <div class="modal fade modal-avatar printHide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
            <div class="modal-dialog" style="width:60%;">
                <div class="modal-content"  style="min-width:620px;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            选择头像
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                    <div id="shearphoto_loading"><?php echo lang('program loading'); ?>......</div>
                                    <div id="shearphoto_main">

                                        <div class="primary">
                                            <div id="main">
                                                <div class="point"></div>
                                                <div id="SelectBox">
                                                    <form    id="ShearPhotoForm" enctype="multipart/form-data" method="post"  target="POSTiframe">
                                                        <a href="javascript:;" id="selectImage"><input type="file"  name="UpFile" autocomplete="off"/></a>
                                                    </form>

                                                </div>
                                                <div id="relat">
                                                    <div id="black"></div>
                                                    <div id="movebox">
                                                        <div id="smallbox">
                                                            <img src="__PUBLIC__/shearphoto/images/default.gif" class="MoveImg"  style="max-width:300%"/>
                                                        </div>
                                                        <i id="borderTop"></i>
                                                        <i id="borderLeft"></i>
                                                        <i id="borderRight"></i>
                                                        <i id="borderBottom"></i>
                                                        <i id="BottomRight"></i>
                                                        <i id="TopRight"></i>
                                                        <i id="Bottomleft"></i>
                                                        <i id="Topleft"></i>
                                                        <i id="Topmiddle"></i>
                                                        <i id="leftmiddle"></i>
                                                        <i id="Rightmiddle"></i>
                                                        <i id="Bottommiddle"></i>
                                                    </div>
                                                    <img src="__PUBLIC__/shearphoto/images/default.gif" class="BigImg" />
                                                </div>
                                            </div>
                                            <div style="clear: both"></div>
                                            <div id="Shearbar">
                                                <a id="LeftRotate" href="javascript:;"><em></em>向左转</a>
                                                <em class="hint L"></em>
                                                <div class="ZoomDist" id="ZoomDist">
                                                    <div id="Zoomcentre"></div>
                                                    <div id="ZoomBar"></div>
                                                    <span class="progress"></span>
                                                </div>
                                                <em class="hint R"></em>
                                                <a id="RightRotate" href="javascript:;">向右转<em></em></a>
                                                <p class="Psava">
                                                    <a id="againIMG"  href="javascript:;">重新选择</a>
                                                    <a id="saveShear" href="javascript:;">保存</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div style="clear: both"></div>
                                    </div>
                                    <div id="photoalbum">
                                        <i id="close"></i>
                                        <ul>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/1.jpg" serveUrl="file/photo/1.jpg" /></li>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/2.jpg" serveUrl="file/photo/2.jpg" /></li>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/3.jpg" serveUrl="file/photo/3.jpg" /></li>
                                            <li><img src="__PUBLIC__/shearphoto/file/photo/4.jpg" serveUrl="file/photo/4.jpg" /></li>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- 主体内容 E -->
<script type="text/javascript">
laydate.skin('dahong')
laydate({
elem: '#birth',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'date','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#resumeBeforeDate_0',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'resumeBeforeDate_0','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#resumeBeforeDate_1',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'resumeBeforeDate_1','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#resumeBeforeDate_2',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'resumeBeforeDate_2','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#resumeAfterDate_0',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'resumeAfterDate_0','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#resumeAfterDate_1',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'resumeAfterDate_1','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#resumeAfterDate_2',
format: 'YYYY年MM月', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'resumeAfterDate_2','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#prizeDate_0',
format: 'YYYY年MM月DD日', // 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'prizeDate_0','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
laydate({
elem: '#prizeDate_1',
format: 'YYYY年MM月DD日',// 分隔符可以任意定义，该例子表示只显示年月
choose: function(datas){ //选择日期完毕的回调
    $.post("<?php echo url('home/center/update_info'); ?>",{'name':'prizeDate_1','value':datas},function(data){
        // if($("."+name).length>0){
        //     $("."+name).text(value);
        // }
        // console.log(data);
     });
}
});
</script>
<!-- footer S -->
<div class="printHide footer">
    <p>学院微博：@广东农工商学院发布@广东农工商职业技术学院</p>
    <p>粤垦路校区地址：广州市天河区粤垦路198号 增城校区地址：广州增城市中新镇风光路393号</p>
    <p class="copy">版权所有：广东农工商职业技术学院 备案号：4401060500008</p>
</div>
<!-- footer E -->
</body>

<script>
    $(function(){
        var time = null,index=0;
        $(".banner ol li").on("click",function(){
            var i = $(this).index();
            $('.banner ul li').eq(i).fadeIn().siblings("li").fadeOut();
            $(this).addClass("active").siblings("li").removeClass("active");
            i = index;
        })
        run();
        function run (){
            time = setInterval(function(){
                i = ++index > $(".banner ol li").length-1 ? 0 : index;
                 $('.banner ul li').eq(i).fadeIn().siblings("li").fadeOut();
                 $(".banner ol li").eq(i).addClass("active").siblings("li").removeClass("active");
                i = index;
            },1000)
        }
        $(".banner").hover(function(){
            clearInterval(time);
        },function(){
            run();
        });
        var se_i =  $(".fb-seamless-con li").length;
        var se_t = null;
        var se_long = 0;
        $(".fb-seamless-con ul").append($(".fb-seamless-con ul").html());
        se_run();
        function se_run(){
            se_t = setInterval(function(){
                se_long += 1;
                $(".fb-seamless-con ul").css("left",-se_long);
                if(se_long >= se_i*195){
                    $(".fb-seamless-con ul").css("left",0);
                    se_long = 0;
                }
            },20)
        }
        $(".fb-seamless-con").hover(function(){
            clearInterval(se_t);
        },function(){
            se_run();
        })
    })
    function mbar(sobj){
        var docurl =sobj.options[sobj.selectedIndex].value;
        if (docurl != "") {
           open(docurl,'_blank');
           sobj.selectedIndex=0;
           sobj.blur();
        }
    }
</script>
<script>
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
   setInterval(function(){
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
   },1000);
   $(".personal_table input").blur(function(){
    var value  = $(this).val();
    var name = $(this).attr('name');
    if($(this).hasClass("noBlur")){
        return false;
    }else{
        $.post("<?php echo url('home/center/update_info'); ?>",{'name':name,'value':value},function(data){
            if($("."+name).length>0){
                $("."+name).text(value);
            }
            console.log(data);
         });
    }

   });
   $(".personal_table input").bind('input propertychange', function() {
        var valType = $(this).attr("valType");
        var leng = $(this).attr("leng");
        var val = $(this).val();
        if(valType == undefined){
            return false;
        }
        if(valType == "n"){
            //只能填数字
            if(isNaN(val)){
                if(isNaN(parseFloat(val))){
                    $(this).val("");
                }else {
                    $(this).val(parseFloat(val));
                }

            }
        }
        if(leng != undefined){
            $(this).val($(this).val().substring(0,leng));
        }
    });
    $("#sexSelect").change(function(){
        var val = $(this).val();
        $('[name="sex"]').val(val);
        $('[name="sex"]').blur();
    })
</script>
<script>

function check_preview(oper)
{
    if(confirm("只能打印一次，确定打印么？"))
    {
        preview(oper);
    }
}
function preview(oper)
{
if (oper < 10)
{
bdhtml=window.document.body.innerHTML;//获取当前页的html代码
sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
prnhtmlprnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
window.document.body.innerHTML=prnhtml;
window.print();
window.document.body.innerHTML=bdhtml;
} else {
window.print();
}
}
/*
$(".pro_img").on('click','.img_close',function (e) {
        new upField($(this)).del();
    })

$("body").on('change','.upload',function (e) {
    var field=new upField($(this));
    var maxSize=500; //kb
    var name=$(this).attr('name');
    var pic = $(this).prop('files');
    var fordata=new FormData();
    fordata.append('imgFile',pic[0]); //添加字段



   if(pic[0].size/1024>maxSize) {
        field.addErr('图片不能超过'+maxSize+'kb')
        return false;
   }

    $.ajax({
        url:"<?php echo url('home/center/avatar'); ?>",
        //url:'http://183.71.200.186:8084/upload_json.asp',
        type:'POST',
        dataType:'json',
        data:fordata,
        processData: false,
        contentType: false,
        error: function(){
            field.addErr('未知错误')
        },


        success: function(data){
            if(data.error==0){
                // field.add(e.url,name);
                $("#studentPicture_herf_show").attr("src",data.url)
            }else{

                field.addErr(e.message);
            }
        }
    })

})

function upField(doc){
    var self=this;
    this.waitTime=3000;  //错误信息 显示时长
    this.doc=doc;

    this.addErr = function (message) {
        var error=this.doc.parent(".img").find('.error');
        error.html(message).show();
        setTimeout(function () {
            error.html('').hide();
        },3000)
    };

    this.add=function (img,name) {
          var template='<div class="img_close" name="'+name+'"></div>';
          template+='<img src="'+img+'" alt="">';
          this.doc.parent(".img").html(template);
          //添加input
          var input='<input name='+name+' type="hidden" value='+img+' class="up-item">';
          $("#myform").append(input);


    };
    this.del = function () {
            var img=this.doc.parent(".img");
            var name=img.find(".img_close").attr('name');
            var template='<input name="'+name+'" type="file" id="'+name+'" class="upload">';
            template+='<span>+</span>';
            template+='<div class="error"></div> ';
            img.html(template);
            $(".up-item[name="+name+"]")[0]&&$(".up-item[name="+name+"]").remove();
    };


}


*/
</script>
</html>

