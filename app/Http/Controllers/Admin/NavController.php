<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// 对接user model
use App\Http\Model\Navs;

class NavController extends Controller
{
	public function index() {
		$navs = Navs::where('status', 0)->orderBy('nav_order','asc')->get();
		return view('admin.nav', [
				"navs" => $navs
			]);
	}

	// 添加
	public function add(Request $request) {
		if ($request->isMethod('post')) {
			$result = Navs::where('nav_name', $request->nav_name)->first();

			if ($result) {
				$data = [
					"code" => -1,
					"msg"  => '添加失败',
					"error"=> '导航名称已存在！'
				];
				return $data;
			}

			$nav = new Navs;
			$nav->nav_order = $request->nav_order;
			$nav->nav_name  = $request->nav_name;
			$nav->nav_alias = $request->nav_alias;
			$nav->nav_url = $request->nav_url;

			$res = $nav->save();

			if ($res) {
				$data = [
					"code" => 0,
					"msg"  => '添加成功'
				];
			} else {
				$data = [
					"code" => -1,
					"msg"  => '添加失败',
					"error"=> $res
				];
			}
			return $data;
		}
	}
	// 获取指定nav
	public function openNav(Request $request) {
		$id = $request->nav_id;
		$nav = Navs::where('nav_id', $id)->first();
		if ($nav) {
			$data = [
				"code" => 0,
				"msg"  => '查询成功',
				"data"=> $nav
			];
			return $data;
		} else {
			$data = [
				"code" => -1,
				"msg"  => '查询失败',
				"error"=> $nav
			];
		}
		return $data;
	}

	// 修改order
	public function changeOrder(Request $request) {
		$id = $request->nav_id;
		$order = $request->nav_order;

		$res = Navs::where('nav_id', $id)->update(['nav_order' => $order]);
		if (!$res) {
			$data = [
				"code" => -1,
				"msg"  => '修改失败',
				"error"=> $res
			];
			return $data;
		}
	}
	// 修改nav的内容
	public function update(Request $request) {
		$req = $request->except('_token');

		$updateData = [
			"nav_order" => $req['nav_order'],
			"nav_name"  => $req['nav_name'],
			"nav_alias" => $req['nav_alias'],
			"nav_url"   => $req['nav_url']
		];

		$res = Navs::where('nav_id', $req['nav_id'])->update($updateData);

		if ($res) {
			$data = [
				"code" => 0,
				"msg"  => '修改成功'
			];
		} else {
			$data = [
				"code" => -1,
				"msg"  => '修改失败',
				"error"=> $res
			];
		}
		return $data;
	}
	// 删除nav的内容
	public function del(Request $request) {
		$id = $request->nav_id;

		$res = Navs::where('nav_id', $id)->update(['status' => -1]);
		if ($res) {
			$data = [
				"code" => 0,
				"msg"  => '删除成功'
			];
		} else {
			$data = [
				"code" => -1,
				"msg"  => '删除失败',
				"error"=> $res
			];
		}
		return $data;
	}
}
