<!DOCTYPE html>
<html>
@if(session()->has('msg'))
	<script>alert("{{session()->get('msg')}}")</script>
@endif
<head>
	<meta charset="utf-8">
	<title>在现场</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<script type="text/javascript" src="{{asset('admin/assets/js/jquery.min.js')}}"></script>

	<!--  <link rel="stylesheet" href="assets/css/style.css"> -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/loader-style.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/css/signin.css')}}">


	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>

	<![endif]-->
	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="{{asset('admin/assets/css/ico/minus.png')}}">
</head>

<body>
<!-- Preloader -->
<div id="preloader">
	<div id="status">&nbsp;</div>
</div>

<div class="container">



	<div class="" id="login-wrapper">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div id="logo-login">
					<h1>在现场管理系统
					</h1>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="account-box">
					<form role="form" action="" method="post">
						{!! csrf_field() !!}
						<div class="form-group" style="margin-top: 40px">
							<!--a href="#" class="pull-right label-forgot">Forgot email?</a-->
							<label for="inputUsernameEmail">用户名</label>
							<input type="text" name="a_name" value="{{old('inputadmin')}}" id="inputUsernameEmail" class="form-control">
						</div>
						<div class="form-group" style="margin: 30px 0">
							<!--a href="#" class="pull-right label-forgot">Forgot password?</a-->
							<label for="inputPassword">密码</label>
							<input type="password" name="a_password" id="inputPassword" class="form-control">
						</div>
						<div class="checkbox pull-left">

						</div>
						<button class="btn btn btn-primary pull-right" type="submit" style="margin-bottom: 20px">
							登 录
						</button>
					</form>
					<div class="row-block">
						<div class="row">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p>&nbsp;</p>
	<div style="text-align:center;margin:0 auto;">
		<h6 style="color:#fff;font-size:15px;">Copyright(C)2016 beishusoft.cn All Rights Reserved<br />
			上海倍数信息科技有限公司 沪ICP备18015475号</h6>
	</div>

</div>
</body>

</html>
