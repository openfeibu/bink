<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('report.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        {!! Theme::partial('message') !!}
        <div class="layui-col-md12">
            <form class="layui-form">
                <div class="tabel-message">
                    <div class="layui-inline tabel-btn">
                        <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
                    </div>
                </div>
            <form>
            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>
<script>
    var main_url = "{{guard_url('report')}}";
    var delete_all_url = "{{guard_url('report/destroyAll')}}";
    layui.use(['jquery','element','table'], function(){
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;
        table.render({
            elem: '#fb-table'
            ,url: '{{guard_url('report')}}'
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'user_name',title:'{{ trans('user.name') }}'}
                ,{field:'shop_name',title:'{{ trans('shop.name') }}',templet:'<div><a href="{{ guard_url('shop') }}/@{{d.shop_id}}" class="layui-table-link">@{{d.shop_name}}</a></div>'}
                ,{field:'categories_name',title:'{{ trans('report_category.name') }}'}
                ,{field:'tel',title:'{{ trans('report.label.tel') }}'}
                ,{field:'content',title:'{{ trans('report.label.content') }}'}
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