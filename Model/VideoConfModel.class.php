<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 11:56
 */

namespace Aliyunvideo\Model;

use Common\Model\RelationModel;

class VideoConfModel extends RelationModel
{

    protected $tableName = 'aliyunvideo_conf';

    /**
     * @param $accesskey_id
     * @param $accesskey_secret
     * @param $video_valid_time
     * @return array
     */
    static function CheckData($accesskey_id,$accesskey_secret,$video_valid_time){
        if(!$accesskey_id)  return createReturn(false,null,'accesskey_id不能为空');
        if(!$accesskey_secret) return createReturn(false,null,'accesskey_secret不能为空');
        if($video_valid_time < 0 || $video_valid_time > 10) return createReturn(false,null,'我们不建议保存的数值太大或者太小');

        $data['accesskey_id'] = $accesskey_id;
        $data['accesskey_secret'] = $accesskey_secret;
        $data['video_valid_time'] = $video_valid_time;
        $data['edit_time'] = time();
        return createReturn(true,$data,'校验成功');
    }

}