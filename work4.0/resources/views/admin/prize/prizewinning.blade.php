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
        <li><a href="" title="中奖信息">中奖信息</a>
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
                                    奖品名称
                                <th class="footable-sortable">
                                    奖品图片
                                <th class="footable-sortable">
                                    昵称
                                <th class="footable-sortable">
                                    头像
                                <th class="footable-sortable">
                                    状态
                                <th class="footable-sortable">
                                    中奖时间
                                <th  class="footable-sortable">
                                    操作

                            </tr>
                            </thead>
                            <!-- 头部结束--->
                            <!--主体开始--->
                            <tbody>
                            @if($winningall)
                                @foreach($winningall as $k=>$v)
                                    <tr winningdel="{{$v->id}}">
                                        <td>{{$v->winning_name}}</td>
                                        <td>
                                            <div class="col-sm-6 col-md-3">
                                                <a href="#" class="thumbnail" id="tong">
                                                    <img src="{{asset("sign_pc/".$v->winning_img)}}" class="img-circle " style="width:100px;height:50px;"/>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{$v->winning_user}}</td>
                                        <td>
                                            <div class="col-sm-6 col-md-3">
                                                <a href="#" class="thumbnail" id="tong">
                                                    <img src="{{asset($v->winning_userimg)}}" class="img-circle " style="width:100px;height:50px;"/>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <a>@if($v->winning_status==1)已抽奖
                                                @else  未抽奖
                                                @endif
                                            </a>
                                        </td>
                                        <td class="am-hide-sm-only">{{date('Y-m-d',$v->winning_time)}}</td>
                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <button class="btn btn-danger winningdel">删除</button>
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
                            <tr>
                                <td colspan="5">
                                    <div class="pagination pagination-centered">
                                        <ul>
                                            <li class="footable-page-arrow disabled">

                                            </li>
                                        </ul>
                                    </div>
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
        $('.winningdel').click(function(){
            var winningdel= $(this).parents('tr').attr('winningdel');
            //alert(winningdel);
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/prizewinning')}}",
                data:{
                    'winningdel':winningdel,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1){
                        $('tr[winningdel='+winningdel+']').remove();
                    }else{
                        alert('删除失败');
                    }
                }
            })
        })

    </script>
@endsection