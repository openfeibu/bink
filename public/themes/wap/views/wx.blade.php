<script>
	var shareLinkUlr = location.href.split("#")[0];
        $.get("{{ url('/wechat/jssdkconfig') }}",{'apis':"updateAppMessageShareData,updateTimelineShareData,openLocation,getLocation",'url':shareLinkUlr,'debug':false,'json':false},function(data,status){
            configJsSDK(JSON.parse(data.data.config))
        },'json');
        function configJsSDK(config){
            wx.config(config);
            wx.ready(function(){
                wx.getLocation({
                    type: 'wgs84', // Ĭ��Ϊwgs84��gps���꣬���Ҫ����ֱ�Ӹ�openLocation�õĻ������꣬�ɴ���'gcj02'
                    success: function (res) {
						var latitude = res.latitude; // γ�ȣ�����������ΧΪ90 ~ -90
                        var longitude = res.longitude; // ���ȣ�����������ΧΪ180 ~ -180��
                        var speed = res.speed; // �ٶȣ�����/ÿ���
                        var accuracy = res.accuracy; // λ�þ���
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
									message = '����������';
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
			latitude: parseFloat(latitude), // γ�ȣ�����������ΧΪ90 ~ -90
			longitude: parseFloat(longitude), // ���ȣ�����������ΧΪ180 ~ -180��
			name: name, // λ����
			address: address, // ��ַ����˵��
			scale: 16, // ��ͼ���ż���,����ֵ,��Χ��1~28��Ĭ��Ϊ���
			infoUrl: '' // �ڲ鿴λ�ý���ײ���ʾ�ĳ�����,�ɵ����ת
		});
	}
</script>	