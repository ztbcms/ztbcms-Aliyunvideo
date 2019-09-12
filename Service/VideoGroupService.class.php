<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/7
 * Time: 10:05
 */

namespace Aliyunvideo\Service;

use Aliyunvideo\Model\VideoGroupModel;
use Aliyunvideo\Model\VideoDetailsModel;

class VideoGroupService extends BaseService
{
    /**
     * 获取分类列表
     * @return array
     */
    static function getGroupList()
    {
        $videoGroupTable = new VideoGroupModel();
        $videoGroupList = $videoGroupTable->where(['is_delete' => $videoGroupTable::DELETE_YES])->select();
        $res['videoGroupList'] = $videoGroupList;
        return createReturn(true, $res, '保存成功');
    }

    /**
     * 添加或者编辑分类
     * @param $cate_id
     * @param $cate_name
     * @return array
     */
    static function addEditGroup($cate_id, $cate_name)
    {
        $videoGroupTable = new VideoGroupModel();
        $data['cate_name'] = $cate_name;
        $data['is_delete'] = $videoGroupTable::DELETE_YES;
        $data['edit_time'] = time();
        if ($cate_id) {
            $res = $videoGroupTable->where(['id' => $cate_id])->save($data);
        } else {
            $data['add_time'] = time();
            $res = $videoGroupTable->add($data);
        }
        if ($res) {
            return createReturn(true, $res, '操作成功');
        } else {
            return createReturn(false, '', '操作失败');
        }
    }

    /**
     * 删除分类
     * @param $cate_id
     * @return array
     */
    static function delGroup($cate_id)
    {
        $videoGroupTable = new VideoGroupModel();
        $videoGroupTable->where(['id' => $cate_id])->save(['is_delete' => $videoGroupTable::DELETE_NO]);
        return createReturn(true, '', '操作成功');
    }

    /**
     * 查询分类详情
     * @param $cate_id
     * @return array
     */
    static function getGroupFind($cate_id)
    {
        $videoGroupTable = new VideoGroupModel();
        $res = $videoGroupTable->where(['id' => $cate_id])->find();
        return createReturn(true, $res, '获取成功');
    }

    /**
     * 开始移动分组
     * @param $cate_id
     * @param $arr
     */
    static function moveVideosToGroup($cate_id, $arr)
    {
        $videoDetailsTable = new VideoDetailsModel();
        if (!$cate_id) return createReturn(false, '', '网络延迟，请刷新后重试');
        foreach ($arr as $k => $v) {
            $videoDetailsTable->where(['id' => $v['id']])
                ->save([
                    'group_id' => $cate_id,
                    'edit_time' => time()
                ]);
        }
        return createReturn(true, '', '操作成功');
    }
}