<?php
class Settings
{
	public $siteName;
	public $adminName;
	public $adminEmail;
	public $adminPhone;
	public $siteDescription;
	public $siteKeywords;
	public $siteAddress;
	public $siteSmallAddress;
	public $siteLanguage;
	public $siteDefaultTheme;
	public $siteTimeZone;
	public $siteCookiePrefix;
	public $siteCharset;
	public $minPrice;
	public $comission;
	public $lowWithdraw;
	public $lowWithdrawBankComission;
	public $parsPalMerchantID;
	public $parsPalPassword;
	public $zarinPalMerchantID;
	public $bulletin;
	public $yahooID;
	
	public $facebookPageUrl;
	public $twitterPageUrl;
	public $instagaramPageUrl;
	public $googlePlusPageUrl;
	public $youtubePageUrl;
	public $cloobPageUrl;
	public $aparatPageUrl;
	public $lenzorPageUrl;
	public $facenamaPageUrl;
	
	function __construct()
	{
		$model = Setting::model()->findByPk(1);
		if($model)
		{
			foreach (get_class_vars(__CLASS__) as $var=>$value)
			{
				if(isset($model->$var)) {
					$this->$var = $model->$var;
				}
			}
		}
	}
	
	public static function init() {}
}