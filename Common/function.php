<?php
/**
 * Created by PhpStorm.
 * User: cycle_3
 * Email: 953006367@qq.com
 * Date: 2019/9/6
 * Time: 17:31
 */

/**
 * 图片下载
 * @param $url
 * @param $filename
 * @param string $catalogue
 * @return string
 */
function picturesDownload($url,$filename,$catalogue = 'CoverUrl') {
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    ob_start ();
    curl_exec ( $ch );
    $return_content = ob_get_contents ();
    ob_end_clean ();
    $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
    $date = date("Y-m-d",time());
    $path = dirname(dirname(APP_PATH)).'/d/'.$catalogue.'/'.$date;
    if(!is_dir($path)){
        //不存在该目录的时候创建该目录
        $is_path = mkdir($path,0777,true);
        if(!$is_path) {
            echo '您没有操作的权限';
            exit;
        }
    }
    $file = $path.'/'.$filename;
    $fp= @fopen($file,"a"); //将文件绑定到流
    fwrite($fp,$return_content); //写入文件
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $file_url = $sys_protocal . $_SERVER['HTTP_HOST']  . '/d/'.$catalogue.'/'.$date.'/'.$filename;
    return $file_url;
}