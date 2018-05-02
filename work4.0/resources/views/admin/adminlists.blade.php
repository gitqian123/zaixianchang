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
		<li><a href="{{url('admin/adminlists')}}" title="管理员展示">管理员展示</a>
		</li>
		<li class="pull-right" >
			<div class="input-group input-widget">
				<a href="{{url('admin/adminadd')}}"><span class="status-metro status-active" >添加管理员</span></a>
			</div>
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
							<tr>
								<th class="footable-sortable">
									管理员id
								<th class="footable-sortable">
									管理员名称
								<th class="footable-sortable">
									管理员状态
								<th  class="footable-sortable">
									修改时间
								<th class="footable-sortable">
									角色名称
								<th class="footable-sortable">
									拥有权限
								<th class="footable-sortable">
									联系方式
								<th  class="footable-sortable">
									操作

							</tr>
							</thead>
							<!-- 头部结束--->
							<!--主体开始--->
							<tbody>
							@foreach($admin as $k=>$v)
							<tr adminlists="{{$v->a_id}}">
								<td>{{$v->a_id}}</td>
								<td><a>{{$v->a_name}}</a></td>

								<td><a>@if($v->a_status==1)开启
										@else  关闭
										@endif
									</a>
								</td>
								<td class="am-hide-sm-only">{{date('Y-m-d',$v->a_time)}}</td>
								<td><a>{{$v->role_name}}</a></td>
								<td><a>{{$v->node}}</a></td>
								<td><a>{{$v->a_phone}}</a></td>
								<td>
									<div class="am-btn-toolbar">
										<div class="am-btn-group am-btn-group-xs">
											<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><a href="{{url('admin/adminupdate?id='.base64_encode($v->a_id))}}"><span class="am-icon-pencil-square-o"></span> 修改</a></button>
											<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><a href="{{url('admin/adminsetnode?id='.base64_encode($v->a_id))}}"><span class="am-icon-copy"></span> 重新附权</a></button>
											<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><a href="javascript:void(0)"  class="delt"><span class="am-icon-trash-o"></span>删除</a></button>

										</div>
									</div>
								</td>
							</tr>
							@endforeach
							</tbody>
							<!-- 主体结束--->
							<!-- 尾部开始--->
							<tfoot>
							<tr>
								<td colspan="5">
									<div class="pagination pagination-centered">
										<ul>
											<li class="footable-page-arrow disabled">
												<a data-page="first" href="#first">«</a>
											</li>
											<li class="footable-page-arrow disabled">
												<a data-page="prev" href="#prev">‹</a>
											</li>
											<li class="footable-page active">
												<a data-page="0" href="#">1</a>
											</li><li class="footable-page">
												<a data-page="1" href="#">2</a>
											</li>
											<li class="footable-page-arrow">
												<a data-page="next" href="#next">›</a>
											</li>
											<li class="footable-page-arrow">
												<a data-page="last" href="#last">»</a>
											</li>
										</ul></div>
								</td>
							</tr>
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
		$('.delt').click(function(){
			var admin_id= $(this).parents('tr').attr('adminlists');
			var token="{{csrf_token()}}";
			$.ajax({
				url:"{{url('admin/admindelete')}}",
				data:{
					'admin_id':admin_id,
					'_token':token
				},
				type:"POST",
				dataType:"JSON",
				success:function(msg){
					if(msg==1){
						alert('删除成功');
						$('tr[adminlists='+admin_id+']').remove();
					}else{
						alert('删除失败');
					}
				}
			})
		})
	</script>
@endsection