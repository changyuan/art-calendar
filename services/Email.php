<?php
	
namespace app\services;
use Yii;

class Email {

    //发送邮件
    public static function sendEmail($title,$content,$target=NULL,$type='text') {
        if(empty($title) || empty($content)){
            return false;
        }

        $mail= Yii::$app->mailer->compose();
        if($target !== NULL) {
            $mail->setTo($target);
        }
        $mail->setSubject($title);

        $result = false;
        if($type == 'text'){
            $mail->setTextBody($content); 
        }else if($type == 'html'){
            $mail->setHtmlBody($content); 
        }else{
            return false;
        }
        
        return $mail->send();
    }

}

?>