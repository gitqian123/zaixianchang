<!-- BREADCRUMB -->
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
								重新赋权</h6>
						</div>
						<div class="body-nest" id="validation">
							<div class="form_center">
								<form class="form-horizontal" action="{{url('admin/adminsetnode')}}" method="post">
									{!! csrf_field() !!}
                                    <input type="hidden" name="ids" value="{{base64_encode($a_id)}}"/>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">管理员名称</label>
										<div class="col-sm-10">
											<input type="text"  class="form-control" name="a_name" value="{{$a_name}}" id="inputEmail3" disabled placeholder="管理员名称">
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-2 control-label">分配角色</label>
										<div class="col-sm-10">
											@foreach($role as $key=>$val)
												<input type="checkbox"  role_name="{{$val->role_name}}"   name="role_id[]" value="{{$val->role_id}}" @if($val->checked==1)checked @endif />{{$val->role_name}}
											@endforeach
										</div>
									</div>
									<input type="text" name="role_name" value="">
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
            $("input[name='role_id[]']").click(function () {

                var role_name=[];
                $("input[name='role_id[]']:checked").each(function () {
                    role_name.push($(this).attr('role_name'));
                });
				//alert(role_name);
                $("input[name='role_name']").val(role_name.join(","));
            })
        </script>
@endsection
