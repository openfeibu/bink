<div class="copy">
    <p> {!! setting('copyright') !!}</p>
</div>
<script>
    $(function(){
        $("#searchForm").on("submit", function(e){
            //请求数据搜索接口
            alert(123)
        });
        var shareLinkUlr = location.href.split("#")[0];
        $.get("{{ url('/wechat/jssdkconfig') }}",{'apis':"onMenuShareTimeline,onMenuShareAppMessage",'url':shareLinkUlr,'debug':true,'json':false},function(data,status){
            console.log(data);
            configJsSDK(data.data)
        },'json');
        function configJsSDK(config){
            wx.config(config);
            wx.ready(function(){
                wx.getLocation({
                    type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                    success: function (res) {
                        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                        var speed = res.speed; // 速度，以米/每秒计
                        var accuracy = res.accuracy; // 位置精度
                    }
                });
                wx.openLocation({
                    latitude: 0, // 纬度，浮点数，范围为90 ~ -90
                    longitude: 0, // 经度，浮点数，范围为180 ~ -180。
                    name: '', // 位置名
                    address: '', // 地址详情说明
                    scale: 1, // 地图缩放级别,整形值,范围从1~28。默认为最大
                    infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
                });
            })

        }

        //城市选择
        var options = {
            scrollY: true, // 因为scrollY默认为true，其实可以省略
            scrollX: true,
            mouseWheel: true,
            click: true
        }
        var wrapper = document.querySelector('.wrapper');
        var scroll = new BScroll(wrapper, options);
        $('.header .map').on('click',function(){
            $('.city-box').slideDown(500,function(){
                scroll.refresh();
            });
            $('.masker').removeClass('hidden');
        })
        $('.masker').on('click', function(){
            $('.masker').addClass('hidden');
            $('.city-box').slideUp(500);
            $('.area-box').slideUp(500);
        })
        $('.city-box .content').on('click', 'li',  function(e){
            //alert(e.target.innerHTML)
            var city_code =  $(e.target).attr('city_code');
            window.location.href="{{ url('/shop') }}?city_code="+city_code;
            $('.city-box').slideUp(500);
            $('.masker').addClass('hidden');
        })
        $('.city-sidaber').on('click',function(e){
            var value = e.target.innerHTML;
            var alphabet = $('.letter-title');
            alphabet.map(function(i,item){
                if(item.innerHTML == value){
                    scroll.scrollToElement(item);
                }
            })
        })



    })
</script>