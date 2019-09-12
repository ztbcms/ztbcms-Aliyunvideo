<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/7
 * Time: 10:04
 */

namespace Aliyunvideo\Controller;

use Common\Controller\AdminBase;
use Aliyunvideo\Service\VideoGroupService;

/**
 * 视频面板
 * Class VideoPanelController
 * @package Aliyunvideo\Controller
 */
class VideoGroupController extends AdminBase
{

    /**
     * 获取分类列表
     */
    public function getGroupList()
    {
        $res = VideoGroupService::getGroupList();
        $this->ajaxReturn($res);
    }

    /**
     * 添加或编辑分类
     */
    public function addEditGroup()
    {
        if (IS_AJAX) {
            $cate_id = I('cate_id', '', 'trim');
            $cate_name = I('cate_name', '', 'trim');
            $res = VideoGroupService::addEditGroup($cate_id, $cate_name);
            $this->ajaxReturn($res);
        } else {
            $this->display();
        }
    }

    /**
     * 获取分类详情
     */
    public function getGroupFind()
    {
        $cate_id = I('cate_id', '', 'trim');
        $res = VideoGroupService::getGroupFind($cate_id);
        $this->ajaxReturn($res);
    }

    /**
     * 删除分类
     */
    public function delGroup()
    {
        $cate_id = I('cate_id', '', 'trim');
        $res = VideoGroupService::delGroup($cate_id);
        $this->ajaxReturn($res);
    }

    /**
     * 选择分组页面
     */
    public function selectGroup()
    {
        if (IS_AJAX) {
            $res = VideoGroupService::getGroupList();
            $this->ajaxReturn($res);
        } else {
            $this->display();
        }
    }

    /**
     * 移动视频的分组
     */
    public function moveVideosToGroup()
    {
        $cate_id = I('cate_id', '', 'trim');
        $arr = I('arr');
        $res = VideoGroupService::moveVideosToGroup($cate_id,$arr);
        $this->ajaxReturn($res);
    }

}