@extends('layout.hou')

@section('title', '修改密码-后台-嘟嘟家')

@section('layout.content')
<style type="text/css">
.site-title fieldset {
  border: none;
  border-top: 1px solid #eee;
  margin-top: 20px;
  font-size: 20px;
}
.for-thumb { position: relative; margin-bottom: 20px; }
.for-thumb input { position: absolute; left: 0; top: 0; width: 100px; height: 100%; opacity: 0; }
.for-thumb img { max-width: 100px; height: auto; }
.layui-form-label { width: 150px; }
</style>
<div class="site-title">
  <fieldset><legend><a name="use">个人资料</a></legend></fieldset>
</div>
<div class="site-text site-block" style="width: 800px;">
<div class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">账号：</label>
    <div class="layui-input-inline">
      <input type="text" readonly value="{{session('user.account')}}" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">仅可读</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">旧密码：</label>
    <div class="layui-input-inline">
      <input type="password" name="old-password" required lay-verify="required" placeholder="请输入旧密码" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">新密码：</label>
    <div class="layui-input-inline">
      <input type="password" name="new-password" required lay-verify="required" placeholder="请输入新密码" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">再次新密码：</label>
    <div class="layui-input-inline">
      <input type="password" name="comfirm-new-password" required lay-verify="required" placeholder="请再次确认新密码" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label"></label>
    <div class="layui-input-inline">
      <button class="layui-btn" onclick="submitPsw(this)">立即提交</button>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
$(function (){
	
})

function submitPsw(obj) {
  if ($('input[name="new-password"]').val().length < 6 || $('input[name="new-password"]').val().length > 20) {
    layer.msg('新密码请在6~20位之间！');
    return false;
  }
  if ($('input[name="new-password"]').val() != $('input[name="comfirm-new-password"]').val()) {
    layer.msg('两次输入密码不相同！');
    return false;
  }
  $(this).attr('disabled', 'disabled');

  $.ajax({
    url: '/admin/user/password',
    type: 'post',
    data: {
      'old-password' : $('input[name="old-password"]').val(),
      'new-password' : $('input[name="new-password"]').val(),
      'comfirm-new-password' : $('input[name="comfirm-new-password"]').val(),
      '_token' : "{{ csrf_token() }}"
    },
    dataType: 'json',
    success: function (data) {
      if (data.code == -1) {
        layer.open({
          title: data.msg,
          content: data.error
        }); 
        $(this).removeAttr('disabled');
      } else {
        layer.msg(data.msg, function(){
          window.location.href = '/admin/login';
        });
      }
    }
  })
}
</script>
@endsection