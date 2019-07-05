<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="﻿{{ route('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('distributor.name') }}</cite></a><span lay-separator="">/</span>
            <a><cite>添加{{ trans('distributor.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('distributor/'.$distributor->id)}}" method="POST" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('distributor.label.distributor_name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="distributor_name" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans('distributor.label.distributor_name') }}" class="layui-input" value="{{ $distributor['distributor_name'] }}" >
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
											<input type="checkbox" lay-skin="primary" title="{{ $city['name'] }}" lay-filter="city">
										
											<div class="shopBox">
											@foreach($city['shops'] as $shop_key => $shop)
											
												<input type="checkbox" lay-skin="primary" name="shop_id[]" title="{{ $shop['shop_name'] }}" value="{{ $shop['id'] }}" @if(in_array($shop["id"],$distributor_shop_ids)) checked @endif>
											
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
                    <input type="hidden" name="_method" value="PUT">
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
	console.log(123)
	  if(data.elem.checked){
		
			$(this).parents('.cityBox').find('input').prop('checked', true);
		}else{
			$(this).parents('.cityBox').find('input').prop('checked', false);
		}
		form.render();
	});
  //各种基于事件的操作，下面会有进一步介绍
});
    
</script>
