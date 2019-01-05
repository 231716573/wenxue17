@extends('layout.hou')

@section('title', '分类列表-嘟嘟家')

@section('layout.content')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<style type="text/css">
.layui-select { width: 100%; }
.layui-row { margin: 20px; }
.layui-table tr td:first-child { text-align: center; }
.layui-table th { text-align: center; }
.layui-btn-right { float: right; }
.add_cate_bg,.update_cate_bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 99; }
.add_cate_wrap,.update_cate_wrap { position: fixed; top: 15%; left: 50%; z-index: 100; background-color: #fff; width: 400px; margin-left: -220px;padding:20px; border-radius: 5px; -webkit-border-radius: 5px; line-height: 31px; }
</style>
<div class="layui-row">
	<div class="layui-btn-right">
	  <button class="layui-btn layui-btn-radius layui-btn" onclick="javascript:$('.add_cate').show();">添加分类</button>
	</div>
	<h2>分类列表</h2>
	<hr class="line-hr">
	<table class="layui-table">
	  <colgroup>
	    <col width="50">
	    <col width="200">
	    <col width="300">
	    <col width="100">
	    <col width="200">
	    <col>
	  </colgroup>
	  <thead>
	    <tr>
	    	<th>排序</th>
	      <th>分类</th>
	      <th>标题</th>
	      <th>查看次数</th>
	      <th>操作</th>
	    </tr> 
	  </thead>
	  <tbody>
	  	<?php foreach ($cates as $cate): ?>
	    <tr>
	    	<td><input type="text" onchange="changeOrder(this, {{$cate->cate_id}})" value="{{$cate->cate_order}}" style="width:30px; padding:3px 5px; text-align: center;"></td>
	      <td>{{$cate->cate_name}}</td>
	      <td>{{$cate->cate_title}}</td>
	      <td>{{$cate->cate_clicked}}</td>
	      <td>
	        <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="openCate(this, {{$cate->cate_id}})">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm layui-btn-danger" onclick="delCate(this, {{$cate->cate_id}})">
				    <i class="layui-icon">&#xe640;</i>
				  </button>
	      </td>
	    </tr>
	    <?php endforeach ?>
	  </tbody>
	</table>
</div>

<div class="add_cate" style="display: none;">
	<div class="add_cate_bg"></div>
	<div class="add_cate_wrap">
	<form id="addForm">
		{{ csrf_field() }}
		<div class="layui-form-item">
	    <label class="layui-form-label"><h3>新增分类</h3></label>
	    <div class="layui-input-block">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">父级分类</label>
	    <div class="layui-input-block">
	      <select name="cate_pid" class="layui-select">
					<option value="0" class="layui-option">--顶级分类--</option>
				</select>
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">标题</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">关键词</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_keyword" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">描述</label>
	    <div class="layui-input-block">
	      <textarea name="cate_description" placeholder="请输入相关描述" class="layui-textarea"></textarea>
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn" type="button" onclick="addCate(this)">增加</button>
		  	<button class="layui-btn" type="button" onclick="javascript:$('.add_cate').hide();">关闭</button>
	    </div>
	  </div>
	</form>
	</div>
</div>

<div class="update_cate" style="display: none;">
	<div class="update_cate_bg"></div>
	<div class="update_cate_wrap">
	<form id="addForm">
		{{ csrf_field() }}
		<div class="layui-form-item">
	    <label class="layui-form-label"><h3>修改分类</h3></label>
	    <div class="layui-input-block">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">父级分类</label>
	    <div class="layui-input-block">
	      <select name="cate_pid" class="layui-select">
					<option value="0" class="layui-option">--顶级分类--</option>
				</select>
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">标题</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">关键词</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_keyword" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">描述</label>
	    <div class="layui-input-block">
	      <textarea name="cate_description" placeholder="请输入相关描述" class="layui-textarea"></textarea>
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn update-submit" type="button" onclick="updateCate(this)">确认</button>
		  	<button class="layui-btn" type="button" onclick="javascript:$('.update_cate').hide();">关闭</button>
	    </div>
	  </div>
	</form>
	</div>
</div>

<script type="text/javascript">
function openCate(obj, cid) {
	$('.update_cate').show();
	$.ajax({
		url: `/admin/cate/openCate?cate_id=${cid}`,
		type: 'get',
		success: function (data) {
			// console.log(data)
			if (data.code == 0) {
				$('.update_cate input[name=cate_name]').val(data.data.cate_name)
				$('.update_cate input[name=cate_title]').val(data.data.cate_title)
				$('.update_cate input[name=cate_keyword]').val(data.data.cate_keyword)
				$('.update_cate textarea[name=cate_description]').val(data.data.cate_description)
				$(".update-submit").attr('cate_id', data.data.cate_id);
			} else {
				layer.open({
				  title: data.msg,
				  content: data.error
				});
			}
		}
	})
}
// 更新分类
function updateCate(obj) {
	$(obj).attr('disabled', 'disabled');
	var postData = {
		cate_pid : $('.update_cate select[name=cate_pid]').val(),
		cate_name :$('.update_cate input[name=cate_name]').val(),
		cate_title :$('.update_cate input[name=cate_title]').val(),
		cate_keyword :$('.update_cate input[name=cate_keyword]').val(),
		cate_description :$('.update_cate textarea[name=cate_description]').val(),
		cate_id :$('.update-submit').attr('cate_id'),
		_token: "{{ csrf_token() }}"
	};
	$.ajax({
		url: '/admin/cate/update',
		type: 'post',
		data: postData,
		dataType: 'json',
		success: function (data) {
			if (data.code == -1) {
				layer.open({
				  title: data.msg,
				  content: data.error
				}); 
			} else {
				layer.msg(data.msg, function(){
				  window.location.reload();
				}); 	
			}
			$(obj).removeAttr('disabled');
		}
	})
}
// 删除分类
function delCate(obj, cid) {
	$.ajax({
		url: '/admin/cate/delete?cate_id='+cid,
		type: 'get',
		success: function (data) {
			if (data.code == -1) {
				layer.open({
				  title: data.msg,
				  content: data.error
				}); 
			} else {
				layer.msg(data.msg, function(){
				  window.location.reload();
				});
			}
		}
	})
}
// 修改排序
function changeOrder(obj, cid) {
	$.ajax({
		url: '/admin/cate/changeOrder?cate_id='+cid+'&cate_order='+$(obj).val(),
		type: 'get',
		success: function (data) {
			if (data.code == -1) {
				layer.open({
				  title: data.msg,
				  content: data.error
				}); 
			}
		}
	})
}

// 添加内容
function addCate(obj) {
	var formData=new FormData($("#addForm")[0]);

	$.ajax({
		url: '/admin/cate/add',
		type: 'post',
		data: formData,
    async: false,
    cache: false,
    contentType: false,
    processData: false,
		success: function (data) {
			// console.log(data)
			if (data.code == 0) {
				layer.msg(data.msg, function(){
				  window.location.reload();
				}); 	
			} else {
				layer.open({
				  title: data.msg,
				  content: data.error
				}); 
			}
		}
	})
}
</script>
@endsection