@extends('layout.hou')

@section('title', '导航列表-嘟嘟家')

@section('layout.content')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<style type="text/css">
.layui-row { margin: 20px; }
.layui-table tr td:first-child { text-align: center; }
.layui-btn-right { float: right; }
.add_nav_bg,.update_nav_bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 99; }
.add_nav_wrap,.update_nav_wrap { position: fixed; top: 20%; left: 50%; z-index: 100; background-color: #fff; width: 400px; margin-left: -220px;padding:20px; border-radius: 5px; -webkit-border-radius: 5px; line-height: 31px; }
</style>
<div class="layui-row">
	<div class="layui-btn-right">
	  <button class="layui-btn layui-btn-radius layui-btn" onclick="javascript:$('.add_nav').show();">添加导航</button>
	</div>
	<h2>导航列表</h2>
	<hr class="line-hr">
	<table class="layui-table">
	  <colgroup>
	    <col width="50">
	    <col width="200">
	    <col width="300">
	    <col width="300">
	    <col width="200">
	    <col>
	  </colgroup>
	  <thead>
	    <tr>
	    	<th>排序</th>
	      <th>标题</th>
	      <th>英文名</th>
	      <th>地址</th>
	      <th>操作</th>
	    </tr> 
	  </thead>
	  <tbody>
	  	<?php foreach ($navs as $nav): ?>
	    <tr>
	    	<td><input type="text" onchange="changeOrder(this, {{$nav->nav_id}})" value="{{$nav->nav_order}}" style="width:30px; padding:3px 5px; text-align: center;"></td>
	      <td>{{$nav->nav_name}}</td>
	      <td>{{$nav->nav_alias}}</td>
	      <td>{{$nav->nav_url}}</td>
	      <td>
	        <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="openNav(this, {{$nav->nav_id}})">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm layui-btn-danger" onclick="delNav(this, {{$nav->nav_id}})">
				    <i class="layui-icon">&#xe640;</i>
				  </button>
	      </td>
	    </tr>
	    <?php endforeach ?>
	  </tbody>
	</table>
</div>

<div class="add_nav" style="display: none;">
	<div class="add_nav_bg"></div>
	<div class="add_nav_wrap">
	<form id="addForm">
		{{ csrf_field() }}
		<div class="layui-form-item">
	    <label class="layui-form-label"><h3>新增导航</h3></label>
	    <div class="layui-input-block">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">排序</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_order" required lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">英文</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_alias" required  lay-verify="required" placeholder="请输入英文" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">地址</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_url" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn" type="button" onclick="addNav(this)">增加</button>
		  	<button class="layui-btn" type="button" onclick="javascript:$('.add_nav').hide();">关闭</button>
	    </div>
	  </div>
	</form>
	</div>
</div>

<div class="update_nav" style="display: none;">
	<div class="update_nav_bg"></div>
	<div class="update_nav_wrap">
	<form>
		{{ csrf_field() }}
		<div class="layui-form-item">
	    <label class="layui-form-label"><h3>修改导航</h3></label>
	    <div class="layui-input-block">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">排序</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_order" required lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">英文</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_alias" required  lay-verify="required" placeholder="请输入英文" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">地址</label>
	    <div class="layui-input-block">
	      <input type="text" name="nav_url" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn update-submit" type="button" onclick="updateNav(this)">确认</button>
		  	<button class="layui-btn" type="button" onclick="javascript:$('.update_nav').hide();">关闭</button>
	    </div>
	  </div>
	</form>
	</div>
</div>

<script type="text/javascript">

function openNav(obj, nid) {
	$('.update_nav').show();
	$.ajax({
		url: `/admin/nav/openNav?nav_id=${nid}`,
		type: 'get',
		success: function (data) {
			// console.log(data)
			if (data.code == 0) {
				$('.update_nav input[name=nav_order]').val(data.data.nav_order)
				$('.update_nav input[name=nav_name]').val(data.data.nav_name)
				$('.update_nav input[name=nav_alias]').val(data.data.nav_alias)
				$('.update_nav input[name=nav_url]').val(data.data.nav_url)
				$(".update-submit").attr('nav_id', data.data.nav_id);
			} else {
				layer.open({
				  title: data.msg,
				  content: data.error
				});
			}
		}
	})
}
// 修改导航信息
function updateNav(obj) {
	$(obj).attr('disabled', 'disabled');
	var postData = {
		nav_order: $('.update_nav input[name=nav_order]').val(),
		nav_name: $('.update_nav input[name=nav_name]').val(),
		nav_alias: $('.update_nav input[name=nav_alias]').val(),
		nav_url: $('.update_nav input[name=nav_url]').val(),
		nav_id: $(".update-submit").attr('nav_id'),
		_token: "{{ csrf_token() }}"
	};
	$.ajax({
		url: '/admin/nav/update',
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
// 修改排序
function changeOrder(obj, nid) {
	$.ajax({
		url: '/admin/nav/changeOrder?nav_id='+nid+'&nav_order='+$(obj).val(),
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

// 添加导航
function addNav(obj) {
	var formData=new FormData($("#addForm")[0]);

	$.ajax({
		url: '/admin/nav/add',
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

function delNav(obj, nid) {
	$.ajax({
		url: '/admin/nav/delete?nav_id='+nid,
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
</script>
@endsection