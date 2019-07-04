
<div class="main pb ">
    <div class="return">
        <a href="javascript:history.go(-1)"></a>
    </div>
    <div class="banner">
        <div class="swiper-container swiper-container-banner">
            <div class="swiper-wrapper">
                @foreach($shop['images'] as $key => $image)
                <div class="swiper-slide">
                    <img src="{{ url('/image/original'.$image) }}" alt="">
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination swiper-pagination-banner"></div>
        </div>
    </div>
    <div class="shopName">
        <div class="name fb-overflow-1">{{ $shop['shop_name'] }}</div>
        <div class="adress fb-overflow-2">{{ $shop['address'] }}</div>
        <div class="mapNav-icon"  onClick="openLocation('{{$shop['latitude']}}','{{$shop['longitude']}}','{{ $shop['shop_name'] }}','{{ $shop['address'] }}')"></div>
    </div>
    <div class="info fb-clearfix">
        <div class="info-item info-item1">
            <p>{{ $shop['distance'] }}km</p>
            <span>距离</span>
        </div>
        <div class="info-item info-item2">
            <p>{{ date('H:i',strtotime($shop['opening_time'])) }} - {{ date('H:i',strtotime($shop['closing_time'])) }}</p>
            <span>营业时间</span>
        </div>
        <div class="info-item info-item3">
            <p>{{ $shop['city_name'] }}</p>
            <span>位置</span>
        </div>
    </div>
    <div class="shopDetail">
        <div class="shopDetail-t">店铺详情</div>
        <div class="shopDetail-con">
            {!! $shop['content'] !!}
        </div>
    </div>
</div>


<script>
    $(function(){

        var mySwiper = new Swiper ('.swiper-container-banner', {
            loop: true,
            autoplay:3000,
            autoHeight:true,
            autoplayDisableOnInteraction : false,
            // 如果需要分页器
            pagination: '.swiper-pagination-banner',
        })

    })
</script>
