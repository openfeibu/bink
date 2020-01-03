<style>
	.reportSuccess{text-align:center;background:#fff;padding:1rem 0}
	.reportSuccess p{text-align:center;font-size:0.5rem;color:#000;margin-bottom:0.3rem}
	.reportSuccess span{text-align:center;font-size:0.32rem;color:#666;}
</style>
<div class="wrapper-report">
  <nav class="nav-bar" onclick="javascript :history.back(-1);">
  <div class="returnLoca"></div>
    门店报错
 </nav>
 <div class="reportBox" >
  <p class="title">请选择报错信息</p>
  <div class="form">
		<div class="form-item" tid="1">    
		  <div class="content">
			<p class="sub_title">位置错误</p>
			<p class="tip">门店位置描述或导航位置错误</p></div>
		</div>
		<div class="form-item" tid="2">
		  <div class="content">
			<p class="sub_title">信息错误</p>
			<p class="tip">门店名称、营业时间等错误</p></div>
		</div>
		<div class="form-item" tid="3">
		  <div class="content">
			<p class="sub_title">活动错误</p>
			<p class="tip">门店实际活动与描述不符</p></div>
		</div>
		<div class="form-item" tid="4">
		  <div class="content">
			<p class="sub_title">门店不存在</p>
			<p class="tip">找不到这个地点</p></div>
		</div>
		<div class="more-msg">
		  <p class="title_2">您的联系电话（*非必填）</p>
		  <input maxlength="11" type="tel" class="phone" placeholder="请填写您的联系电话" value="">
		  <p class="title_2">问题描述（*非必填）</p>
		  <textarea class="textareaCon" placeholder="补充详细的描述，帮助我们更快解决您的问题"></textarea>
		</div>
		<button class="submit" >提交</button>
	</div>
	</div>
</div>
<div class="loading" style="display: none;">
	<div class="loading-c">
		<img src="/themes/wap/assets/images/loading.gif" alt="">
		<p>正在提交中</p>
	</div>
</div>
<div class="reportSuccess" style="display:none">
	<p>提交成功</p>
	<span>感谢您的反馈，我们会尽快核实门店信息</span>
</div>
<script>
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
var id = getQueryVariable("id")
var categories =[];
var tel ='';
var content ='';
$(".form-item").on("click",function(){
	$(this).toggleClass("active")
	
})
$(".wrapper-report .submit").on("click",function(){
	categories=[];
	for(var i=0; i < $(".form-item").length ; i++ ){
		if($(".form-item").eq(i).hasClass("active")){
			categories.push($(".form-item").eq(i).attr("tid"))
		}
	}
	tel = $(".phone").val();
	if(tel.length !=0 && !(/^1[23456789]\d{9}$/.test(tel))){ 
        alert("手机号码有误，请重填");  
        return false; 
    } 
	content = $(".textareaCon").val();
	if(categories.length == 0){
		alert("请选择报错信息类型");  
        return false; 
	}
	$(".loading").show();
	$.post("/report/submit",{_token:"{!! csrf_token() !!}",categories:categories,tel:tel,content:content,shop_id:id},function(data){
		console.log(data)
		if(data.code == 0){
			$(".reportSuccess").show();
			$(".loading").hide();
			$(".reportBox").hide();
		}
	})
})
</script>