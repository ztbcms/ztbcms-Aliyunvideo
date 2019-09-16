<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 15:53
 */
namespace Aliyunvideo\Model;

use Common\Model\RelationModel;

class VideoDetailsModel extends RelationModel
{
    protected $tableName = 'aliyunvideo_video';

    const ALIYUN_YES = 1;  //上传并视频并成功
    const ALIYUN_NO = 0;   //获取了凭证并上传视频

    const LOCAL_COVER_YES = 1; //将视频保存到本地
    const LOCAL_COVER_NO = 0;  //不将视频保存到本地

}