<?php

return [
    'adminEmail'    => 'admin@example.com',
    'pagesize'      => 10,
    'remind_minute' => 5, //分钟
    'PIC_HOST_URL'  => "http://localhost:8080", //分钟
    'price_sel'     => [
        '10' => [-1, 0],
        '11' => [0, 100],
        '12' => [100, 300],
        '13' => [300, 500],
        '14' => [500],
    ],
    'users'=>[
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin888',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        // '101' => [
        //     'id' => '101',
        //     'username' => 'demo',
        //     'password' => 'demo',
        //     'authKey' => 'test101key',
        //     'accessToken' => '101-token',
        // ],
    ],
    'appid'         => 'wx512687a03a2cebc0',
    'appsecret'     => 'eab9fd43a40736abcdb1c0d2a4f59281',
    'template_id'   => 'd4-90cIo0ff1FjdpMy66TSLQpsRRGrjsFP6vjB09fwA',
    'remind_url'    => '',

];
