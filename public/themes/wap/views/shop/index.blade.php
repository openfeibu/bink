
<div id="page">
@include('header')
<div class="main">
  
    <div class="noShop" style="display:none;">
        <span>没有相关的店铺</span>
    </div>
    

    <div class="shopList" onscroll="getList($(this))">
		<div class="shopList-box">
			
		</div>
    </div>
	
    
</div>
<div class="container-map ">
		<div class="back"></div>
		<div id="map"></div>
		<div id="slideUp-container">
			<div class="tag"></div>
			 <div class="shopList-item clearfix">
				<div class="test">
					<div class="type"><img src="{!! theme_asset('images/zmd.png') !!}" alt=""/></div>
					<div class="name fb-overflow-1"></div>
					<div class="map  fb-overflow-2"></div>
					<div class="date">营业时间：</div>
				</div>
				<div class="mapNav">
					<div class="distance"></div>
					<div class="mapNav-icon"></div>
					<a class="tell-icon" href="tel:15920541739"></a>
				</div>
				<div class="tags fb-float-left"><span>神秘烟弹活动</span></div>
			</div>
			<a href="/report"><div class="report-error">门店信息错误？报告此门店错误</div></a>
		</div>
</div>
</div>
@include('footer')
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=YVHBZ-LNORJ-N2WFY-FDDOG-YZQRK-XOFQ2"></script>

<script>
 var map = null;
	var coordinatesList = [];
	var maxlat;
	var minlat;
	var maxlong;
	var minlong;
	var markersList = {};//markersList 信息
	var icon;
	var icon2;
	var preMarker;//上一个点击的图标
	var markersArray=[]; //标志数组
	var checkedMarker=null; //标志数组
	var page = 0 ;
	@include('wx');
   
    //初始化地图函数  自定义函数名init
    function init() {
        //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
         map = new qq.maps.Map(document.getElementById("map"), {
            center: new qq.maps.LatLng(23.816527,113.177128),      // 地图的中心地理坐标。
            zoom:14,
			disableDefaultUI: true   
			// 地图的中心地理坐标。
        });
		icon = new qq.maps.MarkerImage(
			"{!! theme_asset('images/dingwei1.svg') !!}",new qq.maps.Size(23, 28),new qq.maps.Point(3, 0),
		);
		icon2 = new qq.maps.MarkerImage(
			"{!! theme_asset('images/dingwei2.svg') !!}"
		);
    }
	
    //调用初始化函数地图
		init();
	  function getList(that){
	
		  if(!loading){
			return false
		}
		  var scrollTop = that.scrollTop();
		  var h = $(".shopList").height();
		  var ah = $(".shopList-box").height();
		  if(h+scrollTop+30 >= ah){
				ajaxList();

		  }

		}
		ajaxList();	
		function ajaxList(city_code) {
				$(".loading").fadeIn(100);
				loading = false;
                page++;
                $.ajax({
                    url : "{{ route('wap.home') }}",
                    data : {'page':page,'city_code':city_code,'distributor_id':"{{ $distributor_id }}"},
                    type : 'get',
                    dataType : "json",
                    success : function (data) {
						if(data.code == 0){
							$(".loading").fadeOut(100);
							var data = data.data;
							if(page == 1){
								
								$(".shopList-box").html("");
								markersList = {};
								//第一页
								if(data.length == 0){
									//没数据
									$(".noShop").fadeIn(200);
									loading = false;
									return false;
								}else if(data.length < 10){
									loading = false;
								}else{
									loading = true;
								}
							}else{
								//不是第一页
								if(data.length < 10){
									loading = false;
								}else{
									loading = true;
								}
							}
							var html = ''
					
							for(var i = 0,c=data.length;i < c ; i++){
								var v = data[i];
								console.log(v)
								html+=' <div class="shopList-item clearfix">'+
									'<div class="test">'+
										'<div class="type"><img src="{!! theme_asset('images/zmd.png') !!}" alt=""/></div>'+
										'<div class="name fb-overflow-1">'+v.shop_name+'</div>'+
										'<div class="map  fb-overflow-2">'+v.address+'</div>'+
										'<div class="date">营业时间：'+v.opening_time+' - '+v.closing_time+'</div>'+
									'</div>'+
									'<div class="mapNav">'+
										'<div class="distance">'+v.distance+'km</div>'+
										'<div class="mapNav-icon" tid="'+v.id+'"></div>'+
										'<a class="tell-icon" href="tel:'+v.shop_name+'"></a>'+
									'</div>'+
									'<div class="tags fb-float-left"><span>'+v.shop_name+'</span></div>'+
								'</div>';
								coordinatesList.push({id:v.id,center:new qq.maps.LatLng(v.latitude,v.longitude)})
								markersList[v.id] = v;
								//计算最佳视野
								v.latitude = parseFloat(v.latitude)
								v.longitude = parseFloat(v.longitude)
								if(!maxlat || maxlat <  v.latitude){
									maxlat = v.latitude 
								}
								if(!minlat || minlat > v.latitude){
									minlat = v.latitude 
								}
								if(!maxlong || maxlong < v.longitude){
									maxlong = v.longitude 
								}
								if(!minlong || minlong > v.longitude){
									minlong = v.longitude 
								}
								//计算最佳视野
							}
							//添加点
							addMarker();
							$(".shopList-box").append(html);
							
							if(loading == false){
								$(".shopList-box").append('<div class="noData">已经到底了</div>');
							}
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
						$(".loading").fadeOut(100);
                    }
                });
		}
    
        $(".list-switch").on("click",function(){
			if($(this).hasClass("active")){
				//切换成文字
				$(this).removeClass("active");
				$(".container-map").css({"z-index":'-1',"opacity":"0"});
			}else{
				$(this).addClass("active");
				
			$(".container-map").css({"z-index":'11',"opacity":"1"});
			}
		})
		$(".onlyShop").on("click",function(){
			if($(this).hasClass("active")){
				$(this).removeClass("active")
			}else{
				$(this).addClass("active")
			}
		})
		//打开筛选
		$(".screening").on("click",function(){
			if($(this).hasClass("active")){
				$(this).removeClass("active");
				$(".filter").hide();
				$(".filter-box").css("top","-50%")
			}else{
				$(this).addClass("active");
				$(".filter").show();
				setTimeout(function(){
					$(".filter-box").css("top","3.5rem")
				},10)
			}
			
		})
		$(".filter-bg").on("click",function(){
			$(".screening").removeClass("active");
			$(".filter").hide();
			$(".filter-box").css("top","-50%")
		})
		$("#slideUp-container .tag").on("click",function(){
			$("#slideUp-container").css("bottom","-100%")
		})
		function addMarker(){
			 
			for(var i=0;i < coordinatesList.length ;i++){
				 (function(n){
					var marker = new qq.maps.Marker({
						icon:icon,
						title:coordinatesList[n].id,
						position: coordinatesList[n].center,
						map: map,
						shape:new qq.maps.MarkerShape([0,0,23,25], "rect")
					});
					
					markersArray.push(marker);
					qq.maps.event.addListener(marker, 'click', function(e) {
						
						if(preMarker){
							preMarker.setIcon(icon)
						}
						var info = markersList[marker.getTitle()];
						console.log(info)
						$("#slideUp-container").css("bottom",0);
						$("#slideUp-container .shopList-item").find(".name").text(info.shop_name).end().find(".map").text(info.address).end().find(".date").text(info.opening_time+'-'+info.closing_time);

						marker.setIcon(icon2)
						preMarker = marker;
					});
				})(i);
			}
				map.setZoom(14)
				map.setCenter(new qq.maps.LatLng((maxlat+minlat)/2,(maxlong+minlong)/2))
		}
		//隐藏标记
		function clearOverlays(){
			
			if (markersArray) {
				for (i in markersArray) {
					markersArray[i].setMap(null);
				}
			}
			
		}
		//显示覆盖层
		function showOverlays() {
			if (markersArray) {
				for (i in markersArray) {
					markersArray[i].setMap(map);
				}
			}
			map.setCenter(new qq.maps.LatLng((maxlat+minlat)/2,(maxlong+minlong)/2))
		} 


		//删除覆盖物
		function deleteOverlays() {
			if (markersArray) {
				for (i in markersArray) {
					markersArray[i].setMap(null);
				}
				markersArray.length = 0;
			}
		}
		$(".shopList").on("click",".shopList-item .mapNav-icon",function(){
			clearOverlays();
			var tid = $(this).attr("tid");
			var info = markersList[tid];
			$("#slideUp-container .shopList-item").find(".name").text(info.shop_name).end().find(".map").text(info.address).end().find(".date").text(info.opening_time+'-'+info.closing_time).end().find(".mapNav-icon").attr("tid",info.id);
			map.setCenter(new qq.maps.LatLng(info.latitude,info.longitude))
			var marker = new qq.maps.Marker({
				icon:icon2,
				title:info.id,
				position: new qq.maps.LatLng(info.latitude,info.longitude),
				map: map,
				shape:new qq.maps.MarkerShape([0,0,23,25], "rect")
			});
			checkedMarker = marker; //保存在checkedMarker 可进行清除操作
			qq.maps.event.addListener(marker, 'click', function(e) {
			
				$("#slideUp-container").css("bottom",0);
			});
			$(".container-map").css({"z-index":'11',"opacity":"1"});
			$("#slideUp-container").css("bottom",0);
			$(".header").hide();
		})
		//导航
		$("#slideUp-container .shopList-item .mapNav-icon").on("click",function(){
			var tid = $(this).attr("tid");
			var info = markersList[tid];
			var latitude = info.latitude;
			var longitude = info.longitude;
			var name = info.shop_name;
			var address = info.address;
			wx.openLocation({
				latitude: parseFloat(latitude), // 纬度，浮点数，范围为90 ~ -90
				longitude: parseFloat(longitude), // 经度，浮点数，范围为180 ~ -180。
				name: name, // 位置名
				address: address, // 地址详情说明
				scale: 16, // 地图缩放级别,整形值,范围从1~28。默认为最大
				infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
			});
		})
		//返回列表页
		$(".container-map .back").on("click",function(){
			$(".header").show();
			$("#slideUp-container").css("bottom","-100%");
			$(".container-map").css({"z-index":'-1',"opacity":"0"});
			showOverlays();
			checkedMarker.setMap(null);
		})
		//选择筛选
		$(".filters ul").on("click","li",function(){
			$(this).toggleClass("active")
		})
		//重置数据
		function resetList(){
			deleteOverlays();
			page = 0;
		}
		
</script>
