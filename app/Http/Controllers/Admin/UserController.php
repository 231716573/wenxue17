<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// 对接user model
use App\Http\Model\Users;
use App\Http\Model\Authority;

class UserController extends Controller
{
  public function index(Request $request) {
  	return view('admin.user');
  }

  // 获取所有正常用户
  public function getUser() {
  	$users = Users::where('status', 0)->get(['account', 'penname', 'authority', 'created_at', 'last_login_at', 'description']);

  	$data = [
  		"code" => 0,
  		"msg"  => "查询成功",
  		"data" => $users
  	];

  	return $data;
  }
  // 获取所有封禁用户
  public function getClosure() {
  	$users = Users::where('status', -1)->get(['account', 'penname', 'authority', 'created_at', 'last_login_at', 'description']);

  	$data = [
  		"code" => 0,
  		"msg"  => "查询成功",
  		"data" => $users
  	];

  	return $data;
  }

  public function detail(Request $request) {
  	$user = Users::where('account', $request->account)->first();

  	$data = [
  		"code" => 0,
  		"msg"  => "查询成功",
  		"data" => $user
  	];

  	return $data;
  }

  // 封号
  public function closure(Request $request) {
  	$res = Users::where('account', $request->account)->update(['status' => -1, 'description' => $request->description]);

  	return $res;
  }

  // 解封
  public function unlock(Request $request) {
  	$date = date("Y-m-d h:i:sa");

  	$user = Users::where('account', $request->account)->first();
		$res = Users::where('account', $request->account)->update(['status' => 0, 'description' => '因'.$user->description.'被封号，于'.$date.'解封']);

  	return $res;
  }

  // 个人资料
  public function account(Request $request) {
  	if ($request->isMethod('get')) {

  		return view('admin.account');

  	} else if ($request->isMethod('post')) {
      
      $user = Users::where('account', session('user.account'))->first();

      if ($user->authority != '超级管理员') {
        echo '你没有权限更改用户资料';
        return;
      } else if ($user->account != session('user.account')) {
        echo '非本人账号，擅自修改资料者，死全家！';
        return;
      }
      $images=$request->file('thumb');
      if ($images) {
        $filedir="upload/thumb/";

        $imagesName= $images->getClientOriginalName(); // 获取上传图片的文件名
        $extension = $images -> getClientOriginalExtension(); //获取上传图片的后缀名
        $newImagesName=time().'_'.$imagesName;// 重新命名上传文件名字

        $moveRes = $images->move($filedir,$newImagesName); // 移动文件到目录下

        if ($user->thumb != '') {
          $delFile = $filedir.$user->thumb; // 删除旧的路径文件

          if(!unlink($delFile)) {
            echo "文件{$delFile}删除失败";
            exit;
          }
        }

        $input = $request->except('_token', 'uid');
        // 储存新的路径
        $input['thumb'] = $newImagesName;

      } else {
        $input = $request->except('_token', 'uid', 'thumb');
      }

  		$re = Users::where('account', session('user.account'))->update($input);
  		if( $re ){
  			$newUser = Users::where('account', session('user.account'))->first();

	  		// 储存新数据
	      session(['user'=>$newUser]);
  			return view('admin.account', compact('newUser'))->with('errors','个人资料修改成功！');
  		}else{
  			return view('admin.account', compact('newUser'))->with('errors','个人资料修改失败！');
  		}

  	}
  }

  // 修改用户等级
  public function power(Request $request) {
    if ($request->isMethod('post')) {
      $reqAccount   = $request->account;
      $reqAuthority = $request->authority;
      switch ($reqAuthority){
        case '0':
          $authority = '普通会员';

          break;
        case '10':
          $authority = '超级管理员';

          break;
        default:
          $authority = 'VIP'.$reqAuthority;
      }

      $res = Users::where('account', $reqAccount)->update(['authority' => $authority]);

      if ($res) {
        $data = [
          "code" => 0,
          "msg"  => "授权成功"
        ];
      } else {
        $data = [
          "code" => -1,
          "msg"  => '授权失败',
          "error"=> '请连续开发人员！'
        ];
      }
      return $data;

    } else {
      $res = Authority::where('status', 0)->get(['auth_name', 'auth_num']);

      if ($res) {
        $data = [
          "code" => 0,
          "msg"  => "查询成功",
          "data" => $res
        ];
      }
      return $data;
    }
  }

  // 修改个人密码
  public function password(Request $request) {
    if ($request->isMethod('get')) {

      return view('admin.password');

    } else if ($request->isMethod('post')) { 
      $reqAll = $request->except('_token');

      $user = Users::where('account', session('user.account'))->first();

      // 判断是否存在
      if ($user) {
        // 判断旧密码是否正确
        if ($user->password != $reqAll['old-password']) {
          $data = [
            "code" => -1,
            "msg"  => '修改失败',
            "error"=> '旧密码不正确！'
          ];
        } else {
          $res = Users::where('account', session('user.account'))->update(['password' => $reqAll['new-password']]);
          if ($res) {
            $data = [
              "code" => 0,
              "msg"  => "修改成功"
            ];
            session(['user'=>null]);
          } else {
            $data = [
              "code" => -1,
              "msg"  => '修改失败',
              "error"=> '请联系管理员！'
            ];
          }
        }
      } else {
        $data = [
          "code" => -1,
          "msg"  => '修改失败',
          "error"=> '没有此账号！'
        ];
      }

      return $data;
    }
  }
}
