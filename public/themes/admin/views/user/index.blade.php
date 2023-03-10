<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans("user.name") }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="tabel-message">
                <div class="layui-inline tabel-btn">
                    <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
                </div>
                <div class="layui-inline">
                    <input class="layui-input search_key" name="search_name" id="demoReload" placeholder="昵称" autocomplete="off">
                </div>
                <button class="layui-btn" data-type="reload">搜索</button>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.avatar}}" alt="" height="28">
</script>


<script>
    var main_url = "{{guard_url('user')}}";
    var delete_all_url = "{{guard_url('user/destroyAll')}}";
    layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        table.render({
            elem: '#fb-table'
            ,url: '{{guard_url('user')}}'
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'name',title:'{!! trans('user.label.name')!!}'}
                ,{field:'local_city',title:'{!! trans('user.label.local_city')!!}'}
                ,{field:'avatar',title:'{!! trans('user.label.avatar_url')!!}',toolbar:'#imageTEM'}
                ,{field:'created_at',title:'{{ trans('app.created_at') }}'}
                ,{field:'score',title:'操作', width:200, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });


    });
</script>
{!! Theme::partial('common_handle_js') !!}
