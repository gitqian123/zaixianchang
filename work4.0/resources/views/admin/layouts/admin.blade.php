<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>在现场互动</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/loader-style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/js/progress-bar/number-pb.css')}}">
    <link href="{{asset('admin/assets/js/footable/css/footable.core.css?v=2-0-1')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/assets/js/footable/css/footable.standalone.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/assets/js/footable/css/footable-demos.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/assets/js/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('admin/assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/js/dataTable/css/datatables.responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/newsList.css')}}">
    <style type="text/css">
        canvas#canvas4 {
            position: relative;
            top: 20px;
        }
    </style>
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="{{(asset('admin/assets/ico/minus.png'))}}">
</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- TOP NAVBAR -->
<!-- 导航栏-->
<nav role="navigation" class="navbar navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="entypo-menu"></span>
            </button>
            <button class="navbar-toggle toggle-menu-mobile toggle-left" type="button">
                <span class="entypo-list-add"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">

            <ul style="margin-right:0;" class="nav navbar-nav navbar-right">
                <li>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        Hi,{{session('admin')->a_name}} <b class="caret"></b>
                    </a>
                    <ul style="margin-top:14px;" role="menu" class="dropdown-setting dropdown-menu">
                        <li>
                            <a href="{{url('admin/adminlogout')}}">
                                <span class="entypo-user"></span>&#160;&#160;退出</a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <li>
                    <a target="_blank" href="{{url('sign_pc/')}}">
                        <span class="icon-gear"></span>&#160;&#160;现场大屏幕</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<!-- 导航栏end-->
<!-- /END OF TOP NAVBAR -->
<!--- 左侧菜单start-->
<!-- SIDE MENU -->
<div id="skin-select">
    <div id="logo">
        <h1><span style="font-size:18px;">在现场互动管理后台</span></h1>
    </div>
    <a id="toggle">
        <span class="entypo-menu"></span>
    </a>
    <div class="skin-part">
        <div id="tree-wrap">
            <div class="side-bar">
                <ul class="topnav menu-left-nest">
                    <li>
                        <a class="tooltip-tip2 ajax-load" href="{{url('admin/indexlists')}}" title="Blog List"><span>首页</span></a>
                    </li>
                </ul>
                @foreach($leftNav as $key=>$val)
                <ul class="topnav menu-left-nest">
                    <li>
                        <a class="tooltip-tip ajax-load" href="#" title="Blog App">
                            <i class="icon-document-edit"></i>
                            <span>{{$val->node_name}}</span>
                        </a>
                        @if(!$val->son=='')
                        <ul>
                            @foreach($val->son as $k=>$v)
                            <li>
                                <a class="tooltip-tip2 ajax-load" href="{{url($v->node_route)}}" title="Blog List"><i class="entypo-doc-text"></i><span>{{$v->node_name}}</span></a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                </ul>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- END OF SIDE MENU -->
<!--- 左侧菜单end-->

<!---内容start-->
<!--  PAPER WRAP -->
<div class="wrap-fluid">
    <div class="container-fluid paper-wrap bevel tlbr">
        <!---- 面包屑导航start-->
        @yield('content')
                <!---- 底部开始-->
        <!-- FOOTER -->
        <div class="footer-space"></div>
        <div id="footer">
            <div class="devider-footer-left"></div>
            <div class="time">
                <p id="spanDate">
                <p id="clock">
            </div>
            <div class="copyright">Make with Love
                <span class="entypo-heart"></span>Collect from <a href="" title="上海倍数科技有限公司" target="_blank">上海倍数科技有限公司</a> All Rights Reserved</div>
            <div class="devider-footer"></div>
        </div>
    </div>
    <!-- / END OF FOOTER -->
    <!-- 底部结束--->
</div>
<!--  END OF PAPER WRAP -->
<!-- RIGHT SLIDER CONTENT -->
<!-- END OF RIGHT SLIDER CONTENT-->
<script type="text/javascript" src="{{asset('admin/assets/js/jquery.js')}}"></script>
<script src="{{asset('admin/assets/js/progress-bar/number-pb.js')}}"></script>
<!-- MAIN EFFECT -->
<script type="text/javascript" src="{{asset('admin/assets/js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/assets/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/assets/js/load.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/assets/js/main.js')}}"></script>

<!-- GAGE -->
<div style="text-align:center;">
    <p>More Templates <a href="" target="_blank" title="上海倍数科技有限公司">上海倍数科技有限公司</a> - Collect from <a href="" title="上海倍数科技有限公司" target="_blank">上海倍数科技有限公司</a></p>
</div>
</body>

</html>
