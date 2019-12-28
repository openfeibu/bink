<div class="copy">
    <p> {!! setting('copyright') !!}</p>
</div>
<div class="loading">
	<div class="loading-c">
		<img src="{!! theme_asset('images/loading.gif') !!}" alt=""/>
		<p>加载中</p>
	</div>
</div>
<script>
    $(function(){
        $("#searchForm").on("submit", function(e){
            //请求数据搜索接口
            $("#searchForm").submit();
        });
        

       



    })
	
</script>