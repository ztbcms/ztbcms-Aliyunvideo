<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 11:01
 */
return array(
    array(
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid" => 0,
        //地址，[模块/]控制器/方法
        "route" => "Aliyunvideo/Index/index",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type" => 1,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status" => 1,
        //名称
        "name" => "阿里云视频点播服务",
        //备注
        "remark" => "",
        //子菜单列表
        "child" => array(
            array(
                "route" => "Aliyunvideo/VideoDemo/videoList",
                "type" => 1,
                "status" => 1,
                "name" => "視頻管理",
            ),
            array(
                "route" => "Aliyunvideo/VideoConf/videoConf",
                "type" => 1,
                "status" => 1,
                "name" => "填写阿里云配置",
            ),
        ),
    ),
);
