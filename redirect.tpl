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

<h3>{l s='You will be redirected to the Liqpay website in a few seconds.' mod='liqpay'} </h3>

<form id="liqpay_redirect" method="POST" action="https://www.liqpay.com/api/checkout" accept-charset="utf-8">
    <input type="hidden" name="signature"   value="{$signature|escape:'htmlall':'UTF-8'}" />
    <input type="hidden" name="data"        value="{$data|escape:'htmlall':'UTF-8'}" />
</form>

<script>document.getElementById("liqpay_redirect").submit();</script> 
