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
	  <button class="layui-btn layui-btn-radius layui-btn" onclick="javascript:$('.add_nav').show();">添加轮播图</button>
	</div>
	<h2>轮播图管理</h2>
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
	  	<?php foreach ($sliders as $slider): ?>
	    <tr>
	    	<td><input type="text" onchange="changeOrder(this, {{$slider->slider_id}})" value="{{$slider->slider_order}}" style="width:30px; padding:3px 5px; text-align: center;"></td>
	      <td>{{$slider->slider_name}}</td>
	      <td>{{$slider->slider_alias}}</td>
	      <td>{{$slider->slider_url}}</td>
	      <td>
	        <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="openSlider(this, {{$slider->slider_id}})">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm layui-btn-danger" onclick="delSlider(this, {{$slider->slider_id}})">
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
	    <label class="layui-form-label"><h3>新增链接</h3></label>
	    <div class="layui-input-block">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">排序</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_order" required lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">英文</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_alias" required  lay-verify="required" placeholder="请输入英文" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">地址</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_url" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn" type="button" onclick="addSlider(this)">增加</button>
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
	      <input type="text" name="slider_order" required lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">英文</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_alias" required  lay-verify="required" placeholder="请输入英文" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">地址</label>
	    <div class="layui-input-block">
	      <input type="text" name="slider_url" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn update-submit" type="button" onclick="updateSlider(this)">确认</button>
		  	<button class="layui-btn" type="button" onclick="javascript:$('.update_nav').hide();">关闭</button>
	    </div>
	  </div>
	</form>
	</div>
</div>

<script type="text/javascript">

function openSlider(obj, nid) {
	$('.update_nav').show();
	$.ajax({
		url: `/admin/slider/openSlider?slider_id=${nid}`,
		type: 'get',
		success: function (data) {
			// console.log(data)
			if (data.code == 0) {
				$('.update_nav input[name=slider_order]').val(data.data.slider_order)
				$('.update_nav input[name=slider_name]').val(data.data.slider_name)
				$('.update_nav input[name=slider_alias]').val(data.data.slider_alias)
				$('.update_nav input[name=slider_url]').val(data.data.slider_url)
				$(".update-submit").attr('slider_id', data.data.slider_id);
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
function updateSlider(obj) {
	$(obj).attr('disabled', 'disabled');
	var postData = {
		slider_order: $('.update_nav input[name=slider_order]').val(),
		slider_name: $('.update_nav input[name=slider_name]').val(),
		slider_alias: $('.update_nav input[name=slider_alias]').val(),
		slider_url: $('.update_nav input[name=slider_url]').val(),
		slider_id: $(".update-submit").attr('slider_id'),
		_token: "{{ csrf_token() }}"
	};
	$.ajax({
		url: '/admin/slider/update',
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
		url: '/admin/slider/changeOrder?slider_id='+nid+'&slider_order='+$(obj).val(),
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
function addSlider(obj) {
	var formData=new FormData($("#addForm")[0]);

	$.ajax({
		url: '/admin/slider/add',
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

function delSlider(obj, nid) {
	$.ajax({
		url: '/admin/slider/delete?slider_id='+nid,
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