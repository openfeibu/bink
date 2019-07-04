@foreach($shops_data as $key => $shop)
    <div class="shopList-item">
        <a href="{{ url('/shop/'.$shop['id']) }}">
            <div class="img">
                <img src="{{ url('image/original/'.$shop['image']) }}" alt="">
            </div>
            <div class="test">
                <div class="name fb-overflow-1">{{ $shop['shop_name'] }}</div>
                <div class="map  fb-overflow-2">{{ $shop['address'] }}</div>
                <div class="date">营业时间：{{ date('H:i',strtotime($shop['opening_time'])) }} - {{ date('H:i',strtotime($shop['closing_time'])) }}</div>
            </div>
        </a>
        <div class="mapNav">
            <div class="distance">{{ $shop['distance'] }}km</div>
            <div class="mapNav-icon" onClick="openLocation('{{$shop['latitude']}}','{{$shop['longitude']}}','{{ $shop['shop_name'] }}','{{ $shop['address'] }}')"></div>
        </div>

    </div>
@endforeach