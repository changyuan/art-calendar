<?php

namespace app\enum;

class CodeEnum
{
    const CODE='code';
    const MSG='msg';
    const DATA='data';	

    public static $success=array(self::CODE=>1,self::MSG=>'success');

    public static $notFound=array(self::CODE=>-100,self::MSG=>'NOT FOUND');
    public static $exception=array(self::CODE=>-101,self::MSG=>'PROGRAM EXCETION OR REQUEST NOT EXIST');
    public static $notExistUser=array(self::CODE=>-102,self::MSG=>'用户不存在');
    public static $denyVisit=array(self::CODE=>-103,self::MSG=>'非法的请求');
    public static $needLogin=array(self::CODE=>-104,self::MSG=>'请登录');
    public static $noData=array(self::CODE=>-105,self::MSG=>'没有了');
    public static $paramError=array(self::CODE=>-106,self::MSG=>'参数错误');
    public static $existName=array(self::CODE=>-107,self::MSG=>'此名称已经存在');
    public static $optFail=array(self::CODE=>-108,self::MSG=>'操作失败，请稍后重试');
    public static $remindExpire=array(self::CODE=>-109,self::MSG=>'提醒时间已经过期');
    public static $isSetRemind=array(self::CODE=>-110,self::MSG=>'已设置提醒');


    public static $maxUploadNum=array(self::CODE=>-111,self::MSG=>'超出最大上传个数');
    public static $uploadFail=array(self::CODE=>-112,self::MSG=>'上传失败，稍后重试');
    public static $uploadTypeError=array(self::CODE=>-113,self::MSG=>'格式不允许上传');


    public static $noPushData=array(self::CODE=>-114,self::MSG=>'没有推送数据');
    public static $isDelFav=array(self::CODE=>-115,self::MSG=>'已经取消收藏');
    public static $sessionError=array(self::CODE=>-116,self::MSG=>'用户会话不存在，请确认请求参数或者重新登陆');


}