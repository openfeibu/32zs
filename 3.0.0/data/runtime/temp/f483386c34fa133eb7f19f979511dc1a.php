<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/home/view/default/user\setting.html";i:1490931050;s:79:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/home/view/default/public\head_center.html";i:1492949210;s:74:"D:\UPUPW_K2.1_64\htdocs\zhaosheng/app/home/view/default/public\footer.html";i:1492949210;}*/ ?>
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
    <div class="personal_header printHide">
        <div class="personal_logo">
            三二分段网上报名系统
        </div>
        <div class="personal_r">
            <span class="nowtime"></span>
            <p>欢迎你,<?php echo $user['member_list_nickname']; ?><a href="<?php echo url('home/login/logout'); ?>">退出系统</a></p>
        </div>
    </div>
      <div class="nav printHide">
        <ul class=""style="margin-left:20px;">
          <li ><a href="__ROOT__/">首页</a></li>
            <li ><a href="<?php echo url('home/center/index'); ?>">我的信息</a></li>
            <li><a href="<?php echo url('home/center/grade'); ?>">我的成绩</a></li>
            <li><a href="<?php echo url('home/center/setting'); ?>">我的设置</a></li>
        </ul>
    </div>

    <!-- 主体内容 S -->
    <div class="main w1000" style="background:#fff;">
        <div class="updatePass">
          <div class="updatePass-title">修改密码</div>
          <form action="<?php echo url('home/Center/runchangepwd'); ?>"  method="post">
                <div class="input-item">
                     <label for="">旧密码：</label>
                     <input type="password" name="old_password">
                </div>
                <div class="input-item">
                     <label for="">新密码：</label>
                     <input type="password" name="password">
                </div>
                <div class="input-item">
                     <label for="">新密码确认：</label>
                     <input type="password" name="repassword">
                </div>
                <input type="submit" value="登录">
            </form>
        </div>
    </div>
    <!-- 主体内容 E -->
    <!-- footer S -->
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

<script>
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
   setInterval(function(){
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
   },1000);

</script>
