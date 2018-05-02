@extends("admin/layouts/admin")
@section('content')
	<ul id="breadcrumb">
		<li>
			<span class="entypo-home"></span>
		</li>
		<li><i class="fa fa-lg fa-angle-right"></i>
		</li>
		<li><a href="{{url('admin/adminlists')}}" title="首页">首页</a>
		</li>
		<li><i class="fa fa-lg fa-angle-right"></i>
		</li>
		<li><a href="{{url('admin/adminadd')}}" title="管理员添加">管理员添加</a>
		</li>
	</ul>
	<!-- END OF BREADCRUMB -->

	<!---- 面包屑导航end-->
	@if(session()->has('msg'))
		<script>alert("{{session()->get('msg')}}")</script>
		@endif
				<!-- 内容start-->
		<div class="content-wrap">
			<div class="row">
				<div class="col-sm-12">
					<div class="nest" id="validationClose">
						<div class="title-alt">
							<h6>
								添加管理员</h6>
						</div>
						<div class="body-nest" id="validation">
							<div class="form_center">
								<form class="form-horizontal" action="{{url("admin/adminupdate")}}" method="post">
									{!! csrf_field() !!}
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">管理员名称</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="a_name"  value="{{$data->a_name}}" placeholder="管理员名称">
										</div>
									</div>

									<div class="form-group">
										<label for="inputPassword3" class="col-sm-2 control-label">密码</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" name="a_password"  value="" placeholder="Password">
										</div>
									</div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">联系方式</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="a_phone"   value="" placeholder="Phone">
                                        </div>
                                    </div>

									<div class="form-group">
										<label for="inputPassword3" class="col-sm-2 control-label">是否启用</label>

										<div class="col-sm-10">
											<input type="radio" @if($data->a_status==1)checked @endif name="a_status" value="1" >是
											<input type="radio" @if($data->a_status==0)checked @endif  name="a_status" value="0" >否
										</div>
									</div>
									<input type="hidden" name="a_id" value="{{$data->a_id}}">

									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-default">提交</button>
											<input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <script src="{{asset('jquery-1.8.2.min.js')}}"></script>
        <script>
            $(function(){
                $("input[name='role_id[]']").click(function () {
                    var role_name=[];
                    $("input[name='role_id[]']:checked").each(function () {
                        role_name.push($(this).attr('role_name'));
                        //alert(role_name);
                    });
                    $("input[name='role_name']").val(role_name.join(","));
                })
                $("input[name='a_name']").blur(function(){
                    var name=$(this).val();
                    if(name==""){
                        alert("姓名不能为空");
                    }
                })

                $("input[name='a_password']").blur(function(){
                    var password=$(this).val();
                    if(password==""){
                        alert("密码不能为空");
                    }
                })


            })
        </script>
@endsection
