<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/7/4
 * Time: 21:34
 */

namespace app\lib;


use PHPMailer\PHPMailer\PHPMailer;

class MailHandler
{
    private $mail;

    public function __construct($option=[])
    {
        $mail=new PHPMailer();

        $config=config('mail.');
        $option=array_merge($config,$option);
        $mail->isSMTP();
        foreach ($option as $k=>$v){
            $mail->$k=$v;
        }
        $this->mail=$mail;
    }


    public function send($to)
    {
        $this->mail->addAddress($to);
        return $this->mail->send();
    }
}