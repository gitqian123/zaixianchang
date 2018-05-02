<!-- BREADCRUMB -->
@extends("admin/layouts/admin")
@section('content')
	<ul id="breadcrumb">
		<li>
			<span class="entypo-home"></span>
		</li>
		<li><i class="fa fa-lg fa-angle-right"></i>
		</li>
		<li><a href="{{url('admin/indexlists')}}" title="首页">首页</a>
		</li>
		<li><i class="fa fa-lg fa-angle-right"></i>
		</li>
		<li><a href="{{url('admin/roleLists')}}" title="角色展示">角色展示</a>
		</li>

	</ul>
	<!-- END OF BREADCRUMB -->

	<!---- 面包屑导航end-->

	<!-- 内容start-->
	<div class="content-wrap">
		<div class="row">
			<div class="col-sm-12">
				<div class="nest" id="FootableClose">
					<div class="body-nest" id="Footable">
						<table class="table-striped footable-res footable metro-blue footable-loaded default" data-page-size="6">
							<!-- 头部开始--->
							<thead>
							<tr node_pid="0">
								<th class="table-id">角色ID
								<th class="table-title">角色名称
								<th class="table-title">角色状态
								<th class="table-title">拥有权限
								<th class="table-title">角色简介
								<th class="table-set">操作
							</tr>
							</thead>
							<!-- 头部结束--->
							<!--主体开始--->
							<tbody>
							@foreach($roles as $k=>$v)
							<tr>
								<td>{{$v->role_id}}</td>
								<td><a href="#">{{$v->role_name}}</a></td>
								<td><a href="#">@if($v->role_status==1)开启
										@else  关闭
										@endif
									</a>
								</td>
								<td><a href="#">{{$v->node}}</a></td>
								<td><a href="#">{{$v->role_desc}}</a></td>

								<td>
									<div class="am-btn-toolbar">
										<div class="am-btn-group am-btn-group-xs">
											<button class="am-btn-xs am-text-secondary"><a href="{{url('admin/roleUpdate?id='.base64_encode($v->role_id))}}"><span class="am-icon-pencil-square-o"></span> 修改</a></button>
											<button class="am-btn-xs am-text-danger am-hide-sm-only"><a href="{{url('admin/roleDelete?id='.base64_encode($v->role_id))}}"><span class="am-icon-trash-o"></span>删除</a></button>
										</div>
									</div>
								</td>
							</tr>
							@endforeach
							</tbody>
							<!-- 主体结束--->
							<!-- 尾部开始--->
							<tfoot>
							</tfoot>
							<!-- 尾部结束--->
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- /END OF CONTENT -->
	<!--- 内容end-->

@endsection