@extends('Admin.layouts/admin')
@section('content')

<!-- col start -->
<div class="am-u-md-12">
    <div class="card-box">
        <h4 class="header-title m-t-0 m-b-30">最新项目</h4>
        <div class="am-scrollable-horizontal am-text-ms" style="font-family: '微软雅黑';">
            <table class="am-table   am-text-nowrap">
                <thead>
                <tr>
                    <th>  <a href="{{url('Admin/configadd')}}">增加</a></th>
                    <th>设置名字</th>
                    <th></th>
                    <th>设置状态</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                @foreach($res as $v)
                <tbody>
                <tr>
                    <td>{{$v->conf_id}}</td>
                    <td>{{$v->conf_name}}</td>
                    {{--<td>{{$v->conf_desc}}</td>--}}
                    <td>  <td>{{$v->conf_values==0?'关闭中':'启用中'}}</td></td>
                    <td>{{date("Y-m-d H:i",$v->conf_time)}}</td>
                    <td>
                        <a href="confup/{{$v->conf_id}}">更改</a>
                        <a href="configdel/{{$v->conf_id}}">删除</a>
                    </td>
                </tr>
                </tbody>
                    @endforeach
            </table>
        </div>
    </div>
</div>
<!-- col end -->
    @stop