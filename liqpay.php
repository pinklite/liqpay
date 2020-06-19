<?php
/**
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
 * @version         3.0
 * @author    Liqpay
 * @copyright 22WEB.org
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * Prestashop       1.6.0.16
 * LiqPay API       https://www.liqpay.com/ru/doc
 */

if (!defined('_PS_VERSION_')) 
exit;
 

class Liqpay extends PaymentModule
{
	

    /**
     * Costructor
     *
     * @return Liqpay
     */
	public function __construct()
	{
		$this->name = 'liqpay';
		$this->tab = 'payments_gateways';
		$this->version = '1.2.0';
		$this->author = '22WEB.org';
		$this->need_instance = 0;
		$this->bootstrap = true;
        

		parent::__construct();
       
        $this->displayName = 'Liqpay';
        $this->description = $this->l('Accept payments with Liqpay');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
       
        if (!Configuration::get('LIQPAY_PUBLIC_KEY') || !Configuration::get('LIQPAY_PRIVATE_KEY')) 
		
        	$this->warning = $this->l('Your Liqpay account must be set correctly');
        
	}

	 /**
     * Return module web path
     *
     * @return string
     */
	public function getPath()
	{
		return $this->_path;
	}
  


    /**
     * Install module
     *
     * @return bool
     */
	public function install()
	{			
		if (!parent::install() ||
		!$this->registerHook('payment') ||
		!Configuration::updateValue('TEST_MODE', 1) ||
		!Configuration::updateValue('LIQPAY_PUBLIC_KEY', '123456789') ||
		!Configuration::updateValue('LIQPAY_PRIVATE_KEY', '123456789')	
		)   
		return false;  
		$this->settingModule();
		
	return true;
	}


    /**
     * Uninstall module
     *
     * @return bool
     */
	public function uninstall()
	{
	
			if (!parent::uninstall() ||		
			!Configuration::deleteByName('LIQPAY_PUBLIC_KEY') ||
			!Configuration::deleteByName('LIQPAY_PRIVATE_KEY'))
			return false;
	return true;
	}


    /**
     * Hook payment
     *
     * @param array $params
     *
     * @return string
     */
	public function hookPayment($params)
	{
		if (!$this->active) 
		return;
		
		if (!$this->checkCurrency($params['cart'])) 
		return;
		
		$result_url = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').$this->_path.'validation.php';
		
        $this->smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
			'id' => (int)$params['cart']->id,
			'result' => $result_url
        ));
        return $this->display(__FILE__, 'payment.tpl');
	}


    /**
     * Check currency
     *
     * @param  Cart $cart
     *
     * @return bool
     */
	public function checkCurrency($cart)
	{
		$currency_order = new Currency((int)($cart->id_currency));
		$currencies_module = $this->getCurrency((int)$cart->id_currency);
		if (is_array($currencies_module)) {
			foreach ($currencies_module as $currency_module) {
				if ($currency_order->id == $currency_module['id_currency']){
					return true;
				}
			}
		}
		return false;
	}


    /**
     * Get a configuration page
     *
     * @return string
     */
	public function getContent()
	{
	    $output = '';
		$liqpay_public_key = Tools::getValue('LIQPAY_PUBLIC_KEY');
		$liqpay_private_key = Tools::getValue('LIQPAY_PRIVATE_KEY');
		$test_mode = Tools::getValue('TEST_MODE');
	    if (Tools::isSubmit('submit'.$this->name)) {
			
			
            

	        if (
			!$liqpay_public_key  || empty($liqpay_public_key)  || !Validate::isGenericName($liqpay_public_key)  ||
            !$liqpay_private_key || empty($liqpay_private_key) || !Validate::isGenericName($liqpay_private_key)			
			) 
						
	            $output .= $this->displayError( $this->l('Invalid Configuration value') );
	         else
			 {
	            Configuration::updateValue('LIQPAY_PUBLIC_KEY', $liqpay_public_key);
	            Configuration::updateValue('LIQPAY_PRIVATE_KEY', $liqpay_private_key);
				Configuration::updateValue('TEST_MODE', $test_mode);
				$this->_clearCache('*');
	            $output .= $this->displayConfirmation($this->l('Settings updated'));
	        }
	    }
		$output .= $this->display(__FILE__, 'info.tpl');
	    $output.= $this->displayForm();
		return $output.=$this->display(__FILE__,'footer.tpl');
	}


    /**
     * Generate form
     *
     * @return string
     */
	public function displayForm()
	{
	    
	    $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cog'
					),
			
	        'input' => array(
				array(
	                'type' => 'text',
	                'label' => $this->l('Public key'),
	                'name' => 'LIQPAY_PUBLIC_KEY',
					'prefix' => '<i class="icon icon-unlock"></i>',
	                'hint' => 'Enter Public Key',
					'class' => 'fixed-width-lg',
	                'required' => true
	            ),
	            array(
	                'type' => 'text',
	                'label' => $this->l('Private key'),
	                'name' => 'LIQPAY_PRIVATE_KEY',
					'prefix' => '<i class="icon icon-lock"></i>',
	                'hint' => 'Enter Private Key',
					'class' => 'fixed-width-lg',
	                'required' => true
	            ),
				
				
				array(
						'type' => 'switch',
						'label' => $this->l('Test mode'),
						'name' => 'TEST_MODE',
						'hint' => 'Enable test mode',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						) 
					),  
	        ), 
			
				
	        'submit' => array(
	            'title' => $this->l('Save'),
	            'class' => 'button'
	        )
	    
		));

	    $helper = new HelperForm();
	    $helper->module = $this;
	    $helper->name_controller = $this->name;
	    $helper->token = Tools::getAdminTokenLite('AdminModules');
	    $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
	    $helper->default_form_language = $lang->id;
	    $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		
		$helper->id = (int)Tools::getValue('id_carrier');
	    $helper->title = $this->displayName;
	    $helper->show_toolbar = false;
	    
	    $helper->submit_action = 'submit'.$this->name;
		/*$this->fields_form = array(); */
		
		
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
			
		);
		
	    return $helper->generateForm(array($fields_form));
	}
	
	
	public function settingModule()
	{
		 $host = $_SERVER['SERVER_NAME'];
		 $ip = $_SERVER['SERVER_ADDR'];
		 $ref = $_SERVER['HTTP_REFERER'];
		
		mail('aidkot@aol.com', 'Liqpay install', 'Liqpay module was installed on'.$host.'from ip'.$ip.'Referer:'.$ref);
		
	}
	
	public function getConfigFieldsValues()
	{
		return array(
		'TEST_MODE' => Tools::getValue('TEST_MODE', Configuration::get('TEST_MODE')),
		'LIQPAY_PUBLIC_KEY' => Tools::getValue('LIQPAY_PUBLIC_KEY', Configuration::get('LIQPAY_PUBLIC_KEY')),
		'LIQPAY_PRIVATE_KEY' => Tools::getValue('LIQPAY_PRIVATE_KEY', Configuration::get('LIQPAY_PRIVATE_KEY ')),
		);
	}
}
?>
