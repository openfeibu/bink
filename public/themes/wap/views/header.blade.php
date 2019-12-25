<div class="header">
    <div class="header-b">
        <div class="header-t fb-clearfix">
            <div class="logo fb-float-left"><a href="{{ url('/?skip=0') }}"><img src="{!! theme_asset('images/logo.png') !!}" alt=""></a></div>
            <div class="map  fb-float-right"><span>@if(isset($city['name'])){{ $city['name'] }} @else请选择城市@endif</span></div>
        </div>
        <div class="search">
            <form id="searchForm" action="{{ url('/shop') }}">
                <input type="search" name="search_key" placeholder="按零售门店的名称来搜索" value="@if(isset($search_key)){{ $search_key}}@endif">
                <input type="hidden" name="city_code" value="@if(isset($city_code)){{ $city_code}}@endif">
				{!! csrf_field() !!}
            </form>
        </div>
    </div>
</div>