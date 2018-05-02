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
        <li><a href="" title="奖品设置">奖品设置</a>
        </li>
        <li class="pull-right" style="margin-right: 100px;" >
            <!-- 按钮触发模态框 -->
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                添加奖品
            </button>
        </li>
    </ul>
    <!-- END OF BREADCRUMB -->

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content setupDraw">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        奖品信息
                    </h4>
                </div>
                <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="model-inputs">
                                <span >奖品名称：</span>
                                <input  type="text" name="prizeimgname"/><br/>
                            </div>
                            <div style="line-height:2em ;font-size:14px;margin-top: 20px;" class="clearfix">
                                <span style="float:left;padding-right: 4px;">奖品图片：</span>  <input style="float: left" type="file" name="prizeimg" multiple accept="image/*" onchange="imagePreview(this)">
                            </div>
                            <div class="model-inputs">
                                <span>抽奖人群：</span>
                                <select name="prizeselect" style="width: 200px;height: 2em;">
                                    <option value="全部用户">全部用户</option>
                                </select>
                            </div>
                            <div class="seeimg" style="text-align: center;margin-top: 30px;max-height: 300px;overflow: auto"></div>
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
                        奖品信息
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/prizeupdates')}}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" name="upid" value=""/>
                        <div class="model-inputs">
                            <span>奖品名称：</span>
                            <input type="text" name="prizeimgnames" value="" style="color:#272822;"/><br/>
                        </div>
                        <div style="line-height:2em ;font-size:14px;margin-top: 20px;" class="clearfix">
                            <span style="float:left;padding-right: 4px;">奖品图片：</span>
                            <input style="float: left" type="file" name="prizeimgs" multiple accept="image/*" onchange="imagePreview(this)">
                        </div>
                        <div class="model-inputs">
                            <span>抽奖人群：</span>
                            <select name="prizeselects" style="width: 200px;height: 2em;">
                                <option value="全部用户">全部用户</option>
                                {{--<option value="内定用户">内定用户</option>--}}
                            </select>
                        </div>
                        <div class="seeimg" style="text-align: center;margin-top: 30px;max-height: 300px;overflow: auto"></div>
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
                                    编号
                                <th class="footable-sortable">
                                    奖品名称
                                <th class="footable-sortable">
                                    奖品图片
                                <th class="footable-sortable">
                                   状态
                                <th class="footable-sortable">
                                    创建时间
                                <th  class="footable-sortable">
                                    操作

                            </tr>
                            </thead>
                            <!-- 头部结束--->
                            <!--主体开始--->
                            <tbody>
                            @if($prizeall)
                            @foreach($prizeall as $k=>$v)
                                <tr prizedel="{{$v->id}}">
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->prize_name}}</td>
                                    <td>
                                        <div class="col-sm-6 col-md-3">
                                            <a href="#" class="thumbnail" id="tong">
                                               <img src="{{asset("sign_pc/".$v->prize_img)}}" class="img-circle " style="width:100px;height:60px;"/>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="switch-che">
                                            <div class="switch-item" @if($v->prize_status==1) index="1" @else index="0" @endif>
                                                <span class="switch-on">ON</span>
                                                <span class="switch-null"></span>
                                                <span class="switch-off">OFF</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="am-hide-sm-only">{{date('Y-m-d',$v->prize_time)}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button data-target="#mModal" data-toggle="modal" class="btn btn-warning prizeupdate">修改</button>
                                                <button class="btn btn-danger prizedel">删除</button>
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
    <script src="{{asset('layer/layer.js')}}"></script>
    <script>
        /**
         *图片上传预览
         */
        function imagePreview(input){
            var files = input.files;
            // 假设 "preview" 是将要展示图片的 div
            var preview = $(input).parent().siblings(".seeimg")[0]
            for (var i = 0; i < files.length; i--) {//预览新添加的图片
                var file = files[i];
                var imageType = /^image\//;
                if ( !imageType.test(file.type) ) {
                    alert("请选择图片类型上传");
                    continue;
                }
                preview.innerHTML="";
                var img = document.createElement("img");
                img.classList.add("obj");
                img.file = file;
                img.style.width = "300px";
                preview.appendChild(img);
                var reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }
        $('.prizedel').click(function(){
            var prizedel= $(this).parents('tr').attr('prizedel');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/prizedel')}}",
                data:{
                    'prizedel':prizedel,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    if(msg.status==1){
                        $('tr[prizedel='+prizedel+']').remove();
                    }else{
                        alert('删除失败');
                    }
                }
            })
        })

        $('.prizeupdate').click(function(){
            var prizeupdate= $(this).parents('tr').attr('prizedel');
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/prizeupdate')}}",
                data:{
                    'prizeupdate':prizeupdate,
                    '_token':token
                },
                type:"POST",
                dataType:"JSON",
                success:function(msg){
                    //alert(msg.id);
                    $('input[name="prizeimgnames"]').val(msg.prize_name);
                    $('input[name="upid"]').val(msg.id);
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
                var prizedel_id=$(this).parents('tr').attr('prizedel');
                var prizestatus=parseInt(0);
            }
            else{//开状态
                $(this).children('.switch-item').css('left','0px');
                var prizedel_id=$(this).parents('tr').attr('prizedel');
                var prizestatus=parseInt(1);
            }
            //alert(displaymode);
            var token="{{csrf_token()}}";
            $.ajax({
                url:"{{url('admin/prizestatus')}}",
                data:{
                    'prizestatus':prizestatus,
                    'prizedel_id':prizedel_id,
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