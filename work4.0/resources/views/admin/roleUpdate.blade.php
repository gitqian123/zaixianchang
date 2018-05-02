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
		<li><a href="#" >角色修改</a>
		</li>
	</ul>
	<!-- END OF BREADCRUMB -->
	<!---- 面包屑导航end-->

				<!-- 内容start-->
		<div class="content-wrap">
			<div class="row">
				<div class="col-sm-12">
					<div class="nest" id="validationClose">
						<div class="title-alt">
							<h6>
								修改角色</h6>
						</div>
						<div class="body-nest" id="validation">
							<div class="form_center">
								<form class="form-horizontal" action="" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="id" value="{{$role_id}}" />
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">角色名称</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value={{$role->role_name}} name="role_name" id="" placeholder="角色名称">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">是否启用</label>
										<div class="col-sm-10">
											<input type="radio" @if($role->role_status==1) checked @endif  name="role_status" value="1" >启用
											<input type="radio" @if($role->role_status==0) checked @endif name="role_status"  value="0">禁用
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">拥有权限</label>
										<div class="col-sm-10">
											<table class="table table-bordered">
												@foreach($nodeTree as $key=>$val)
													<tr >
														<td ><input type="checkbox" class="parent" @if($val->checked==1) checked @endif name="node_id[]"  value="{{$val->node_id}}">{{$val->node_name}}</td>
														<td >
															@foreach($val->son as $k=>$v)
																<input  type="checkbox" class="son" @if($v->checked==1) checked @endif name="node_id[]"  value="{{$v->node_id}}">{{$v->node_name}}
															@endforeach
														</td>
													</tr>
												@endforeach
											</table>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">角色简介</label>
										<div class="col-sm-10">
											<textarea name="role_desc"  cols="40" rows="10">{{$role->role_desc}}</textarea>
										</div>
									</div>
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
			//父选子
			$('.parent').click(function () {
				$(this).parent().next().find('.son').prop("checked",$(this).prop("checked"));
			})
			//子选父
			$('.son').click(function () {
				if($(this).prop('checked')){
					$(this).parent().prev().find('.parent').prop("checked",true);
				}else {
					if($(this).siblings("input:checked").size()==0){
						$(this).parent().prev().find('.parent').prop("checked",false);

					}

				}
			})
		</script>
@endsection
