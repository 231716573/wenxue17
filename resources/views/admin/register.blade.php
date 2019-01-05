@extends('layout.top')

@section('title', '用户注册')


@section('layout.content')
<div class="container">
    <div class="row" style="margin-top:50px;">
        <div class="col-md-6 col-sm-offset-3">
            <div class="panel panel-primary">
            	<!-- 标题 -->
                <div class="panel-heading">用户注册</div>
                <!-- 主体 -->
				<div class="panel-body">
					
					<form class="form-horizontal" method="post" action="">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="user_account" class="col-sm-2 control-label">账&nbsp;&nbsp;&nbsp;&nbsp;号</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="user_account" placeholder="请输入账号" value="{{ session('user_account') ? session('user_account') : '' }}" required>
							</div>
						</div>
						<div class="form-group">
							<label for="user_pass" class="col-sm-2 control-label">密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="user_pass" placeholder="请输入密码" value="{{ session('user_pass') ? session('user_pass') : '' }}" required>
							</div>
						</div>
						<div class="form-group">
							<label for="user_pass" class="col-sm-2 control-label">确认密码</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="user_pass_confirmation" placeholder="请再次输入密码" value="{{ session('user_pass_confirmation') ? session('user_pass_confirmation') : '' }}" required>
							</div>
						</div>


						<div class="form-group">
							<label for="code" class="col-sm-2 control-label">验证码</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="code" placeholder="请输入验证码" style="display: inline-block; width:120px;"><img src="{{ url('/admin/code') }}" class="newcode" style="cursor: pointer;" alt="验证码" onclick="this.src='{{ url('admin/code') }}?'+Math.random() " required>
							</div>
						</div>
		
                      	<div class="form-group">
                      		<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">注册</button>
							</div>
                      	</div>
                      	<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10" style="color:red;">
								@if(count($errors)>0)
					                @if(is_object($errors))
					                    @foreach($errors->all() as $error)
					                        <p>{{$error}}</p>
					                    @endforeach
					                @else
					                    <p>{{$errors}}</p>
					                @endif
						        @endif
							</div>
						</div>
					</form>
				</div>
				<!-- 版权尾部 -->
				<div class="panel-footer text-right">版权所有，小波专用</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function (){

})
</script>
@endsection