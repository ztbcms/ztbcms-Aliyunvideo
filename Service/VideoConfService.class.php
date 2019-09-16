<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 11:52
 */

namespace Aliyunvideo\Service;

use Aliyunvideo\Model\VideoConfModel;

class VideoConfService extends BaseService
{
    /**
     * 获取配置详情
     */
    static function getVideoConfFind(){
        $videoConfTable = new VideoConfModel;
        $videoConfFind = $videoConfTable->find();
        $res['videoConfFind'] = $videoConfFind;
        return createReturn(true,$res,'保存成功');
    }

    /**
     * 添加或者编辑配置
     * @param $accesskey_id
     * @param $accesskey_secret
     * @param $video_valid_time
     * @return array
     */
    static function addEditVideoConf($accesskey_id, $accesskey_secret, $video_valid_time,$local_cover)
    {
        $videoConfTable = new VideoConfModel;
        $getCheckData = $videoConfTable::CheckData($accesskey_id, $accesskey_secret, $video_valid_time,$local_cover);
        if (!$getCheckData['status']) return $getCheckData;
        $videoConfFind = $videoConfTable->find();
        if ($videoConfFind) {
            $res = $videoConfTable->where(['id' => $videoConfFind['id']])->save($getCheckData['data']);
        } else {
            $res = $videoConfTable->add($getCheckData['data']);
        }
        if ($res) {
            return createReturn(true,null,'保存成功');
        } else {
            return createReturn(false,null,'保存失败');
        }
    }

}