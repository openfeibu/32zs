<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;

/**
 * 钩子模型
 */
class Hook extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * 添加钩子
     * @param array $hooks 钩子
     * @param string $addon_name 插件名称
     * @return bool
     */
    public static function addHooks($hooks = [], $addon_name = '')
    {
        if ($hooks && is_array($hooks)) {
            $data = [];
            foreach ($hooks as $name => $description) {
                if (is_numeric($name)) {
                    $name = $description;
                    $description = '';
                }
                if (self::where('name', $name)->find()) {
                    continue;
                }
                $data[] = [
                    'name'        => $name,
                    'addon'      => $addon_name,
                    'description' => $description,
                    'create_time' => request()->time(),
                    'update_time' => request()->time(),
                ];
            }
            if ($data && false === self::insertAll($data)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 删除钩子
     * @param string $addon_name 插件名称
     * @return bool
     */
    public static function deleteHooks($addon_name = '')
    {
        if ($addon_name) {
            if (false === self::where('addon', $addon_name)->delete()) {
                return false;
            }
        }
        return true;
    }
}