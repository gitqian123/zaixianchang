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
        <li><a href="#" title="设置内定">设置内定</a>
        </li>
    </ul>
    <!-- END OF BREADCRUMB -->
    <!---- 面包屑导航end-->

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        设置内定
                    </h4>
                </div>
                <div class="modal-body" >
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        <div class="addoption-main">
                            <input type="hidden" name="sign_id" value=""/><br/>
                            奖品
                            <select style="width:20rem;height:30px;padding-top: 0px;margin-bottom: 180px" name="prize_id" >
                                @if($prize)
                                @foreach($prize as $key=>$val)
                                    <option value ="{{$val->id}}">{{$val->prize_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="model-btns">
                            <input type="submit" value="提交" class="btn btn-primary" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭  </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

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
                                    签到时间
                                <th  class="footable-sortable">
                                    操作
                            </tr>
                            </thead>
                            <!-- 头部结束--->
                            <!--主体开始--->
                            <tbody class="tsigin">
                            @if($users)
                                @foreach($users as $k=>$v)
                                    <tr defal="{{$v->id}}" >
                                        <td>{{$v->signin_nickname}}</td>
                                        <td><img src="{{$v->signin_headimgurl}}" class="img-circle " style="width:60px;height:60px;"/></td>
                                        <td>{{date('Y-m-d H:i:s',$v->signin_time)}}</td>
                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <button class="sign_default btn btn-info" data-toggle="modal" data-target="#myModal">内定</button>
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
                                        @if($users) {!! $users->render() !!}@endif
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
        $(".sign_default").click(function() {
            var defal = $(this).parents("tr").attr('defal');
            $("input[name='sign_id']").val(defal);
        })
    </script>
@endsection