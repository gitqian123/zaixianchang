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
        <li><a href="" title="投票列表">投票列表</a>
        </li>
        <li class="pull-right" style="margin-right: 100px;" >
            <!-- 按钮触发模态框 -->
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                添加投票
            </button>
        </li>
    </ul>
    <!-- END OF BREADCRUMB -->

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        投票信息
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        <div class="model-inputs">
                            <span>投票名称：</span>
                            <input type="text" name="vote_title" value="" style="color:#272822;"/><br/>
                        </div>
                        <div class="addoption-main">
                            <span id="addoption-btn">添加选项+</span>
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


    <div class="modal fade" id="mModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        投票信息
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/vote_update_all')}}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="vote_id" value="" />
                        <div class="model-inputs">
                            <span>投票名称：</span>
                            <input type="text" name="vote_title_update" value="" style="color:#272822;"/><br/>
                        </div>
                        <div class="addoption-main">
                            <span id="addoption-btns">添加选项+</span>
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
                                    投票主题
                                <th class="footable-sortable">
                                    状态（开启/关闭）
                                <th class="footable-sortable">
                                    显示
                                <th class="footable-sortable">
                                    创建时间
                                <th  class="footable-sortable">
                                    操作

                            </tr>
                            </thead>
                            <!-- 头部结束--->
                            <!--主体开始--->
                            <tbody>
                            @if($VoteAll)
                                @foreach($VoteAll as $k=>$v)
                                    <tr votedel="{{$v->id}}">
                                        <td>{{$v->vote_title}}</td>
                                        <td>
                                            <div class="switch-che">
                                                <div class="switch-item" @if($v->vote_status==1) index="1" @else index="0" @endif>
                                                    <span class="switch-on">ON</span>
                                                    <span class="switch-null"></span>
                                                    <span class="switch-off">OFF</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="switch-ches">
                                                <div class="switch-items" @if($v->vote_show==1) indexs="1" @else indexs="0" @endif>
                                                    <span class="switch-ons">ON</span>
                                                    <span class="switch-nulls"></span>
                                                    <span class="switch-offs">OFF</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="am-hide-sm-only">{{date('Y-m-d',$v->vote_time)}}</td>
                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <button data-target="#mModal" data-toggle="modal" class="btn btn-warning voteupdate">修改</button>
                                                    <button class="btn btn-danger votedel">删除</button>

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
        $('.votedel').click(function(){
            var votedel= $(this).parents('tr').attr('votedel');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/votedel')}}",
                data:{
                    'votedel':votedel,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1){
                        $('tr[votedel='+votedel+']').remove();
                    }else{
                        alert('删除失败');
                    }
                }
            })
        })

        $('.voteupdate').click(function(){
            var voteupdate= $(this).parents('tr').attr('votedel');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/voteupdate')}}",
                data:{
                    'voteupdate':voteupdate,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1)
                    {
                        $("#addoption-btns").siblings("div").remove();
                        var trhtml="";
                        $.each(msg.content,function(k,v){
                            trhtml="<div><input name='vote_name_Update[]' value="+ v+"><i class='deloptions'>删除<i></div>";
                            $("#addoption-btns").before(trhtml);
                        });
                        $(".deloptions").on('click',function() {
                            $(this).parent().remove();
                        })
                        $("input[name='vote_title_update']").val(msg.title);
                        $("input[name='vote_id']").val(msg.id);
                    }
                }
            })
        })
        $(".switch-item").each(function(){
            if($(this).attr("index")==0){
                $(this).css('left','-50px');
            }
        })
        //自动审核
        $(".switch-che").on('click',function(){
            //console.log($("#switch-item").css('left'))
            if($(this).children('.switch-item').css('left')=='0px'){//关状态
                $(this).children('.switch-item').css('left','-50px')
                var voteupdate=$(this).parents('tr').attr('votedel');
                var votestatus=parseInt(0);
            }
            else{//开状态
                $(this).children('.switch-item').css('left','0px');
                var voteupdate=$(this).parents('tr').attr('votedel');
                var votestatus=parseInt(1);
            }
            //alert(displaymode);
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/votestatus')}}",
                data:{
                    'votestatus':votestatus,
                    'voteupdate':voteupdate,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                }
            })
        })
        var voteName=[];
        $("#addoption-btn").on('click',function(){
            $(this).hide().before("<div><input name='vote_name[]'><i class='deloption'>删除<i></div>");
            $(".deloption").on('click',function() {
                $(this).parent().remove();
            })
            $(this).parent().find("input").last().on('blur',function(){
                if($(this).val()){
                    $(this).parent().siblings("#addoption-btn").show();
                }
            })
        })

        var voteNameUpdate=[];
        $("#addoption-btns").on('click',function(){
            $(this).hide().before("<div><input name='vote_name_Update[]'><i class='deloptions'>删除<i></div>");
            $(".deloptions").on('click',function() {
                $(this).parent().remove();
            })
            $(this).parent().find("input").last().on('blur',function(){
                if($(this).val()){
                    $(this).parent().siblings("#addoption-btns").show();
                }
            })
        })
        //显示
        $(".switch-items").each(function(){
            if($(this).attr("indexs")==0){
                $(this).css('left','-50px');
            }
        })
        //自动显示
        $(".switch-ches").on('click',function(){
            //console.log($("#switch-item").css('left'))
            if($(this).children('.switch-items').css('left')=='0px'){//关状态
                $(this).children('.switch-items').css('left','-50px')
                var show_id=$(this).parents('tr').attr('votedel');
                var vote_show=parseInt(0);
            }
            else{//开状态
                $(this).children('.switch-items').css('left','0px');
                var show_id=$(this).parents('tr').attr('votedel');
                var vote_show=parseInt(1);
            }
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/vote_show')}}",
                data:{
                    'vote_show':vote_show,
                    'show_id':show_id,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                }
            })
        })
    </script>
@endsection