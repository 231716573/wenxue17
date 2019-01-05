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
	  <button class="layui-btn layui-btn-radius layui-btn" onclick="javascript:$('.add_nav').show();">添加友情链接</button>
	</div>
	<h2>友情链接</h2>
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
	  	<?php foreach ($links as $link): ?>
	    <tr>
	    	<td><input type="text" onchange="changeOrder(this, {{$link->link_id}})" value="{{$link->link_order}}" style="width:30px; padding:3px 5px; text-align: center;"></td>
	      <td>{{$link->link_name}}</td>
	      <td>{{$link->link_alias}}</td>
	      <td>{{$link->link_url}}</td>
	      <td>
	        <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="openLink(this, {{$link->link_id}})">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm layui-btn-danger" onclick="delLink(this, {{$link->link_id}})">
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
	      <input type="text" name="link_order" required lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="link_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">英文</label>
	    <div class="layui-input-block">
	      <input type="text" name="link_alias" required  lay-verify="required" placeholder="请输入英文" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">地址</label>
	    <div class="layui-input-block">
	      <input type="text" name="link_url" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn" type="button" onclick="addLink(this)">增加</button>
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
	      <input type="text" name="link_order" required lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="link_name" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
		<div class="layui-form-item">
	    <label class="layui-form-label">英文</label>
	    <div class="layui-input-block">
	      <input type="text" name="link_alias" required  lay-verify="required" placeholder="请输入英文" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">地址</label>
	    <div class="layui-input-block">
	      <input type="text" name="link_url" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label"></label>
	    <div class="layui-input-block">
	      <button class="layui-btn update-submit" type="button" onclick="updateLink(this)">确认</button>
		  	<button class="layui-btn" type="button" onclick="javascript:$('.update_nav').hide();">关闭</button>
	    </div>
	  </div>
	</form>
	</div>
</div>

<script type="text/javascript">

function openLink(obj, nid) {
	$('.update_nav').show();
	$.ajax({
		url: `/admin/link/openLink?link_id=${nid}`,
		type: 'get',
		success: function (data) {
			// console.log(data)
			if (data.code == 0) {
				$('.update_nav input[name=link_order]').val(data.data.link_order)
				$('.update_nav input[name=link_name]').val(data.data.link_name)
				$('.update_nav input[name=link_alias]').val(data.data.link_alias)
				$('.update_nav input[name=link_url]').val(data.data.link_url)
				$(".update-submit").attr('link_id', data.data.link_id);
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
function updateLink(obj) {
	$(obj).attr('disabled', 'disabled');
	var postData = {
		link_order: $('.update_nav input[name=link_order]').val(),
		link_name: $('.update_nav input[name=link_name]').val(),
		link_alias: $('.update_nav input[name=link_alias]').val(),
		link_url: $('.update_nav input[name=link_url]').val(),
		link_id: $(".update-submit").attr('link_id'),
		_token: "{{ csrf_token() }}"
	};
	$.ajax({
		url: '/admin/link/update',
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
		url: '/admin/link/changeOrder?link_id='+nid+'&link_order='+$(obj).val(),
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
function addLink(obj) {
	var formData=new FormData($("#addForm")[0]);

	$.ajax({
		url: '/admin/link/add',
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

function delLink(obj, nid) {
	$.ajax({
		url: '/admin/link/delete?link_id='+nid,
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