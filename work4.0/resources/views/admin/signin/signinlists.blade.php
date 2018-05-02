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
        <li><a href="{{url('admin/signinlists')}}" title="签到展示">签到展示</a>
        </li>
    </ul>
    <!-- END OF BREADCRUMB -->
    <!---- 面包屑导航end-->
    <!-- 内容start-->
    <div class="content-wrap">
        <div style="margin-top: 10px"  >
            <span style="font-size: 18px;line-height: 30px">自动审核：</span>
                <div id="switch-che">
                    <div id="switch-item" @if($audit) index="1" @else index="0" @endif>
                        <span class="switch-on">ON</span>
                        <span class="switch-null"></span>
                        <span class="switch-off">OFF</span>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="navbars">
                    <span class="navactive" id="navbar1">已审核</span>
                    <span id="navbar2">已拒绝</span>
                </div>
                <div class="nest" id="FootableClose">
                    <div class="body-nest" id="Footable1">
                        <table class="table-striped footable-res footable metro-blue footable-loaded default" data-page-size="6">
                            <!-- 头部开始--->
                            <thead>
                            <tr>
                                <th class="footable-sortable">
                                    <input   type="checkbox"  class="allss"/>
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
                                <tr adminlists="{{$v->id}}" >
                                    <td><input type="checkbox" class="siginCheckbox" value="{{$v->id}}" name="signins[]"></td>
                                    <td>{{$v->signin_nickname}}</td>
                                    <td><img src="{{$v->signin_headimgurl}}" class="img-circle " style="width:60px;height:60px;"/></td>
                                    <td>{{date('Y-m-d H:i:s',$v->signin_time)}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button class="signinf">@if($v->signin_status==1)拒绝@else 通过@endif</button>
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
                                <td><button class="status-metro status-active signin_s">批量拒绝</button></td>
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
                    <div class="body-nest" id="Footable2">
                        <table class="table-striped footable-res footable metro-blue footable-loaded default" data-page-size="6">
                            <!-- 头部开始--->
                            <thead>
                            <tr>
                                <th class="footable-sortable">
                                    <input   type="checkbox"  class="allts"/>
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
                            <tbody class="tsignins">
                            </tbody>
                            <!-- 主体结束--->
                            <!-- 尾部开始--->
                            <tfoot>
                            <tr>
                                <td ><button class="status-metro status-active signin_t">批量通过</button></td>
                                <td colspan="4">
                                    <div class="page" pagenow="1" pagesum="">
                                        <a href="javascript:void(0)" class="first">首页</a>
                                        <a href="javascript:void(0)" class="prev">上一页</a>
                                        <a href="javascript:void(0)" class="next">下一页</a>
                                        <a href="javascript:void(0)" class="last">尾页</a>
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
        if($("#switch-item").attr("index")==0){
            $("#switch-item").css('left','-50px');
        }
        $("#navbar1").on('click',function(){
            $(this).addClass("navactive").siblings().removeClass("navactive");
            $("#Footable1").show().siblings().hide();
            location.href=location.href;
        });
        $("#navbar2").on('click',function(){
            $(this).addClass("navactive").siblings().removeClass("navactive");
            $("#Footable2").show().siblings().hide();
        })
            //自动审核
        $("#switch-che").on('click',function(){
            //console.log($("#switch-item").css('left'))
            if($("#switch-item").css('left')=='0px'){//关状态
                $("#switch-item").css('left','-50px')
                var displaymode=0;
            }
            else{//开状态
                $("#switch-item").css('left','0px')
                var displaymode=1;
            }
            //alert(displaymode);
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/signinmode')}}",
                data:{
                    'displaymode':displaymode,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                }
            })
        })
            //单选 拒绝
        $(".signinf").click(function(){
            var signinfal=$(this).parents("tr").attr('adminlists');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/signinfalses')}}",
                data:{
                    'signinfal':signinfal,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1){
                        $('tr[adminlists='+signinfal+']').remove();
                    }else{
                        alert("拒绝失败");
                    }
                }
            })
        })
            //拒绝全选
        $(".allss").click(function(){
            var dj = $(this).is(":checked");
            $(".siginCheckbox").prop("checked",dj);
        })
        //tonguo quanxuan
        $(document).on("click",".allts",function(){
            var tr = $(this).is(":checked");
            $(".siginCheckbox2").prop("checked",tr);
        })
            //选中  批量拒绝
        $(".signin_s").click(function() {
            var cObject = $(".siginCheckbox");
            var arr = Array();
            for (var i = 0; i < cObject.length; i++) {
                if (cObject.eq(i).is(":checked") == true) {
                    arr.push(cObject.eq(i).val());
                }
            }
            var token="{{csrf_token()}}";
            if(arr!=""){
                $.ajax({
                    url:"{{url('admin/signinfalses')}}",
                    data:{
                        'signinfal':arr,
                        '_token':token
                    },
                    type:"POST",
                    dataType:"JSON",
                    success:function(msg){
                       if(msg.status==1){
                            $.each(msg.content,function(k,v){
                                $('tr[adminlists='+v+']').remove();
                            })
                       }
                    }
                })
            }
        })
        //批量通过
        $(document).on("click",".signin_t",function(){
            var cObject = $(".siginCheckbox2");
            var arr = Array();
            for (var i = 0; i < cObject.length; i++) {
                if (cObject.eq(i).is(":checked") == true) {
                    arr.push(cObject.eq(i).val());
                }
            }
            var token="{{csrf_token()}}";
            if(arr!=""){
                $.ajax({
                    url:"{{url('admin/signintrues')}}",
                    data:{
                        'signint':arr,
                        '_token':token
                    },
                    type:"POST",
                    dataType:"JSON",
                    success:function(msg){
                        $.each(msg.content,function(k,v){
                            $('tr[signinlists='+v+']').remove();
                        })
                    }
                })
            }
        })
        //已拒绝按钮
        $("#navbar2").click(function(){
            var token="{{csrf_token()}}";
            var signintrue=1;
            $.ajax({
                url:"{{url('admin/signintrue')}}",
                data:{
                    'signintrue':signintrue,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(data){
                    if(data.status==1){
                        $(".tsignins").html(data.date);
                        $(".page").attr('pagesum',data.pagesum);

                    }
                }
            })
        })
        $(".page a").click(function(){
            //当前页
            var pagenow=parseInt($(".page").attr("pagenow"));
            //总页数
            var pagesum=parseInt($(".page").attr("pagesum"));
            //判断点击的是哪个元素
            if($(this).is(".first")){
                var p=1;
            }
            if($(this).is(".prev")){
                var p=pagenow-1;
            }
            if($(this).is(".next")){
                var p=pagenow+1;
            }
            if($(this).is(".last")){
                var p=pagesum;
            }
            if((pagenow==1&&p==0)||(pagenow==pagesum&&p==pagesum+1))return
            false;
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/signintrue')}}",
                data:{
                    '_token':token,
                    'p':p
                },
                type:"post",
                dataType:"json",
                success:function(data){
                    if(data.status==1){
                        $(".tsignins").html(data.date);
                        $(".page").attr("pagenow",p).attr("pagesum",data.pagesum);
                    }
                }
            })
        })
        //单选 通过
        $(document).on("click",".signint",function(){
            var signint=$(this).parents("tr").attr('signinlists');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/signintrues')}}",
                data:{
                    'signint':signint,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1){
                        $('tr[signinlists='+signint+']').remove();
                    }else{
                        alert("通过失败");
                    }
                }
            })
        })

   </script>
@endsection