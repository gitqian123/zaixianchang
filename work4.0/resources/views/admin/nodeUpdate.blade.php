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
		<li><a href="#" >权限修改</a>
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
								修改权限</h6>
						</div>
						<div class="body-nest" id="validation">
							<div class="form_center">
								<form class="form-horizontal" action="" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="node_id" value="{{$id}}"/>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">权限名称</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="node_name" id="" placeholder="权限名称">
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-2 control-label">所属权限</label>
										<div class="col-sm-10">
											<select name="node_pid"  id="" class="form-control">
												<option value="0">顶级权限</option>
												@foreach($nodes as $val)
													<option value="{{$val->node_id}}">{{str_repeat("---",$val->level-1)}}{{$val->node_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">权限路由</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="node_route" id="" placeholder="权限路由">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">权限控制器</label>
										<div class="col-sm-10">
											<select name="node_controller"   class="form-control">

												@foreach($controllers as $val)
													<option value="{{$val}}">{{$val}}</option>
												@endforeach

											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">权限方法</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="node_action" id="" placeholder="权限方法">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">权限简介</label>
										<div class="col-sm-10">
											<textarea name="node_desc" cols="40" rows="10"></textarea>
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
@endsection
