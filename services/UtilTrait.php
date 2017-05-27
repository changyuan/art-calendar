<?php

namespace app\services;

use app\enum\CodeEnum;

trait UtilTrait
{

/**
 * 上传自己的服务器
 * @param  [type]  $params      [$_FILES['image']]
 * @param  [type]  $target_path [目标路径]
 * @param  integer $one_more    [几个]
 * @return [type]               [array]
 */
    public function uploadPicForMe($params, $target_path, $visit_path)
    {
        if (empty($params)) {
            return CodeEnum::$paramError;
        }

        if (!is_dir($target_path)) {
            mkdir($target_path, 0775, true);
        }
        /**
         * 限制一次最多10个，否则性能不佳
         */
        $pic_arr = [];
        if (is_array($params['name']) && count($params['name']) > 10) {
            // return ['code' => -2, 'msg' => '一次最大上传10个'];
            return CodeEnum::$maxUploadNum;
        } elseif (is_array($params['name'])) {

            foreach ($params['name'] as $key => $value) {
                $temp_count = strrpos($value, ".");
                if (false !== $temp_count) {
                    $type = substr($value, $temp_count);
                }
                if (!in_array($type, array('.gif', '.jpg', '.jpeg', '.png'))) {
                    return CodeEnum::$uploadTypeError;
                }
                $new_pic_name = date("YmdHis") . rand(100, 999) . $type;
                $pic_path     = $target_path . $new_pic_name;
                if (move_uploaded_file($params['tmp_name'][$key], $pic_path)) {
                    $pic_arr[] = $visit_path . $new_pic_name;
                }
            }
            if (empty($pic_arr)) {
                return CodeEnum::$uploadFail;
            } else {
                CodeEnum::$success['data'] = $pic_arr;
                return CodeEnum::$success;
            }
        } else {
            $temp_count = strrpos($params['name'], ".");
            if (false !== $temp_count) {
                $type = substr($params['name'], $temp_count);
            }
            if (!in_array($type, array('.gif', '.jpg', '.jpeg', '.png'))) {
                return CodeEnum::$uploadTypeError;
            }
            $new_pic_name = date("YmdHis") . rand(100, 999) . $type;
            $pic_path     = $target_path . $new_pic_name;
            if (move_uploaded_file($params['tmp_name'], $pic_path)) {
                $pic_arr[] = $visit_path . $new_pic_name;
            }
            if (empty($pic_arr)) {
                return CodeEnum::$uploadFail;
            } else {
                CodeEnum::$success['data'] = $pic_arr;
                return CodeEnum::$success;
            }
        }
    }
}
