<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('distributor.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message">
                <div class="layui-inline tabel-btn">
                    <button class="layui-btn layui-btn-warm "><a href="{{ url('/admin/distributor/create') }}">添加{{ trans('distributor.name') }}</a></button>
                    <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
                </div>
                <div class="layui-inline">
                   <input class="layui-input search_key" name="distributor_name" placeholder="{{ trans('distributor.label.distributor_name') }}" autocomplete="off">
                </div>
                <button class="layui-btn" data-type="reload">搜索</button>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/html" id="qrcodeTEM">
    <a href="/image/download/@{{d.qrcode}}"><img src="/image/original/@{{d.qrcode}}" alt="" height="28">
</script>
<script>
    var main_url = "{{guard_url('distributor')}}";
    var delete_all_url = "{{guard_url('distributor/destroyAll')}}";
    layui.use(['jquery','element','table'], function(){
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;
        table.render({
            elem: '#fb-table'
            ,url: '{{guard_url('distributor')}}'
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'distributor_name',title:'{{ trans('distributor.label.distributor_name') }}'}
                ,{field:'qrcode',title:'二维码(点击下载)',toolbar:'#qrcodeTEM'}
                ,{field:'qrcode_count',title:'{{ trans('distributor.label.qrcode_count') }}'}
                ,{field:'score',title:'操作', width:200, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,height: 'full-200'
        });
    });
</script>
{!! Theme::partial('common_handle_js') !!}