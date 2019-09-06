<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 11:14
 */

namespace Aliyunvideo\Controller;

use Common\Controller\AdminBase;
use Aliyunvideo\Service\VideoConfService;

class VideoConfController extends AdminBase
{

    /**
     * 阿里云账号配置
     */
    public function videoConf(){
        $res = VideoConfService::getVideoConfFind();
        $this->assign('videoConf',$res['data']['videoConfFind']);
        $this->display();
    }

    /**
     * 添加或者编辑阿里云配置
     */
    public function addEditVideoConf(){
        $accesskey_id = I('accesskey_id','','trim');
        $accesskey_secret = I('accesskey_secret','','trim');
        $video_valid_time = I('video_valid_time','','trim');
        $res = VideoConfService::addEditVideoConf($accesskey_id,$accesskey_secret,$video_valid_time);
        $this->ajaxReturn($res);
    }

}