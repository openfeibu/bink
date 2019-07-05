<script>
	var shareLinkUlr = location.href.split("#")[0];
        $.get("{{ url('/wechat/jssdkconfig') }}",{'apis':"updateAppMessageShareData,updateTimelineShareData,openLocation,getLocation",'url':shareLinkUlr,'debug':false,'json':false},function(data,status){
            configJsSDK(JSON.parse(data.data.config))
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
						$.ajax({
							url : "{{ url('/user/saveLocation') }}",
							data : {'latitude':latitude,'longitude':longitude,'_token':"{!! csrf_token() !!}"},
							type : 'post',
							dataType : "json",
							success : function (data) {
								if(data.code != 200)
								{
									var msg = data.msg;
									$fb.fbNews({content:msg,type:'warning'});
								}

								@if(isset($skip) && $skip)

//								if(data.data.first)
//								{

								    @if(isset($distributor_id) && !empty($distributor_id))
                                            window.location.href="{{ url('/shop?distributor_id='.$distributor_id)}}";
                                    @else
									    window.location.href="{{ url('/shop')}}";
                                    @endif
//								}
								@endif
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
						})
                        
                    }
                });

				
            })

        }
	function openLocation(latitude,longitude,name,address)
	{
		wx.openLocation({
			latitude: parseFloat(latitude), // 纬度，浮点数，范围为90 ~ -90
			longitude: parseFloat(longitude), // 经度，浮点数，范围为180 ~ -180。
			name: name, // 位置名
			address: address, // 地址详情说明
			scale: 16, // 地图缩放级别,整形值,范围从1~28。默认为最大
			infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
		});
	}
</script>	