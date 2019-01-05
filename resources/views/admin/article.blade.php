@extends('layout.hou')

@section('title', '文章列表-嘟嘟家')

@section('layout.content')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<style type="text/css">
.layui-select { width: 100%; }
.layui-row { margin: 20px; }
.layui-table tr td { text-align: center; }
.layui-table th { text-align: center; }
.layui-btn-right { float: right; }
</style>
<div class="layui-row">
	<div class="layui-btn-right">
	  <button class="layui-btn layui-btn-radius layui-btn" onclick="javascript:$('.add_art').show();">添加文章</button>
	</div>
	<h2>分类列表</h2>
	<hr class="line-hr">
	<table class="layui-table" lay-size="sm">
	  <thead>
	    <tr>
	    	<th width="30">ID</th>
	      <th>作者</th>
	      <th width="80">查看分类</th>
	      <th>标题</th>
	      <th>查看次数</th>
	      <th>最后编辑时间</th>
	      <th>操作</th>
	    </tr> 
	  </thead>
	  <tbody>
	    <tr>
	    	<td>ID</td>
	      <td>作者</td>
	      <td>分类</td>
	      <td>标题</td>
	      <td>查看次数</td>
	      <td>最后编辑时间</td>
	      <td>
	        <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="openCate(this)">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm layui-btn-danger" onclick="delCate(this)">
				    <i class="layui-icon">&#xe640;</i>
				  </button>
	      </td>
	    </tr>
	  </tbody>
	</table>
</div>
@endsection