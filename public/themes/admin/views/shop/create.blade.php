<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="﻿{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('shop.name') }}</cite></a><span lay-separator="">/</span>
            <a><cite>添加{{ trans('shop.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('shop')}}" method="POST" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('shop.label.shop_name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="shop_name" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans('shop.label.shop_name') }}" class="layui-input" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('shop.label.city_name') }}</label>
                        <div class="layui-input-inline">
                            <select name="city_code" lay-verify="required" lay-search>
                                <option value=""></option>
                                @foreach(app('city_repository')->getCities() as $key => $city)
                                <option value="{{ $city['city_code'] }}">{{ $city['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图片</label>
                        {!! $shop->files('image')
                        ->url($shop->getUploadUrl('image'))
                        ->uploader()!!}
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">轮播图</label>
                        {!! $shop->files('images',true)
                        ->url($shop->getUploadUrl('images'))
                        ->uploaders()!!}
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('shop.label.business_time') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="business_time" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans('shop.label.business_time') }}" class="layui-input" id="business_time">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">经纬度</label>
                        <div class="layui-input-inline">
                            <input type="text" name="longitude" autocomplete="off" placeholder="" class="layui-input" value="{{$shop['longitude']}}" readonly>
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="latitude" autocomplete="off" placeholder="" class="layui-input" value="{{$shop['latitude']}}" readonly>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('shop.label.address') }}</label>
                        <div class="layui-input-inline">
                            <input id="keyword" name="address" type="textbox"  class="layui-input"  value="">
                            <input type="button" value="搜索" class="layui-button-mapsearch"  onclick="searchKeyword()">
                            <div class="layui-form-mid layui-word-aux">点击地图快速获取经纬度</div>
                        </div>

                        <div id="map"></div>
                    </div>

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">内容</label>
                        <div class="layui-input-block">
                            <script type="text/plain" id="content" name="content" style="width:1000px;height:240px;">

                            </script>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    {!!Form::token()!!}
                </form>
            </div>

        </div>
    </div>
</div>


<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key={{ config('common.qq_map_key') }}"></script>
{!! Theme::asset()->container('ueditor')->scripts() !!}
<script>
    var ue = getUe();
    window.onload = function(){
        init();
    }
    layui.use('laydate', function() {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#business_time'
            ,type:'time'
            ,format:'HH:mm'
            , range: true
        });
    });
</script>
<script>
    var searchService,map,markers = [];
    var init = function() {
        var center = new qq.maps.LatLng(23.15641,113.3318);
        map = new qq.maps.Map(document.getElementById('map'),{
            center: center,
            zoom: 13
        });
        //设置圆形
        // new qq.maps.Circle({
        //     center:new qq.maps.LatLng(39.936273,116.44004334),
        //     radius: 2000,
        //     map: map
        // });
        var latlngBounds = new qq.maps.LatLngBounds();
        //调用Poi检索类
        searchService = new qq.maps.SearchService({
            //设置搜索范围为北京
            location: "广州",
            //设置搜索页码为1
            pageIndex: 1,
            //设置每页的结果数为5
            pageCapacity: 5,
            //设置展现查询结构到infoDIV上
            panel: document.getElementById('infoDiv'),
            //设置动扩大检索区域。默认值true，会自动检索指定城市以外区域。
            autoExtend: true,
            //检索成功的回调函数
            complete : function(results){
                var pois = results.detail.pois;
                console.log(results)
                for(var i = 0,l = pois.length;i < l; i++){
                    var poi = pois[i];
                    latlngBounds.extend(poi.latLng);
                    var marker = new qq.maps.Marker({
                        map:map,
                        position: poi.latLng
                    });

                    marker.setTitle(i+1);
                    qq.maps.event.addListener(marker,'click',function(event) {
                        document.getElementsByName('longitude')[0].value = event.latLng.getLng();
                        document.getElementsByName('latitude')[0].value = event.latLng.getLat();
                    })
                    markers.push(marker);
                }
                map.fitBounds(latlngBounds);
            }
        });
        qq.maps.event.addListener(map,'click',function(event) {
            document.getElementsByName('longitude')[0].value = event.latLng.getLng();
            document.getElementsByName('latitude')[0].value = event.latLng.getLat();
        })
    }
    //清除地图上的marker
    function clearOverlays(overlays) {
        var overlay;
        while (overlay = overlays.pop()) {
            overlay.setMap(null);
        }
    }
    //调用poi类信接口
    function searchKeyword() {
        var keyword = document.getElementById("keyword").value;
        region = new qq.maps.LatLng(39.936273,116.44004334);
        clearOverlays(markers);
        // searchService.setPageCapacity(5);
        searchService.search(keyword);//根据中心点坐标、半径和关键字进行周边检索。
    }
</script>