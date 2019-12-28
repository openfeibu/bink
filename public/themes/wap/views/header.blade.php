<div class="header">
	<div class="banner"><img src="{!! theme_asset('images/banner.jpeg') !!}" alt=""/></div>
	<div class="header-b">
		<div class="header-t fb-clearfix">

			<div class="map  fb-float-left">
				<input type="text" id="getArea" placeholder="请选择地区" value="" readonly>
				<span class="fb-overflow-1">@if(isset($city['name'])){{ $city['name'] }} @else请选择地址@endif</span>
			</div>
			<script>

				$(function(){
					$('#getArea').getArea({
						defaultArea: [18, 2, 3],
						inpEle: '#getArea',
						normalArea: true
					});
				})

			</script>
			<div class="fb-float-right">
				<div class="onlyShop fb-float-left">只看专卖店</div>
				<div class="screening fb-float-left">筛选</div>
				<div class="list-switch fb-float-left"></div>
			</div>
		</div>
	<!--<div class="search">
            <form id="searchForm" action="{{ url('/shop') }}">
                <input type="search" name="search_key" placeholder="按零售门店的名称来搜索" value="@if(isset($search_key)){{ $search_key}}@endif">
                <input type="hidden" name="city_code" value="@if(isset($city_code)){{ $city_code}}@endif">
				{!! csrf_field() !!}
			</form>
        </div>-->
	</div>
</div>
<div class="filter active">
	<div class="filter-bg"></div>
	<div class="filter-box">
		<div class="filters">
			<p class="line line_title">售卖产品：</p>
			<ul class="line">
				<li class="default active" >套装 / 替换弹 / 小冰壳等</li>
				<li class="">一次性小冰壳</li>
			</ul>
			<p class="line line_title">热门活动：</p>
			<ul class="line">
				<li class="">神秘烟弹活动</li>
			</ul>
		</div>
		<div class="btn-group">
			<button class="reset">重置</button><button class="submit">确定</button>
		</div>
	</div>
</div>