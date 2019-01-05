<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// 对接 Sliders model
use App\Http\Model\Sliders;

class SliderController extends Controller
{
	public function index() {
		$sliders = Sliders::where('status', 0)->orderBy('slider_order','asc')->get();
		return view('admin.slider', [
				"sliders" => $sliders
			]);
	}

	// 添加
	public function add(Request $request) {
		if ($request->isMethod('post')) {
			$result = Sliders::where('slider_name', $request->slider_name)->first();

			if ($result) {
				$data = [
					"code" => -1,
					"msg"  => '添加失败',
					"error"=> '导航名称已存在！'
				];
				return $data;
			}

			$slider = new Sliders;
			$slider->slider_order = $request->slider_order;
			$slider->slider_name  = $request->slider_name;
			$slider->slider_alias = $request->slider_alias;
			$slider->slider_url = $request->slider_url;

			$res = $slider->save();

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
	// 获取指定 slider
	public function openSlider(Request $request) {
		$id = $request->slider_id;
		$slider = Sliders::where('slider_id', $id)->first();
		if ($slider) {
			$data = [
				"code" => 0,
				"msg"  => '查询成功',
				"data"=> $slider
			];
			return $data;
		} else {
			$data = [
				"code" => -1,
				"msg"  => '查询失败',
				"error"=> $slider
			];
		}
		return $data;
	}

	// 修改order
	public function changeOrder(Request $request) {
		$id = $request->slider_id;
		$order = $request->slider_order;

		$res = Sliders::where('slider_id', $id)->update(['slider_order' => $order]);
		if (!$res) {
			$data = [
				"code" => -1,
				"msg"  => '修改失败',
				"error"=> $res
			];
			return $data;
		}
	}

	// 修改 slider 的内容
	public function update(Request $request) {
		$req = $request->except('_token');

		$updateData = [
			"slider_order" => $req['slider_order'],
			"slider_name"  => $req['slider_name'],
			"slider_alias" => $req['slider_alias'],
			"slider_url"   => $req['slider_url']
		];

		$res = Sliders::where('slider_id', $req['slider_id'])->update($updateData);

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
	// 删除 slider 的内容
	public function del(Request $request) {
		$id = $request->slider_id;

		$res = Sliders::where('slider_id', $id)->update(['status' => -1]);
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
