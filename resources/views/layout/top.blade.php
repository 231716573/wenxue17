@extends('layout.login')

<!-- 头顶挂件 -->
@section('layout.top')
<!-- 导航栏 -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/admin/index" style="width:55px;"><img src="../images/logo.png" alt="logo" style="width:100%;"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('admin/') }}">后台首页</a></li>
                <li><a href="{{ url('/') }}">网站首页</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if( session('user.user_name') )
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{session('user.user_name')}}，你好<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/admin/profile') }}">个人资料</a></li>
                            <li><a href="{{ url('/admin/lostpsw') }}">修改密码</a></li>
                            <li><a href="{{ url('/admin/logout') }}">退出</a></li>
                        </ul>
                    </li>
                @else
                    <li role="presentation"><a href="{{ url('admin/login') }}">登录</a></li>
                    <li role="presentation"><a href="{{ url('admin/register') }}">注册</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@endsection

<!-- 内容 -->
@section('layout.content')
<div class="col-xs-12 col-sm-9 col-md-10">
    @section("content")
        
    @show
</div>
@endsection