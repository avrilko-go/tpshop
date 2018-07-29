<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/7/6
 * Time: 10:09
 */

namespace app\index\service;


use app\admin\model\User;
use app\lib\MailHandler;
use app\lib\Utils;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;

class Account
{

    //用户登录操作
    public static function login()
    {
        $data=Request::post();
        $username=Request::post('username');
        $password=md5(Request::post('password'));
        $remember=Request::post('remember');

        $user=User::where('username',$username)->whereOr('email',$username)->whereOr('mobile_phone',$username)->find();
        if($user){
            if($user->password==$password){
                Session::set('user',$user);
                if($remember=='on'){
                    Cookie::set('username',Utils::encrypt($user->username),864000,'/');
                    Cookie::set('password',Utils::encrypt($user->password),864000,'/');
                }
                return json([
                    'error'=>0,
                    'message'=>"",
                    'url'=>''
                ]);
            }else{
                return json([
                    'error'=>1,
                    'message'=>"<i class='iconfont icon-minus-sign'></i>用户名或者密码错误",
                    'url'=>'',
                ]);
            }
        }else{
            return json([
                'error'=>1,
                'message'=>"<i class='iconfont icon-minus-sign'></i>用户名或者密码错误",
                'url'=>'',
            ]);
        }
    }

    //注册发送邮件
    public static function sendEmail()
    {
        $code=mt_rand(100000,999999);
        $content='您的验证码是：'.$code;
        $mail=new MailHandler([
            'Subject'=>'avrilko商城邮箱验证码',
            'Body'=>$content
        ]);
        $result=$mail->send(Request::post('email'));
        if($result){
            Session::set('email_code',$code);
            $msg=['status'=>0,'msg'=>'发送成功'];
        }else{
            $msg=['status'=>1,'msg'=>'发送失败'];
        }
        return $msg;
    }

    //注册发送短信
    public static function sendMessage()
    {
        $code=mt_rand(100000,999999);
        $config = config('message.code');
        $send = new \Aliyun\Send($config);
        $data = [
            'code' => $code
        ];
        $result=$send->sendSms(Request::post('phoneNum'),$data);
        if($result){
            Session::set('phone_code',$code);
            $msg=['status'=>0,'msg'=>'发送成功'];
        }else{
            $msg=['status'=>1,'msg'=>'发送失败'];
        }
        return $msg;
    }

    //通过手机号码找回密码
    public static function forgetSendMessage()
    {
        $phone=Request::post('phoneNum');
        $user=User::where('mobile_phone',$phone)->find();
        if($user){
            $code=mt_rand(100000,999999);
            $config = config('message.code');
            $send = new \Aliyun\Send($config);
            $data = [
                'code' => $code
            ];
            $result=$send->sendSms(Request::post('phoneNum'),$data);
            if($result){
                Session::set('phone_code_check',['code'=>$code,'phone'=>$phone]);
                $msg=['status'=>0,'msg'=>'发送成功'];
            }else{
                $msg=['status'=>1,'msg'=>'发送失败'];
            }
        }else{
            $msg=['status'=>1,'msg'=>'当前用户不存在'];
        }
        return json($msg);
    }


    //验证短信验证码并生成新密码发送给用户
    public static function checkAndMakePasswordByPhone()
    {
        $mobile_code=Request::post('mobile_code');
        $phone_code_check=Session::get('phone_code_check');
        $user=User::where('mobile_phone',$phone_code_check['phone'])->find();
        if($user){
            if($mobile_code==$phone_code_check['code']){
                Session::delete('phone_code_check');
                $code=mt_rand(100000,999999);
                $config = config('message.code');
                $send = new \Aliyun\Send($config);
                $data = [
                    'code' => $code
                ];
                $result=$send->sendSms($phone_code_check['phone'],$data);
                $user->password=md5($code);
                $user->save();
                return true;
            }
        }
        return false;
    }

    //忘记邮件密码发送
    public static function forgetSendEmail()
    {
        $data=Request::post();
        $username=Request::post('user_name');
        $email=Request::post('email');
        $user=User::where(['email'=>$email,'username'=>$username])->find();
        if($user){
            $code=mt_rand(100000,999999);
            $content='您的新密码是：'.$code;
            $mail=new MailHandler([
                'Subject'=>'avrilko商城重置密码',
                'Body'=>$content
            ]);
            $result=$mail->send(Request::post('email'));
            if($result){
                $user->password=md5($code);
                $user->save();
                return [
                    'status'=>true,
                    'msg'=>'发送成功'
                ];
            }else{
                return [
                    'status'=>false,
                    'msg'=>'发送邮件失败'
                ];
            }
        }else{
            return [
                'status'=>false,
                'msg'=>'输入用户名和邮箱不匹配'
            ];
        }
    }
}