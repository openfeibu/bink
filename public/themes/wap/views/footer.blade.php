<div class="copy">
    <p> {!! setting('copyright') !!}</p>
</div>
<script>
    $(function(){
        $("#searchForm").on("submit", function(e){
            //请求数据搜索接口
            $("#searchForm").submit();
        });
        

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