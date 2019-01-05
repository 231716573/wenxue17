@extends('layout.hou')

@section('title', '用户管理-嘟嘟家')

@section('layout.content')
<style type="text/css">
.layui-table th { text-align: center; }
.detail-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 99; }
.detail-wrap { position: fixed; top: 20%; left: 50%; z-index: 100; background-color: #fff; width: 600px; margin-left: -320px;padding:20px; border-radius: 5px; -webkit-border-radius: 5px; line-height: 31px; }
.detail-wrap tr td:first-child { text-align: right; padding-right: 10px; width: 100px; }
.auth-select { height: 38px;line-height: 38px; padding: 0 18px; margin-right: 20px; color: #666; }
</style>
<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">正常用户</li>
    <li onclick="getExamine()">待审核用户</li>
    <li onclick="getClosure()">封禁用户</li>
  </ul>
  <div class="layui-tab-content">
  	<!-- 正常用户 -->
    <div class="layui-tab-item layui-show">
			<table class="layui-table">
			  <colgroup>
			    <col width="100">
			    <col width="150">
			    <col>
			  </colgroup>
			  <thead>
			    <tr>
			    	<th>账号</th>
			      <th>昵称</th>
			      <th>级别</th>
			      <th>加入时间</th>
			      <th>最后登录</th>
			      <th>备注</th>
			      <th>操作</th>
			    </tr> 
			  </thead>
			  <tbody class="examine"></tbody>
			</table>
    </div>
    <!-- 待审核用户 -->
    <div class="layui-tab-item">
		<table class="layui-table">
		  <colgroup>
		    <col width="100">
		    <col width="150">
		    <col>
		  </colgroup>
		  <thead>
		    <tr>
		    	<th>账号</th>
		      <th>申请时间</th>
		      <th>操作</th>
		    </tr> 
		  </thead>
		  <tbody></tbody>
		</table>
    </div>
    <!-- 封禁用户 -->
    <div class="layui-tab-item">
		<table class="layui-table">
		  <colgroup>
		    <col width="100">
		    <col width="150">
		    <col>
		  </colgroup>
		  <thead>
		    <tr>
		    	<th>账号</th>
		      <th>昵称</th>
		      <th>级别</th>
		      <th>加入时间</th>
		      <th>最后登录</th>
		      <th>封号原因</th>
		      <th>操作</th>
		    </tr> 
		  </thead>
		  <tbody class="closure"></tbody>
		</table>
    </div>
  </div>
</div>

<div class="detail" style="display: none;">
	<div class="detail-bg" onclick="javascript:$('.detail').hide();"></div>
	<div class="detail-wrap"></div>
</div>
 
<script>
$(function () {
	layui.use('form', function(){
  	var form = layui.form;
	});
	getUser()
})
// 获取正常用户
function getUser() {
	$.ajax({
		url: '/admin/user/getUser',
		type: 'GET',
		success: function (data) {
			// console.log(data)
			if (data.code != 0) return false;
			var list = data.data;
			for (var i = 0; i < list.length; i++) {

				var newTr = '<tr>'
			    	+ '<td>'+list[i].account+'</td>'
			      + '<td>'+list[i].penname+'</td>'
			      + '<td>'+list[i].authority+'</td>'
			      + '<td>'+list[i].last_login_at+'</td>'
			      + '<td>'+list[i].created_at+'</td>'
			      + '<td>'+(list[i].description ? list[i].description : '')+'</td>'
			      + '<td>'
			      +		'<button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-normal" onclick="seeDetail(\''+list[i].account+'\')">查看资料</button>'
			      +		'<button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-warm" onclick="getPower(\''+list[i].account+'\')">授权</button>'
						+		'<button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" onclick="closure(this, \''+list[i].account+'\')">封号</button>'
			      + '</td>'
			    + '</tr>';

			  $('.examine').append(newTr);
			}
			
		}
	})
}

// 获取未审核用户
function getExamine() {

}

// 获取封禁了的用户
function getClosure() {
	$.ajax({
		url: '/admin/user/getClosure',
		type: 'GET',
		success: function (data) {
			// console.log(data)
			if (data.code != 0) return false;
			$('.closure').html('');
			var list = data.data;
			for (var i = 0; i < list.length; i++) {

				var newTr = '<tr>'
			    	+ '<td>'+list[i].account+'</td>'
			      + '<td>'+list[i].penname+'</td>'
			      + '<td>'+list[i].authority+'</td>'
			      + '<td>'+list[i].last_login_at+'</td>'
			      + '<td>'+list[i].created_at+'</td>'
			      + '<td>'+(list[i].description ? list[i].description : '')+'</td>'
			      + '<td>'
			      +		'<button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-normal" onclick="seeDetail(\''+list[i].account+'\')">查看资料</button>'
						+		'<button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" onclick="unlock(this, \''+list[i].account+'\')">解封</button>'
			      + '</td>'
			    + '</tr>';

			  $('.closure').append(newTr);
			}
			
		}
	})
}

// 封号！
function closure(obj, uid) {
	var description=prompt("请输入封号原因","")
  if (description != null && description != '') {
		layer.confirm('是否确定封禁此账号：'+uid, function(index){
	  	$.ajax({
	  		url: '/admin/user/closure?account='+uid+'&description='+description,
				type: 'GET',
	  		success:function (data) {
	  			if (data == 1) {
		  			$(obj).parent().parent().remove();

		  			layer.close(index);
	  			}
	  		}
	  	})
		}); 
	} else {
		layer.close();
	}
}
// 解封
function unlock(obj, uid) {
	layer.confirm('是否确定清除原因并解禁此账号：'+uid, function(index){
  	$.ajax({
  		url: '/admin/user/unlock?account='+uid,
			type: 'GET',
  		success:function (data) {
  			if (data == 1) {
	  			$(obj).parent().parent().remove();

	  			layer.close(index);
  			}
  		}
  	})
	}); 
}

function getPower(account) {
	$('.detail-wrap').html('');
	$(".detail").show();

	$.ajax({
		url: '/admin/user/power',
		type: 'get',
		data: {
			account: account
		},
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			if (data.code == 0) {
				var aOption = '';
				var add = '';
				for (var i in data.data) {
					aOption += '<option value="'+data.data[i].auth_num+'">'+data.data[i].auth_name+'</option>';
				}
				var newDiv = '<div>等级修改，用户：'+account+'</div>'
										+	'<hr style="margin:10px 0">'
										+	'<div class="">'
										+		'<div class="layui-inline">'
									  +      '<select name="authority" class="auth-select">'
									  +        '<option value="">请选择一个等级</option>'
									  +         aOption
									  +      '</select>'
									  +    '</div>'
									  +    '<button class="layui-btn" onclick="givePower(\''+account+'\')">确定</button>'
										+	'</div>';

				$('.detail-wrap').append(newDiv);
			}
		}
	})
}

// 提交授权
function givePower(account) {
	$(this).attr('disabled', 'disabled');

	$.ajax({
		url: '/admin/user/power',
		type: 'post',
		data: {
			account: account,
			authority: $('select[name="authority"]').val(),
			_token: "{{ csrf_token() }}"
		},
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
		}
	})
}

// 查看详情信息
function seeDetail(uid) {
	$('.detail-wrap').html('');
	$(".detail").show();
	
	$.ajax({
		url: '/admin/user/detail?account='+uid,
		type: 'GET',
		success: function (data) {
			// console.log(data)
			if (data.code != 0) return false;

			var list = data.data;
			switch (list.status) {
				case 1:
					var status = '正常';
				break;
				case 0:
					var status = '正常';
				break;
				case -1:
					var status = '封禁';
				break;
			}

			var newTd = '<table>'
						+ '<tr><td>账号：</td><td>'+list.account+'</td></tr>'
						+ '<tr><td>性别：</td><td>'+list.sex+'</td></tr>'
						+ '<tr><td>笔名：</td><td>'+list.penname+'</td></tr>'
						+ '<tr><td>真实姓名：</td><td>'+list.realname+'</td></tr>'
						+ '<tr><td>级别：</td><td>'+list.authority+'</td></tr>'
						+ '<tr><td>手机号：</td><td>'+list.phone+'</td></tr>'
						+ '<tr><td>通讯地址：</td><td>'+list.address+'</td></tr>'
						+ '<tr><td>备注：</td><td>'+list.description+'</td></tr>'
						+ '<tr><td>最后登录：</td><td>'+list.last_login_at+'</td></tr>'
						+ '<tr><td>状态：</td><td>'+status+'</td></tr>'
						+ '</table>';

			$('.detail-wrap').append(newTd);
			
		}
	})

}
</script>
@endsection