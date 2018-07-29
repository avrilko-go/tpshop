<?php

namespace app\Index\controller;

use app\admin\model\User;
use app\admin\validate\UserCheck;
use app\lib\MailHandler;
use app\lib\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use think\Controller;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;

class Account extends Base
{
    //用户登录
    public function login()
    {
        return view();
    }

    public function loginPost()
    {
        return \app\index\service\Account::login();
    }

    //用户注册
    public function register()
    {
        return view();
    }

    //忘记密码提交操作成功或失败提示
    public function passwordMessage()
    {
        $data=Request::param();

        $flag=1;
        if(Request::param('status')=='success'){
            $msg='发送成功，快去登录吧！';
        }else{
            $flag=0;
            $msg=Request::get('msg');
        }
        $this->assign(compact('msg','flag'));
        return view();
    }


    //注册提交操作
    public function registerPost()
    {
        (new UserCheck())->goCheck();
        $user=User::create(Request::only(['username','password','mobile_phone','email','register_type']));
        if($user){
            Session::delete('email_code');
            Session::delete('phone_code');
            Session::set('user',$user);
            $this->success('注册成功！正在为您跳转...',"/me/$user->id");
        }else{
            $this->error('注册失败！');
        }
    }

    //忘记密码
    public function forgetPassword()
    {
        return view();
    }

    //注册用户用户名唯一性检测
    public function usernameCheck()
    {
        $username=Request::post('username');
        $user=User::where('username',$username)->find();
        if($user){
            return false;
        }
        return true;
    }

    //注册手机号码检测
    public function phoneCheck()
    {
        $mobile_phone=Request::post('mobile_phone');
        $user=User::where('mobile_phone',$mobile_phone)->find();
        if($user){
            return false;
        }
        return true;
    }

    //注册邮箱检测
    public function emailCheck()
    {
        $email=Request::post('email');
        $user=User::where('email',$email)->find();
        if($user){
            return false;
        }
        return true;
    }

    //注册发送邮件
    public function sendEmail()
    {
        return \app\index\service\Account::sendEmail();
    }

    //注册发送短信
    public function sendMessage()
    {
        return \app\index\service\Account::sendMessage();
    }


    //通过手机号码找回密码
    public function forgetSendMessage()
    {
        return \app\index\service\Account::forgetSendMessage();
    }

    //验证短信并生成新密码发送给用户
    public function checkAndMakePasswordByPhone()
    {
        return \app\index\service\Account::checkAndMakePasswordByPhone();
    }

    //通过邮箱找回密码
    public function forgetSendEmail()
    {
        $data=\app\index\service\Account::forgetSendEmail();
        $msg=$data['msg'];
        $data['status'] ? $flag=1 : $flag=0;
        $this->assign(compact('msg','flag'));
        return view('password_message');
    }


    //邮箱验证码验证
    public function emailCheckCode()
    {
        $send_code=Request::post('send_code');
        if(Session::get('email_code')==$send_code){
            return true;
        }
        return false;
    }

    //短信验证码验证
    public function messageCheckCode()
    {
        $send_code=Request::post('mobile_code');
        if(Session::get('phone_code')==$send_code){
            return true;
        }
        return false;
    }

    //用户登出
    public function logout()
    {
        Session::delete('user');
        Cookie::delete('username');
        Cookie::delete('password');
        $this->redirect('/login');
    }


}
