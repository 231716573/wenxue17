<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Model\Cate;

class CateController extends Controller
{
  public function index() {
  	$cates = (new Cate)->tree();

  	return view('admin.cate')->with('cates', $cates);
  }

  // 查看此内容
  public function openCate(Request $request) {
  	$id = $request->cate_id;

  	$res = Cate::where('cate_id', $id)->first();
		if ($res) {
			$data = [
				"code" => 0,
				"msg"  => '查询成功',
				"data" => $res
			];
		} else {
			$data = [
				"code" => -1,
				"msg"  => '查询失败',
				"error"=> '没有数据！' 
			];
		}
		return $data;
  }


  // 修改order
	public function changeOrder(Request $request) {
		$id = $request->cate_id;
		$order = $request->cate_order;

		$res = Cate::where('cate_id', $id)->update(['cate_order' => $order]);
		if (!$res) {
			$data = [
				"code" => -1,
				"msg"  => '修改失败',
				"error"=> $res
			];
			return $data;
		}
	}

	// 更新
	public function update(Request $request) {
		if ($request->isMethod('post')) {
			$reqAll = $request->except('_token');

			$updateData = [
				"cate_name"  => $reqAll['cate_name'],
				"cate_title" => $reqAll['cate_title'],
				"cate_pid"   => $reqAll['cate_pid'],
				"cate_keyword"    => $reqAll['cate_keyword'],
				"cate_description"=> $reqAll['cate_description'],
			];

			$res = Cate::where('cate_id', $reqAll['cate_id'])->update($updateData);

			if ($res) {
				$data = [
					"code" => 0,
					"msg"  => '修改成功',
					"data" => $res
				];
			} else {
				$data = [
					"code" => -1,
					"msg"  => '添加失败',
					"error"=> '请检查数据是否正确'
				];
			}

			return $data;
		}
	}

  // 添加
	public function add(Request $request) {
		if ($request->isMethod('post')) {
			$result = Cate::where('cate_name', $request->cate_name)->first();

			if ($result) {
				$data = [
					"code" => -1,
					"msg"  => '添加失败',
					"error"=> '导航名称已存在！'
				];
				return $data;
			}

			$cate = new Cate;
			$cate->cate_title = $request->cate_title;
			$cate->cate_name  = $request->cate_name;
			$cate->cate_keyword = $request->cate_keyword;
			$cate->cate_description = $request->cate_description;
			$cate->cate_pid = $request->cate_pid;

			$res = $cate->save();

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

	// 删除cate的内容
	public function del(Request $request) {
		$id = $request->cate_id;

		$res = Cate::where('cate_id', $id)->update(['status' => -1]);
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
