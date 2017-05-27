<?php
namespace app\services;

use Yii;

class WebHelper
{
    private static $_timeout        = 3;
    private static $_connectTimeOut = 2;

    //设置参数
    public static function setConfig($timeOut = 3, $conn_timeOut = 2)
    {
        self::$_timeout        = $timeOut;
        self::$_connectTimeOut = $conn_timeOut;
    }

    /**
     * [getData description]
     * @param  [type]  $url       [description]
     * @param  integer $header    [description]
     * @param  integer &$httpCode [description]
     * @return [type]             [description]
     */
    public static function getData($url, $header = array(), &$httpCode = 0)
    {
        self::setConfig();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$_connectTimeOut);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$_timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result   = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;
    }

    /**
     * 为了不影响原有逻辑
     * @param $url
     * @param array $params
     * @param int $header
     * @param string $method
     * @param int $httpCode
     * @return mixed
     */
    public static function postData($url, $params = array(), $header = [], $method = 'POST', &$httpCode = 0)
    {
        //echo "<br /> start-------------post------------". date("Y-m-d H:i:s") . '. ' . microtime().' <br />';
        //echo $url;
        self::setConfig();
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求

        curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, self::$_timeout); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::$_connectTimeOut);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3); //HTTp定向级别
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转 302 redirect
        //        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
        $output = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            var_dump(curl_error($curl));
            //echo 'Errno'.curl_error($curl);
            //MI_ErrorLog::writeLog('Errno'.curl_error($curl));
        }
        //获取返回数据的状态码
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl); // 关键CURL会话
        //echo "<br /> end----------------post---------". date("Y-m-d H:i:s") . '. ' . microtime().' <br />';
        return $output; // 返回数据
    }

    public static function putData($url, $method = 'PUT', $data = array(), $header = array())
    {
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
        empty($data) or curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置提交的字符串
        empty($header) or curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置提交header
        0 === strpos($url, 'https:') and curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //https请求加这个代码
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public static function userAcceptInfo()
    {
        $headers     = Yii::$app->request->headers;
        $user_accept = $headers->get('User-Agent');
        if (false !== stripos($user_accept, 'micromessenger')) {
            return 'weixin';
        } elseif (false !== stripos($user_accept, 'ios')) {
            return 'ios';
        } elseif (false !== stripos($user_accept, 'android')) {
            return 'android';
        } else {
            return 'm';
        }
    }
}
