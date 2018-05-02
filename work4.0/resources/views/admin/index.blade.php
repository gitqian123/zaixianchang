<!-- BREADCRUMB -->
@extends("admin/layouts/admin")
@section('content')
    <link rel="stylesheet" href="{{asset('admin/assets/js/upload/demos/css/uploader.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/js/upload/demos/css/demo.css')}}">
    <ul id="breadcrumb">
        <li>
            <span class="entypo-home"></span>
        </li>
        <li><i class="fa fa-lg fa-angle-right"></i>
        </li>
        <li><a href="#" title="Sample page 1">首页</a>
        </li>
        {{--<li><i class="fa fa-lg fa-angle-right"></i>--}}
        {{--</li>--}}
        {{--<li><a href="#" title="Sample page 1"></a>--}}
        {{--</li>--}}
    </ul>
    <!-- END OF BREADCRUMB -->

    <!---- 面包屑导航end-->
    <!-- 内容start-->
    <div class="content-wrap">
        <div class="row">
            <div class="body-nest" id="header">
                <div class="row demo-columns">
                    <form action="{{url("admin/indexfile")}}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-6">
                            <!-- D&D Zone-->
                            <div id="drag-and-drop-zone" class="uploader">
                                <div>上传背景图片</div>
                                <div class="or"></div>
                                <div class="browser">
                                    <label>
                                        <span>点击上传图片</span>
                                        <input style="float: left" id="file"  type="file" name="file" multiple accept="image/*" onchange="imagePreview(this)">
                                    </label>
                                </div>
                            </div>
                            <div class="model-btns">
                                <input type="submit" value="提交" class="btn btn-primary" />
                            </div>
                            <!-- /D&D Zone -->
                        </div>

                        <!-- / Left column -->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Uploads</h5>
                                </div>
                                <div class="panel-body demo-panel-files" id="demo-files">
                                    <div class="see" style="text-align: center;margin-top: 30px;max-height: 300px;overflow: auto"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- / Right column -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="weather-wrap">
                    <div class="row">
                        <div class="col-lg-4">
                            <div>
                                <span style="color: #91633c;font-size: large">扫描二维码签到哦</span>
                            </div>
                            <div style="width: 50%">
                                <img  src="http://qr.liantu.com/api.php?bg=ffffff&fg=000000&gc=222222&el=l&w=260&m=10&text=http://{{$Ip}}/mobile/index?vcode={{$name}}"/>
                            </div>
                            <div >
                                <span style="font-size: 18px">签到地址：{{$Ip}}/mobile/index?vcode={{$name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /END OF CONTENT -->
    <!--- 内容end-->
    <script src="{{asset('jquery-1.8.2.min.js')}}"></script>
    <script>
        /**
         *图片上传预览
         */
        function imagePreview(input){
            var files = input.files;
            // 假设 "preview" 是将要展示图片的 div
            var preview = $(".see")[0]
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

    </script>
@endsection