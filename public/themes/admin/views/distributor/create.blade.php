<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('distributor.name') }}</cite></a><span lay-separator="">/</span>
            <a><cite>添加{{ trans('distributor.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('distributor')}}" method="POST" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('distributor.label.distributor_name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="distributor_name" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans('distributor.label.distributor_name') }}" class="layui-input" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('shop.name') }}</label>
                        <div class="layui-input-block">

                            @foreach($shop_tree as $province_key => $province)
                                <div class="provinceBox">
                                    <input type="checkbox"  name="{{ $province['name'] }}" title="{{ $province['name'] }}" lay-filter="province">
                                    @foreach($province['cities'] as $city_key => $city)
                                        <div class="cityBox">
                                            <input type="checkbox" class="cityBox-input" lay-skin="primary" title="{{ $city['name'] }}" lay-filter="city">

                                            <div class="shopBox">
                                                @foreach($city['shops'] as $shop_key => $shop)

                                                    <input type="checkbox" lay-filter="shop" lay-skin="primary" name="shop_id[]" title="{{ $shop['shop_name'] }}" value="{{ $shop['id'] }}" >

                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

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
<script>
    layui.use(['jquery','element','table'], function(){
        var form = layui.form;
        var $ = layui.$;
        form.on('checkbox(province)', function(data){

            if(data.elem.checked){

                $(this).parents('.provinceBox').find('input').prop('checked', true);
            }else{
                $(this).parents('.provinceBox').find('input').prop('checked', false);
            }
            form.render();
        });
        form.on('checkbox(city)', function(data){
            var parents = $(this).parents(".provinceBox")
            var length = parents.find(".cityBox-input").length;
            var num = 0;
            $.each(parents.find(".cityBox-input"),function(k,v){
                if(v.checked){
                    num++
                }
            })
            if(num == length){
                $(this).parents(".provinceBox").find('input').eq(0).prop('checked', true)
            }else if(num == 0){
                $(this).parents(".provinceBox").find('input').eq(0).prop('checked', false)
            }

            if(data.elem.checked){
                $(this).parents('.cityBox').find('input').prop('checked', true);
            }else{
                $(this).parents('.cityBox').find('input').prop('checked', false);
            }
            form.render();
        });
        form.on('checkbox(shop)', function(data){
            var parents = $(this).parents(".shopBox")
            var length = parents.find("input").length;
            var num = 0;
            $.each(parents.find("input[type='checkbox']"),function(k,v){
                if(v.checked){
                    num++
                }
            })
            if(num == length){
                $(this).parents(".cityBox").find('input').eq(0).prop('checked', true)
            }else if(num == 0){
                $(this).parents(".cityBox").find('input').eq(0).prop('checked', false)
            }

            form.render();
        });
        //各种基于事件的操作，下面会有进一步介绍
    });

</script>