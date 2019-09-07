<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 13:49
 */
namespace Aliyunvideo\Controller;

use Common\Controller\AdminBase;
use Aliyunvideo\Service\AliyunVoucherService;

class VideoDemoController extends AdminBase
{

    /**
     * 视频列表
     */
    public function videoList(){
        if(IS_AJAX){
            $listQuery = I('listQuery','','trim');
            $page = $listQuery['page'];
            $limit = $listQuery['limit'];
            $video_id = $listQuery['video_id'];
            $where = [];
            if($video_id) $where['video_id'] = ['like','%'.$video_id.'%'];
            $res = AliyunVoucherService::getVideoList($where,'id desc',$page,$limit);
            $this->ajaxReturn($res);
        } else {
            $this->display();
        }
    }

    /**
     * 删除视频文件
     */
    public function deleteVideo(){
        $id = I('id','','trim');
        if(!$id) $this->ajaxReturn(createReturn(false, '', '凭证不能为空'));
        D('Aliyunvideo/VideoDetails')->where(['id'=>$id])->delete();
        $this->ajaxReturn(createReturn(true, '', '删除成功'));
    }

    /**
     * 添加或者编辑视频
     */
    public function addEditVideo(){
        $jsLink = '/app/Application/Aliyunvideo'.DIRECTORY_SEPARATOR .'Libs'.DIRECTORY_SEPARATOR;
        $this->assign('jsLink',$jsLink);
        $this->display();
    }

    /**
     * 获取视频凭证
     */
    public function aliyunUploadVoucher(){
        $title = I('title','','trim');
        $name = I('name','','trim');
        $res = AliyunVoucherService::aliyunUploadVoucher($title,$name);
        $this->ajaxReturn($res);
    }

    /**
     * 获取视频播放地址
     */
    public function aliyunVideoPlay(){
        $videoId = I('video_id', '', 'trim');
        $res = AliyunVoucherService::aliyunVideoPlay($videoId);
        $this->ajaxReturn($res);
    }

    /**
     * 表单上传dumo
     */
    public function formUpload(){
        $this->display();
    }



}