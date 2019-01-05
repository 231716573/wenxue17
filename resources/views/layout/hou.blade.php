<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>
  <link rel="stylesheet" href="{{ asset('layui/css/layui-2.1.4.css') }}">
  <script type="text/javascript" src="{{ asset('bootstrap/js/jquery-2.1.4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('layui/layui.js') }}"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header layui-bg-cyan">
    <div class="layui-logo">logo 图</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item">
        <a href="">前台管理</a>
        <dl class="layui-nav-child">
          <dd><a href="/admin/nav">导航列表</a></dd>
          <dd><a href="/admin/link">友情链接</a></dd>
          <dd><a href="/admin/slider">轮播图管理</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item">
        <a href="/article">文章管理</a>
        <dl class="layui-nav-child">
          <dd><a href="/admin/cate">文章分类</a></dd>
          <dd><a href="/admin/article">文章列表</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="/admin/user">用户管理</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="{{ session('user.thumb') }}" class="layui-nav-img">
          {{ session('user.penname') }}
        </a>
        <dl class="layui-nav-child">
          <dd><a href="/admin/user/account">基本资料</a></dd>
          <dd><a href="/admin/user/password">修改密码</a></dd>
          <dd><a href="/admin/logout">退出</a></dd>
        </dl>
      </li>
    </ul>
  </div>
  
  <div class="layui-body" style="left: 0;">
    
    @yield('layout.content')
    
  </div>
  
  <div class="layui-footer" style="left: 0;">
    <!-- 底部固定区域 -->
    &copy; 2018-2018 xiaoshuo.com 版权所有
  </div>
</div>
</body>
<script>
$(function () {
  var userSex = "{{ session('user.sex') }}";
  var userThumb = "{{ session('user.thumb') }}";

  var thumbDist = '/upload/thumb/';
  if (userThumb == '' && userSex == '女') {
    $('.layui-nav-img').attr('src', thumbDist+'girl.jpg');
  } else if (userThumb == '' && userSex == '男') {
    $('.layui-nav-img').attr('src', thumbDist+'boy.jpg');
  } else {
    $('.layui-nav-img').attr('src', thumbDist+userThumb);
  }
  //JavaScript代码区域
  layui.use('element', function(){
    var element = layui.element;
  });
  layui.use('layer', function(){
    var layer = layui.layer;
  }); 
})
</script>
</html>