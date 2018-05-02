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
		<li><a href="{{url('admin/nodeLists')}}" title="权限展示">权限展示</a>
		</li>

	</ul>
	<!-- END OF BREADCRUMB -->
	@if(session()->has('delnode'))
		<script>alert("{{session()->get('delnode')}}")</script>
		@endif
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
								<th class="table-id">权限ID
								<th class="table-title">权限名称
								<th class="table-title">控制器
								<th class="table-title">方法
								<th class="table-title">权限路由
								<th class="table-set">操作
							</tr>
							</thead>
							<!-- 头部结束--->
							<!--主体开始--->
							<tbody>
							@foreach($nodes as $k=>$v)
								<tr node_id="{{$v->node_id}}" node_pid="{{$v->node_pid}}">
									<td class="tc">
										<span style="border:1px solid #ccc;padding: 5px"  >+</span>{{$v->node_id}}
									</td>
									<td><a href="#">{{str_repeat("===",$v->level-1)}}{{$v->node_name}}</a></td>
									<td><a href="#">{{$v->node_controller}}</a></td>
									<td><a href="#">{{$v->node_action}}</a></td>
									<td><a href="#">{{$v->node_route}}</a></td>
									<td>
										<div class="am-btn-toolbar">
											<div class="am-btn-group am-btn-group-xs">
												<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><a href="{{url('admin/nodeUpdate?id='.base64_encode($v->node_id))}}"><span class="am-icon-pencil-square-o"></span> 修改</a></button>
												<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><a href="{{url('admin/nodeDelete?id='.base64_encode($v->node_id))}}"><span class="am-icon-trash-o"></span>删除</a></button>

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
	<script src="{{asset('jquery-1.8.2.min.js')}}"></script>
	<script>
		$('tr[node_pid!=0]').hide();
		$(".tc").find("span").toggle(function () {
			var node_id=$(this).parent().parent().attr("node_id");
			$("tr[node_pid='"+node_id+"']").show();
		},function () {
			var node_id=$(this).parent().parent().attr("node_id");
			$("tr[node_pid='"+node_id+"']").hide();
		});

	</script>
@endsection