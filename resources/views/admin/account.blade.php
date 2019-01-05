@extends('layout.hou')

@section('title', '个人资料-后台-嘟嘟家')

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
</style>
<div class="site-title">
  <fieldset><legend><a name="use">个人资料</a></legend></fieldset>
</div>
<div class="site-text site-block" style="width: 800px;">
<form class="layui-form" action="" method="post" enctype='multipart/form-data'>
	{{ csrf_field() }}
  <div class="layui-form-item">
    <label class="layui-form-label"></label>
  	<div class="layui-input-block for-thumb">
      <input type="file" name="thumb">
			<img src="" class="thumb">
  	</div>
    <label class="layui-form-label">账号</label>
    <div class="layui-input-inline">
      <input type="text" readonly value="{{session('user.account')}}" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">仅可读</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">性别</label>
    <div class="layui-input-block">
      <input type="radio" class="usersex" name="sex" value="男" title="男">
      <input type="radio" class="usersex" name="sex" value="女" title="女">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">笔名</label>
    <div class="layui-input-inline">
      <input type="text" name="penname" required  lay-verify="required" placeholder="请输入笔名" autocomplete="off" class="layui-input" value="{{session('user.penname')}}">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-inline">
      <input type="text" name="realname" required  lay-verify="required" placeholder="请输入真实姓名" autocomplete="off" class="layui-input" value="{{session('user.realname')}}">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">手机号</label>
    <div class="layui-input-inline">
      <input type="text" name="phone" required  lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input" value="{{session('user.phone')}}">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">通讯地址</label>
    <div class="layui-input-block">
      <input type="text" name="address" required  lay-verify="required" placeholder="请输入通讯地址" autocomplete="off" class="layui-input" value="{{session('user.address')}}">
    </div>
  </div>

<!--   <div class="layui-form-item">
    <label class="layui-form-label">选择框</label>
    <div class="layui-input-block">
      <select name="city" lay-verify="required">
        <option value=""></option>
        <option value="0">北京</option>
        <option value="1">上海</option>
        <option value="2">广州</option>
        <option value="3">深圳</option>
        <option value="4">杭州</option>
      </select>
    </div>
  </div> -->
  <div class="layui-form-item">
    <div class="layui-input-inline" style="text-align: right;">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
    </div>
    <div class="layui-form-mid layui-word-aux" style="color: red!important; ">
    @if(count($errors)>0)
    	{{$errors}}
    @endif
		</div>
  </div>
</form>
</div>
<script type="text/javascript">
$(function (){
	var userSex = "{{ session('user.sex') }}";
  var userThumb = "{{ session('user.thumb') }}";
	$(".usersex").each(function (){
		if( $(this).val() == userSex ){
			$(this).attr("checked", "checked");
		}
	})

  var thumbDist = '/upload/thumb/';
  if (userThumb == '' && userSex == '女') {
    $('.thumb').attr('src', thumbDist+'girl.jpg');
  } else if (userThumb == '' && userSex == '男') {
    $('.thumb').attr('src', thumbDist+'boy.jpg');
  } else {
    $('.thumb').attr('src', thumbDist+userThumb);
  }

  $(".for-thumb input").change(function(){
    var objUrl = getObjectURL(this.files[0]) ; 
    $(this).parent().find('img').attr("src", objUrl);
  });
})
//建立一個可存取到该file的url  
function getObjectURL(file) {  
    var url = null ;   
    if (window.createObjectURL!=undefined) { // basic  
        url = window.createObjectURL(file) ;  
    } else if (window.URL!=undefined) { // mozilla(firefox)  
        url = window.URL.createObjectURL(file) ;  
    } else if (window.webkitURL!=undefined) { // webkit or chrome  
        url = window.webkitURL.createObjectURL(file) ;  
    }  
    return url ;  
} 

layui.use('form', function(){
  var form = layui.form;
  
  //监听提交
  form.on('submit(formDemo)', function(data){

  });
});
</script>
@endsection