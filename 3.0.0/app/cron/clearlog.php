<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------

if(config('log.clear_on')){
	// 删除指定时间的日志(默认1个月)
	$timebf=config('timebf')?:2592000;
	foreach (list_file(LOG_PATH) as $f) {
		if ($f ['isDir']) {
			foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
				if ($ff ['isFile']) {
					if (time() - $ff ['mtime'] > $timebf) {
						@unlink($ff ['pathname']);
					}
				}
			}
		}
	}
}