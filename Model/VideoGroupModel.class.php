<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/7
 * Time: 10:11
 */
namespace Aliyunvideo\Model;

use Common\Model\RelationModel;

class VideoGroupModel extends RelationModel
{

    protected $tableName = 'aliyunvideo_group';

    const DELETE_YES = 0;
    const DELETE_NO = 1; //已删除


    protected function _initialize() {
        $groupCount = D($this->tableName)->where(['is_delete'=>self::DELETE_YES])->count();
        if(!$groupCount) {
            $groupAdd['cate_name'] = '默认分组';
            $groupAdd['is_delete'] = self::DELETE_YES;
            $groupAdd['add_time'] = time();
            $groupAdd['edit_time'] = time();
            D($this->tableName)->add($groupAdd);
        }
    }

}