<?php
class SettingViewModel extends CFormModel
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
	public $projehFormat;
	
	public $facebookPageUrl;
	public $twitterPageUrl;
	public $instagaramPageUrl;
	public $googlePlusPageUrl;
	public $youtubePageUrl;
	public $cloobPageUrl;
	public $aparatPageUrl;
	public $lenzorPageUrl;
	public $facenamaPageUrl;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projehFormat, lowWithdraw, lowWithdrawBankComission', 'required'),
			array('minPrice, lowWithdraw, lowWithdrawBankComission', 'numerical', 'integerOnly'=>true),
			array('comission', 'numerical'),
			array('siteName, parsPalMerchantID, parsPalPassword, zarinPalMerchantID', 'length', 'max'=>45),
			array('adminName, siteDefaultTheme', 'length', 'max'=>30),
			array('adminEmail, siteAddress, siteSmallAddress', 'length', 'max'=>128),
			array('adminPhone, siteCookiePrefix, siteCharset', 'length', 'max'=>20),
			array('siteDescription, siteKeywords', 'length', 'max'=>255),
			array('siteLanguage', 'length', 'max'=>10),
			array('siteTimeZone', 'length', 'max'=>15),
            array('bulletin, yahooID, facebookPageUrl, twitterPageUrl, instagaramPageUrl, googlePlusPageUrl, youtubePageUrl, cloobPageUrl, aparatPageUrl, lenzorPageUrl, facenamaPageUrl', 'safe'),
		);
	}
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'siteName'					=> Yii::t('setting', 'Site Name'),
			'adminName' 				=> Yii::t('setting', 'Admin Name'),
			'adminEmail' 				=> Yii::t('setting', 'Admin Email'),
			'adminPhone' 				=> Yii::t('setting', 'Admin Phone'),
			'siteDescription' 			=> Yii::t('setting', 'Site Description'),
			'siteKeywords' 				=> Yii::t('setting', 'Site Keywords'),
			'siteAddress' 				=> Yii::t('setting', 'Site Address'),
			'siteSmallAddress' 			=> Yii::t('setting', 'Site Small Address'),
			'siteLanguage' 				=> Yii::t('setting', 'Site Language'),
			'siteDefaultTheme' 			=> Yii::t('setting', 'Site Default Theme'),
			'siteTimeZone' 				=> Yii::t('setting', 'Site Time Zone'),
			'siteCookiePrefix' 			=> Yii::t('setting', 'Site Cookie Prefix'),
			'siteCharset' 				=> Yii::t('setting', 'Site Charset'),
			'minPrice' 					=> Yii::t('setting', 'Min Price'),
			'comission' 				=> Yii::t('setting', 'Comission'),
			'lowWithdraw' 				=> Yii::t('setting', 'Low Withdraw'),
			'lowWithdrawBankComission' 	=> Yii::t('setting', 'Low Withdraw Bank Comission'),
			'parsPalMerchantID' 		=> Yii::t('setting', 'Pars Pal Merchant'),
			'parsPalPassword' 			=> Yii::t('setting', 'Pars Pal Password'),
			'zarinPalMerchantID' 		=> Yii::t('setting', 'Zarin Pal Merchant ID'),
			'bulletin' 					=> Yii::t('setting', 'Bulletin'),
			'yahooID' 					=> Yii::t('setting', 'yahoo ID'),
			'facebookPageUrl' 			=> Yii::t('setting', 'Facebook page url'),
			'twitterPageUrl' 			=> Yii::t('setting', 'Twitter url'),
			'instagaramPageUrl' 		=> Yii::t('setting', 'Instagaram Page Url'),
			'googlePlusPageUrl' 		=> Yii::t('setting', 'Google Plus Page Url'),
			'youtubePageUrl' 			=> Yii::t('setting', 'Youtube Page Url'),
			'cloobPageUrl' 				=> Yii::t('setting', 'Cloob Page Url'),
			'aparatPageUrl' 			=> Yii::t('setting', 'Aparat Page Url'),
			'lenzorPageUrl' 			=> Yii::t('setting', 'Lenzor Page Url'),
			'facenamaPageUrl' 			=> Yii::t('setting', 'Facenama Page Url'),
			'projehFormat' 				=> Yii::t('setting', 'Projeh Format'),
		);
	}
	
}