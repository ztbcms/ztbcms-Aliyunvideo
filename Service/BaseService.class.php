<?php
namespace Aliyunvideo\Service;

class BaseService extends \System\Service\BaseService {

    /**
     * 存放错误信息
     *
     * @var string
     */
    public $err_msg = '';

    /**
     * 设置错误信息
     *
     * @param $err_msg
     */
    public function set_err_msg($err_msg) {
        $this->err_msg = $err_msg;
    }

    /**
     * 返回最近的错误信息
     *
     * @return string
     */
    public function get_err_msg() {
        return $this->err_msg;
    }

    /**
     * 创建统一的Service返回结果
     *
     * @param boolean $status
     * @param array   $data
     * @param string  $msg
     * @param int     $code
     * @return array
     */
    static function createReturn($status, $data = [], $msg = '', $code = null) {
        //默认成功则为200 错误则为400
        if(empty($code)){
            $code = $status ? 200 : 400;
        }
        return [
            'status' => $status,
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ];
    }

    /**
     * 返回列表信息
     *
     * @param $status
     * @param $items
     * @param $page
     * @param $limit
     * @param $total_items
     * @param $total_pages
     * @return array
     */
    static function createReturnList($status, $items, $page, $limit, $total_items, $total_pages){
        $data = [
            'items'       => $items,
            'page'        => $page,
            'limit'       => $limit,
            'total_items' => $total_items,
            'total_pages' => $total_pages,
        ];

        return self::createReturn($status, $data);
    }


    /**
     * 获取数组中的某一列
     *
     * @param array  $arr      数组
     * @param string $key_name 列名
     * @return array  返回那一列的数组
     */

    public static function get_arr_column($arr, $key_name) {
        $arr2 = array();
        foreach ($arr as $key => $val) {
            $arr2[] = $val[$key_name];
        }

        return self::createReturn(true, $arr2, '获取成功');
    }

    /**
     * 获取缓存或者更新缓存
     *
     * @param string $config_key 缓存文件名称
     * @param array  $data       缓存数据  array('k1'=>'v1','k2'=>'v3')
     * @return array or string or bool
     */
    public static function tpCache($config_key, $data = array()) {
        $param = explode('.', $config_key);
        if (empty($data)) {
            //如$config_key=shop_info则获取网站信息数组
            //如$config_key=shop_info.logo则获取网站logo字符串
            $config = F($param[0], '', TEMP_PATH); //直接获取缓存文件
            if (empty($config)) {
                //缓存文件不存在就读取数据库
                $res = D('ShopConfig')->where("inc_type='$param[0]'")->select();
                if ($res) {
                    foreach ($res as $k => $val) {
                        $config[$val['name']] = $val['value'];
                    }
                    F($param[0], $config, TEMP_PATH);
                }
            }
            if (count($param) > 1) {
                return self::createReturn(true, $config[$param[1]], '获取成功');
            } else {
                return self::createReturn(true, $config, '获取成功');
            }
        } else {
            //更新缓存
            $result = D('ShopConfig')->where("inc_type='$param[0]'")->select();
            if ($result) {
                foreach ($result as $val) {
                    $temp[$val['name']] = $val['value'];
                }
                foreach ($data as $k => $v) {
                    $newArr = array('name' => $k, 'value' => trim($v), 'inc_type' => $param[0]);
                    if (!isset($temp[$k])) {
                        M('ShopConfig')->add($newArr); //新key数据插入数据库
                    } else {
                        if ($v != $temp[$k]) {
                            M('ShopConfig')->where("name='$k'")->save($newArr);
                        }
                        //缓存key存在且值有变更新此项
                    }
                }
                //更新后的数据库记录
                $newRes = D('ShopConfig')->where("inc_type='$param[0]'")->select();
                foreach ($newRes as $rs) {
                    $newData[$rs['name']] = $rs['value'];
                }
            } else {
                foreach ($data as $k => $v) {
                    $newArr[] = array('name' => $k, 'value' => trim($v), 'inc_type' => $param[0]);
                }
                M('ShopConfig')->addAll($newArr);
                $newData = $data;
            }

            return self::createReturn(true, F($param[0], $newData, TEMP_PATH), '获取成功');

        }

    }

    /**
     *  将数据库中查出的列表以指定的 id 作为数组的键名
     * @param $arr
     * @param $key_name
     * @return array
     */
    static function convert_arr_key($arr, $key_name) {
        $arr2 = [];
        foreach ($arr as $key => $val) {
            $arr2[$val[$key_name]] = $val;
        }

        return self::createReturn(true, $arr2, 'ok');
    }
}