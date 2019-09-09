<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 15:37
 */

namespace Aliyunvideo\Service;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Libs' . DIRECTORY_SEPARATOR . 'aliyun-php-sdk-core' . DIRECTORY_SEPARATOR . 'Config.php';
use vod\Request\V20170321 as vod;
use Aliyunvideo\Model\VideoDetailsModel;

class AliyunVoucherService extends BaseService
{

    /**
     * 获取视频列表
     * @param $where
     * @param $order
     * @param $page
     * @param $limit
     * @return array
     */
    static function getVideoList($where, $order, $page, $limit)
    {
        $res = self::select('Aliyunvideo/VideoDetails',$where,$order,$page,$limit);
        $items = $res['data']['items'];
        foreach ($items as &$v) {
            $v['add_time_name'] = date("Y-m-d H:i",$v['add_time']);
            $v['edit_time_name'] = date("Y-m-d H:i",$v['edit_time']);
            if($v['expire_time']){
                $v['expire_time_name'] = date("Y-m-d",$v['expire_time']);
            } else {
                $v['expire_time_name'] = '-';
            }
            if($v['is_aliyun'] == VideoDetailsModel::ALIYUN_YES) $v['is_aliyun_name'] = '上传成功'; else $v['is_aliyun_name'] = '上传失败';
        }
        $res['data']['items'] = $items;
        return $res;
    }

    /**视频删除
     * @param $id
     */
    static function delVideo($id){
        if(!$id) return createReturn(false, '', '凭证不能为空');
        D('Aliyunvideo/VideoDetails')->where(['id'=>$id])->delete();
        return createReturn(true, '', '删除成功');
    }

    /**
     * 获取凭证资料
     */
    static function aliyunVideoFind($videoId)
    {
        if (!$videoId) return createReturn(false, '', 'videoId不能为空');
        $videoDetailsModel = new VideoDetailsModel();
        $videoDetailsFind = $videoDetailsModel->where(['video_id' => $videoId])->find();
        $res['videoDetailsFind'] = $videoDetailsFind;
        return createReturn(true, $res, '获取成功');
    }

    /**
     * 获取上传凭证
     * @param $title 视频文件标题
     * @param $name
     * @return array
     */
    static function aliyunUploadVoucher($title, $name)
    {
        $videoConfFind = VideoConfService::getVideoConfFind()['data']['videoConfFind'];
        $accessKeyId = $videoConfFind['accesskey_id'];
        $accessKeySecret = $videoConfFind['accesskey_secret'];
        if (!$accessKeyId || !$accessKeySecret) return createReturn(false, '', '配置信息未设置');
        if (!$title) return createReturn(false, '', '视频文件标题不能为空');
        if (!$name) return createReturn(false, '', '视频名称不能为空');
        $regionId = 'cn-shanghai';
        $profile = \DefaultProfile::getProfile($regionId, 'LTAI0JsVsBEg9lTA', 's2gAgRDt0vTURLwMfl4M0WC6MTnlVS');
        $client = new \DefaultAcsClient($profile);
        $request = new vod\CreateUploadVideoRequest();
        $videoDetailsTable = new VideoDetailsModel();
        //视频源文件标题(必选)
        $request->setTitle($title);
        //视频源文件名称，必须包含扩展名(必选)
        $request->setFileName($name);
        //视频源文件字节数(可选)
        $request->setFileSize('0');
        //视频源文件描述(可选)
        $request->setDescription("视频描述");
        //自定义视频封面URL地址(可选)
        $request->setCoverURL("");
        //上传所在区域IP地址(可选)
        $request->setIP($_SERVER["REMOTE_ADDR"]);
        //视频标签，多个用逗号分隔(可选)
        $request->setTags("");
        //视频分类ID(可选)
        $request->setCateId(0);
        $request->setAcceptFormat('JSON');
        try {
            $response = $client->getAcsResponse($request);
            $videoDetailsAdd['video_name'] = $title;
            $videoDetailsAdd['upload_auth'] = $response->UploadAuth;
            $videoDetailsAdd['upload_address'] = $response->UploadAddress;
            $videoDetailsAdd['request_id'] = $response->RequestId;
            $videoDetailsAdd['video_id'] = $response->VideoId;
            $videoDetailsAdd['add_time'] = time();
            $videoDetailsAdd['edit_time'] = time();
            $videoDetailsAdd['is_aliyun'] = VideoDetailsModel::ALIYUN_NO;
            $videoId = $videoDetailsTable->add($videoDetailsAdd);
            if ($videoId) {
                $res = self::aliyunVideoFind($response->VideoId)['data']['videoDetailsFind'];
                return createReturn(true, $res, '获取凭证成功');
            } else {
                return createReturn(false, '', '上传凭证失败');
            }
        } catch (\Exception $e) {
            return createReturn(false, $e, '获取凭证失败');
        }

    }


    /**
     * 获取视频播放地址
     * @param $videoId
     * @return array|mixed|\SimpleXMLElement|string
     */
    static function aliyunVideoPlay($videoId)
    {
        $videoConfFind = VideoConfService::getVideoConfFind()['data']['videoConfFind'];
        $accessKeyId = $videoConfFind['accesskey_id'];
        $accessKeySecret = $videoConfFind['accesskey_secret'];
        $videoValidTime = $videoConfFind['video_valid_time'];

        if (!$accessKeyId || !$accessKeySecret) return createReturn(false, '', '配置信息未设置');

        $regionId = 'cn-shanghai';
        $profile = \DefaultProfile::getProfile($regionId, $accessKeyId, $accessKeySecret);
        $client = new \DefaultAcsClient($profile);
        $request = new vod\GetPlayInfoRequest();
        $videoDetailsModel = new VideoDetailsModel();
        $request->setVideoId($videoId);
        $request->setAuthTimeout($videoValidTime * 86400);
        $request->setAcceptFormat('JSON');
        try {
            $res = $client->getAcsResponse($request);
            $res = json_encode($res, true);
            $res = json_decode($res, true);
            if ($res['PlayInfoList']['PlayInfo'][0]['PlayURL']) {
                $coverUrl = picturesDownload($res['VideoBase']['CoverURL'], $videoId . '.jpg', 'CoverUrl');

                $videoData['is_aliyun'] = '1';
                $videoData['edit_time'] = time();
                $videoData['expire_time'] = time() + $videoValidTime * 86400;
                $videoData['video_title'] = $res['VideoBase']['Title'];
                $videoData['cover_url'] = $coverUrl;
                $videoData['video_size'] = $res['PlayInfoList']['PlayInfo'][0]['Size'];
                $videoData['url'] = $res['PlayInfoList']['PlayInfo'][0]['PlayURL'];

                //判断视频是否存在
                if ($videoDetailsModel->where(['video_id' => $videoId])->count()) {
                    //存在
                    $videoDetailsModel->where(['video_id' => $videoId])->save($videoData);
                } else {
                    //不存在
                    $videoData['video_id'] = $videoId;
                    $videoData['video_name'] = $res['VideoBase']['Title'];
                    $videoData['sort'] = 0;
                    $videoData['add_time'] = time();
                    $videoDetailsModel->add($videoData);
                }
            }
            $res = self::aliyunVideoFind($videoId)['data']['videoDetailsFind'];
            return createReturn(true, $res, '获取凭证成功');
        } catch (\Exception $e) {
            //处理
            return createReturn(false, '', '获取视频失败');
        }
    }

}