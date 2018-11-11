<?php

class PriceCurrency extends CWidget
{
	private $_baseUrl;
	
	public $currencyBase = 'rial';
	public $currencyRial = 'Rial';
	public $currencyToman = 'Toman';
	
	public function init()
	{    
		// Get Resource path
		$assets = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
    
		// Publish files
		$this->_baseUrl = Yii::app()->assetManager->publish($assets, false, -1, YII_DEBUG);
	}
  
	public function run()
	{
		// Register JS script
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		
		$config = array(
			'currencyBase' => $this->currencyBase,
			'currencyRial' => $this->currencyRial,
			'currencyToman' => $this->currencyToman,
		);
		$cs->registerScript('priceCurrencyConfig', 'var priceCurrencyConfig='.CJavaScript::encode($config).';', CClientScript::POS_HEAD);

		$cs->registerScriptFile($this->_baseUrl.'/js/jquery.cookies.min.js');
		$cs->registerScriptFile($this->_baseUrl.'/js/jquery.number.min.js');
		$cs->registerScriptFile($this->_baseUrl.'/js/toFaEngDigit.js');
		$cs->registerScriptFile($this->_baseUrl.'/js/price.currency.js');
		
		// Render view
		$this->render('view');
	}
}
?>