<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"D:\UPUPW_K2.1_64\htdocs\zhaosheng\public/yfcmf/dispatch_jump.html";i:1489327654;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title><?php echo lang('error'); ?></title>
    <link type="text/css" rel="stylesheet" href="__PUBLIC__/jump_style/base.css">
    <link type="text/css" rel="stylesheet" href="__PUBLIC__/jump_style/global.css">
    <link type="text/css" rel="stylesheet" href="__PUBLIC__/jump_style/404.css">
</head>
<body>
<div class="wrap">
    <div class="errors">
        <div class="text">
            <h4><?php echo lang('reason'); ?></h4>
            <h4><?php echo (is_array($msg))?implode("|",$msg):$msg;; ?>!</h4>
            <p>YFCMF：<?php echo lang('automatically'); ?> <a id="href" href="<?php echo($url); ?>"><?php echo lang('jump'); ?></a> <?php echo lang('wait second'); ?> <b id="wait"><?php echo($wait); ?></b></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body></html>