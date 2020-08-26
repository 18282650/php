<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Org\code\Code;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //后台登录页面
    public function login(){
        return view('admin.login');
    }
    //验证码生成
    public function code(){
        $code = new Code();
        return $code->make();
    }
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(6);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 150, $height = 50, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        \Session::flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }
    public function doLogin(Request $request){
        $input = $request->except('_token');
        //表单验证
        //Validator::make('需要验证的表单数据','验证规则','错误提示');
        //验证规则
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];
        $msg = [
            'username.required'=>'用户名不能为空',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码不能为空',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数字、字母、下划线组合',
        ];
        $validator = Validator::make($input,$rule,$msg);
        if($validator->fails()){
            return redirect('admin/login')->withErrors($validator)->withInput();
        }
        if(strtolower($input['code']) != strtolower(session()->get('code'))){
            return redirect('admin/login')->with('errors','验证码错误');
        }
        $user = User::where('user_name',$input['username'])->first();
        if(!$user){
            return redirect('admin/login')->with('errors','用户名不存在');
        }
        //
        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码不正确');
        }
        session()->put('user',$user);
        return redirect('admin/index');
    }
    public function index(){
        return view('admin.index');
    }
    //后台欢迎页
    public function welcome(){
        return view('admin.welcome');
    }
    //退出登录
    public function logout(){
        //清空session
        session()->flush();
        return redirect('admin/login')->with('errors','成功退出,请从新登录');
    }
    public function jiami(){
        //md5加密  md5()
        /*哈密加密
        Hash::make();
        验证 Hash::check($str,'数据库中的密码')*/
        //crypt加密
        //Crypt::encrypt();
        //验证
        //Crypt::decrypt()
        //return Crypt::encrypt('123456');
    }
}
