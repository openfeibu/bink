@include('wx')
@include('header')

<div class="main pb pt">
    @if(!$shops_data)
    <div class="noShop">
        <span>没有相关的店铺</span>
    </div>
    @else

    <div class="shopList">
        @include('shop.list')
    </div>
    @endif
</div>
<div class="zbtn">
	<a href="{{ url('/?skip=0') }}">招商加盟</a>
</div>
@include('city')
@include('footer')
<script>
    $(function(){
        var page = 1 ;
        var loading = true;
        $(window).scroll(function () {
            if(!loading){
                return false
            }
            //已经滚动到上面的页面高度
            var scrollTop = parseFloat($(this).scrollTop()),
                    //页面高度
                    scrollHeight = $(document).height(),
                    //浏览器窗口高度
                    windowHeight = parseFloat($(this).height()),
                    totalHeight = scrollTop + windowHeight;

            //此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作
            if (scrollTop + windowHeight >= scrollHeight - 50) {
                loading = false;
                page++;

                $.ajax({
                    url : "{{ route('wap.shop.index') }}",
                    data : {'page':page,'city_code':"{{$city_code}}"},
                    type : 'get',
                    dataType : "json",
                    success : function (data) {
                        var html = data.data.content;
                        console.log(html);
                        $fb.closeLoading();
                        if(html)
                        {
                            $(".shopList").append(html);
                            loading = true
                        }else{
                            $(".shopList").append(`<div class="noData">已经到底了</div>`);
                            loading = false
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        responseText = $.parseJSON(jqXHR.responseText);
                        var message =  responseText.msg;
                        if(!message)
                        {
                            message = '服务器错误';
                        }
                        $fb.fbNews({content:message,type:'warning'});
                    }
                });


            }
        });

    })
</script>
