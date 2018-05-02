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
        <li><a href="#" title="内定列表">内定列表</a>
        </li>
    </ul>
    <!-- END OF BREADCRUMB -->
    <!---- 面包屑导航end-->
    <!-- 内容start-->
    <div class="content-wrap">
        <div class="row">
            <div class="col-sm-12">
                <div class="nest" id="FootableClose">
                    <div class="body-nest" id="Footable1">
                        <table class="table-striped footable-res footable metro-blue footable-loaded default" data-page-size="6">
                            <!-- 头部开始--->
                            <thead>
                            <tr>
                                <th class="footable-sortable">
                                    微信昵称
                                <th class="footable-sortable">
                                    微信头像
                                <th class="footable-sortable">
                                    奖品名称
                                <th class="footable-sortable">
                                    奖品图片
                                <th  class="footable-sortable">
                                    操作
                            </tr>
                            </thead>
                            <!-- 头部结束--->
                            <!--主体开始--->
                            <tbody class="tsigin">
                            @if($arr)
                                @foreach($arr as $k=>$v)
                                    <tr default="{{$v['id']}}" id="{{$v['sign_prize_id']}}">
                                        <td>{{$v['signin_nickname']}}</td>
                                        <td><img src="{{$v['signin_headimgurl']}}" class="img-circle " style="width:60px;height:60px;"/></td>
                                        <td>{{$v['prize_name']}}</td>
                                        <td><img src="{{asset("sign_pc/".$v['prize_img'])}}" class="img-circle " style="width:60px;height:60px;"/></td>
                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <button class="sign_prize_default btn btn-warning" data-toggle="modal" data-target="#myModal">取消内定</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
        $(".sign_prize_default").click(function() {
            var defal = $(this).parents("tr").attr('default');
            var sign_prize_id = $(this).parents("tr").attr('id');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/prizeshow')}}",
                data:{
                    'defal':defal,
                    'sign_prize_id':sign_prize_id,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1){
                        $('tr[id='+msg.del+']').remove();
                    }else{
                        alert('删除失败');
                    }
                }
            })
        })
    </script>
@endsection