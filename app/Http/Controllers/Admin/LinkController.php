<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// 对接 Links model
use App\Http\Model\Links;

class LinkController extends Controller
{
	public function index() {
		$links = Links::where('status', 0)->orderBy('link_order','asc')->get();
		return view('admin.link', [
				"links" => $links
			]);
	}

	// 添加
	public function add(Request $request) {
		if ($request->isMethod('post')) {
			$result = Links::where('link_name', $request->link_name)->first();

			if ($result) {
				$data = [
					"code" => -1,
					"msg"  => '添加失败',
					"error"=> '导航名称已存在！'
				];
				return $data;
			}

			$link = new Links;
			$link->link_order = $request->link_order;
			$link->link_name  = $request->link_name;
			$link->link_alias = $request->link_alias;
			$link->link_url = $request->link_url;

			$res = $link->save();

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
	public function openLink(Request $request) {
		$id = $request->link_id;
		$link = Links::where('link_id', $id)->first();
		if ($link) {
			$data = [
				"code" => 0,
				"msg"  => '查询成功',
				"data"=> $link
			];
			return $data;
		} else {
			$data = [
				"code" => -1,
				"msg"  => '查询失败',
				"error"=> $link
			];
		}
		return $data;
	}

	// 修改order
	public function changeOrder(Request $request) {
		$id = $request->link_id;
		$order = $request->link_order;

		$res = Links::where('link_id', $id)->update(['link_order' => $order]);
		if (!$res) {
			$data = [
				"code" => -1,
				"msg"  => '修改失败',
				"error"=> $res
			];
			return $data;
		}
	}

	// 修改 link 的内容
	public function update(Request $request) {
		$req = $request->except('_token');

		$updateData = [
			"link_order" => $req['link_order'],
			"link_name"  => $req['link_name'],
			"link_alias" => $req['link_alias'],
			"link_url"   => $req['link_url']
		];

		$res = Links::where('link_id', $req['link_id'])->update($updateData);

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
	// 删除 link 的内容
	public function del(Request $request) {
		$id = $request->link_id;

		$res = links::where('link_id', $id)->update(['status' => -1]);
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
