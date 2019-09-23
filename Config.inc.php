<?php

// +----------------------------------------------------------------------
// | 日志信息模块配置
// +----------------------------------------------------------------------

return array(
	//模块名称
	'modulename' => '阿里云视频点播',
	//图标
	'icon' => 'https://dn-coding-net-production-pp.qbox.me/e57af720-f26c-4f3b-90b9-88241b680b7b.png',
	//模块简介
	'introduce' => '视频点播',
	//模块介绍地址
	'address' => '',
	//模块作者
	'author' => 'cycle',
	//作者地址
	'authorsite' => 'http://ztbcms.com',
	//作者邮箱
	'authoremail' => '953006367@qq.com',
	//版本号，请不要带除数字外的其他字符
	'version' => '1.0.3.2',
	//适配最低CMS版本，
	'adaptation' => '3.8.2.3',
	//签名
	'sign' => 'd04078c5b86475cd5a0c690b9905953d',
	//依赖模块
    'depend' => array(
        'Upload',
        'Cron'
    ),
	//行为注册
	'tags' => array(),
	//缓存，格式：缓存key=>array('module','model','action')
	'cache' => array(),
);
