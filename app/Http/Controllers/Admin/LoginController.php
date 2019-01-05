<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// 对接user model
use App\Http\Model\Users;

// 验证
use Illuminate\Support\Facades\Validator;
// 加密
use Illuminate\Support\Facades\Crypt;

// 引入外部文件
require (app_path() . '/code/Code.class.php');

class LoginController extends Controller
{

    // 生成验证码
    public function code()
    {
        session_start();
        $code = new \Code;
        $abc = $code->make();
    }

    // 用户登录
    public function login(Request $request) 
    {
    	if ($request->isMethod('get')) {
    		return view('admin.login');
    	} else if ($request->isMethod('post')) {
    		session_start();
    		$input = $request->except('_token');

            $code = new \Code;
            $_code = $code->get();

            if (strtoupper($request->code) != $_code) {
                return view('admin.login')->with('errors', '验证码错误！');
            }
            
    		$user = Users::where('account', $request->user_account)->first();

    		if ($user) {
    			if ($user->password != $request->user_pass) {
    				return view('admin.login')->with('errors','密码错误！');
    			}
    		} else {
    			return view('admin.login')->with('errors', '用户不存在！');
    		}
    		
    		// 储存数据
    		session(['user' => $user]);
    		// 跳转到后台首页
    		return redirect('admin/index');
    	}
    }

    // 用户注册
    public function register(Request $request, Users $users) 
    {
    	if ($request->isMethod('get')) {
    		return view('admin.register');
    	} else if ($request->isMethod('post')) {

            if($request->user_account == $request->user_pass) {
                return view('admin.register')->with('errors','账号密码不允许一样！');
            }
    		// dd($request->all());
            session_start(); 
            $code = new \Code;
            $_code = $code->get();
            // dd($_code);
                
            // 验证验证码
            if( strtoupper($request->code) != $_code ){
                $request->session()->flash('user_account', $request->input('user_account'));
                $request->session()->flash('user_pass', $request->input('user_pass'));
                $request->session()->flash('user_pass_confirmation', $request->input('user_pass_confirmation'));
                return view('admin.register')->with('errors','验证码错误！');
            }
    		// 设置规则
    		$rules = [
    			'user_pass' => 'between:6,20|confirmed'
    		];

    		$message = [
    			'user_pass.between' => '密码请在6~20位之间',
    			'user_pass.confirmed' => '密码和确认密码不一致！'
    		];

    		// 验证数据
    		$validator = Validator::make($request->input(), $rules, $message);

    		if ( $validator->passes() ) {
    			$user = $users->where('account', $request->user_account)->first();

    			if ($user) {
    				return view('admin.register')->with('errors', '用户已存在！');
    			} else {
                    $newUser = new Users;
                    $newUser->account   = $request->user_account;
                    $newUser->password  = $request->user_pass;
                    $newUser->authority = '普通用户';
                    $newUser->penname   = '普通用户';

    				// 插入数据
    				$result = $newUser->save();

                    if ($result) {
    				    echo '注册成功！'; 
                    }else { 
                        return view('admin.register')->with('errors', '注册失败！');
                    }
    			}
    		} else {

    			// dd($validator->errors()->all());

    			return view('admin.register')->withErrors($validator);
    		}
    	}
    }

    // 用户退出
    public function logout() {
        // dd("退出成功");
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
