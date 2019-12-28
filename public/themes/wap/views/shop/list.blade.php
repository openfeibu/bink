@foreach($shops_data as $key => $shop)
    <div class="shopList-item clearfix">
        
           <!-- <div class="img">
                <img src="@if($shop['image']){{ url('image/original/'.$shop['image']) }}@else{{ theme_asset('/images/default_shop.jpeg') }}@endif" alt="">
            </div>-->
		<div class="test">
		<!--<img src="{!! theme_asset('images/sqd.png') !!}" alt=""/>
		 <a href="{{ url('/shop/'.$shop['id']) }}"> </a>-->
			<div class="type"><img src="{!! theme_asset('images/zmd.png') !!}" alt=""/></div>
			<div class="name fb-overflow-1">{{ $shop['shop_name'] }}</div>
			<div class="map  fb-overflow-2">{{ $shop['address'] }}</div>
			<div class="date">营业时间：{{ date('H:i',strtotime($shop['opening_time'])) }} - {{ date('H:i',strtotime($shop['closing_time'])) }}</div>
			
		</div>
      
        <div class="mapNav">
            <div class="distance">{{ $shop['distance'] }}km</div>
			
            <div class="mapNav-icon" onClick="openLocation('{{$shop['latitude']}}','{{$shop['longitude']}}','{{ $shop['shop_name'] }}','{{ $shop['address'] }}')"></div>
			<a class="tell-icon" href="tel:15920541739"></a>
        </div>
		<div class="tags fb-float-left"><span>神秘烟弹活动</span></div>
    </div>
	<div class="shopList-item clearfix">
        
           <!-- <div class="img">
                <img src="@if($shop['image']){{ url('image/original/'.$shop['image']) }}@else{{ theme_asset('/images/default_shop.jpeg') }}@endif" alt="">
            </div>-->
		<div class="test">
		<!--<img src="{!! theme_asset('images/sqd.png') !!}" alt=""/>
		 <a href="{{ url('/shop/'.$shop['id']) }}"> </a>-->
			<div class="type"><img src="{!! theme_asset('images/zmd.png') !!}" alt=""/></div>
			<div class="name fb-overflow-1">{{ $shop['shop_name'] }}</div>
			<div class="map  fb-overflow-2">{{ $shop['address'] }}</div>
			<div class="date">营业时间：{{ date('H:i',strtotime($shop['opening_time'])) }} - {{ date('H:i',strtotime($shop['closing_time'])) }}</div>
			
		</div>
      
        <div class="mapNav">
            <div class="distance">{{ $shop['distance'] }}km</div>
			
            <div class="mapNav-icon" onClick="openLocation('{{$shop['latitude']}}','{{$shop['longitude']}}','{{ $shop['shop_name'] }}','{{ $shop['address'] }}')"></div>
			<a class="tell-icon" href="tel:15920541739"></a>
        </div>
		<div class="tags fb-float-left"><span>神秘烟弹活动</span></div>
    </div>
	<div class="shopList-item clearfix">
        
           <!-- <div class="img">
                <img src="@if($shop['image']){{ url('image/original/'.$shop['image']) }}@else{{ theme_asset('/images/default_shop.jpeg') }}@endif" alt="">
            </div>-->
		<div class="test">
		<!--<img src="{!! theme_asset('images/sqd.png') !!}" alt=""/>
		 <a href="{{ url('/shop/'.$shop['id']) }}"> </a>-->
			<div class="type"><img src="{!! theme_asset('images/zmd.png') !!}" alt=""/></div>
			<div class="name fb-overflow-1">{{ $shop['shop_name'] }}</div>
			<div class="map  fb-overflow-2">{{ $shop['address'] }}</div>
			<div class="date">营业时间：{{ date('H:i',strtotime($shop['opening_time'])) }} - {{ date('H:i',strtotime($shop['closing_time'])) }}</div>
			
		</div>
      
        <div class="mapNav">
            <div class="distance">{{ $shop['distance'] }}km</div>
			
            <div class="mapNav-icon" onClick="openLocation('{{$shop['latitude']}}','{{$shop['longitude']}}','{{ $shop['shop_name'] }}','{{ $shop['address'] }}')"></div>
			<a class="tell-icon" href="tel:15920541739"></a>
        </div>
		<div class="tags fb-float-left"><span>神秘烟弹活动</span></div>
    </div>
	<div class="shopList-item clearfix">
        
           <!-- <div class="img">
                <img src="@if($shop['image']){{ url('image/original/'.$shop['image']) }}@else{{ theme_asset('/images/default_shop.jpeg') }}@endif" alt="">
            </div>-->
		<div class="test">
		<!--<img src="{!! theme_asset('images/sqd.png') !!}" alt=""/>
		 <a href="{{ url('/shop/'.$shop['id']) }}"> </a>-->
			<div class="type"><img src="{!! theme_asset('images/zmd.png') !!}" alt=""/></div>
			<div class="name fb-overflow-1">{{ $shop['shop_name'] }}</div>
			<div class="map  fb-overflow-2">{{ $shop['address'] }}</div>
			<div class="date">营业时间：{{ date('H:i',strtotime($shop['opening_time'])) }} - {{ date('H:i',strtotime($shop['closing_time'])) }}</div>
			
		</div>
      
        <div class="mapNav">
            <div class="distance">{{ $shop['distance'] }}km</div>
			
            <div class="mapNav-icon" onClick="openLocation('{{$shop['latitude']}}','{{$shop['longitude']}}','{{ $shop['shop_name'] }}','{{ $shop['address'] }}')"></div>
			<a class="tell-icon" href="tel:15920541739"></a>
        </div>
		<div class="tags fb-float-left"><span>神秘烟弹活动</span></div>
    </div>
		
@endforeach