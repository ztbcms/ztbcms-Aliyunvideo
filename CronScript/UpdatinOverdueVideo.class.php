<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/12
 * Time: 15:46
 */

namespace Aliyunvideo\CronScript;

use Cron\Base\Cron;

use Aliyunvideo\Service\AliyunVoucherService;

/**
 * 建议每秒执行
 */
class UpdatinOverdueVideo extends Cron {

    public function run($cronId) {
        AliyunVoucherService::updatinOverdueVideo();
        echo 'ok';
    }
}