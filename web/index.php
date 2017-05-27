<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

//腾讯云配置
// Windows
if (PHP_OS === 'WINNT') {
    $sdkConfig = 'W:\web2\art-calendar\sdk.config';

// Linux
} else {
    $sdkConfig = '/etc/qcloud/sdk.config';
}

if (!file_exists($sdkConfig)) {
    echo "SDK 配置文件（{$sdkConfig}）不存在";
    die;
}

$sdkConfig = json_decode(file_get_contents($sdkConfig), true);
\QCloud_WeApp_SDK\Conf::setup(array(
    'ServerHost'         => $sdkConfig['serverHost'],
    'AuthServerUrl'      => $sdkConfig['authServerUrl'],
    'TunnelServerUrl'    => $sdkConfig['tunnelServerUrl'],
    'TunnelSignatureKey' => $sdkConfig['tunnelSignatureKey'],
    'NetworkTimeout'     => $sdkConfig['networkTimeout'],
));

(new yii\web\Application($config))->run();
