<?php

/**
 * This is the model class for table "{{setting}}".
 *
 * The followings are the available columns in table '{{setting}}':
 * @property integer $id
 * @property string $siteName
 * @property string $adminName
 * @property string $adminEmail
 * @property string $adminPhone
 * @property string $siteDescription
 * @property string $siteKeywords
 * @property string $siteAddress
 * @property string $siteSmallAddress
 * @property string $siteLanguage
 * @property string $siteDefaultTheme
 * @property string $siteTimeZone
 * @property string $siteCookiePrefix
 * @property string $siteCharset
 * @property integer $minPrice
 * @property double $comission
 * @property integer $lowWithdraw
 * @property integer $lowWithdrawBankComission
 * @property string $parsPalMerchantID
 * @property string $parsPalPassword
 * @property string $zarinPalMerchantID
 * @property string $bulletin
 * @property string $yahooID
 * @property string $facebookPageUrl
 * @property string $twitterPageUrl
 * @property string $instagaramPageUrl
 * @property string $googlePlusPageUrl
 * @property string $youtubePageUrl
 * @property string $cloobPageUrl
 * @property string $aparatPageUrl
 * @property string $lenzorPageUrl
 * @property string $facenamaPageUrl
 */
class Setting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Setting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{setting}}';
	}

	/**
	 * @return array validation rules for model attributes.
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
			array('adminEmail, siteAddress, siteSmallAddress, yahooID', 'length', 'max'=>128),
			array('adminPhone, siteCookiePrefix, siteCharset', 'length', 'max'=>20),
			array('siteDescription, siteKeywords', 'length', 'max'=>255),
			array('siteLanguage', 'length', 'max'=>10),
			array('siteTimeZone', 'length', 'max'=>15),
			array('facebookPageUrl, twitterPageUrl, instagaramPageUrl, googlePlusPageUrl, youtubePageUrl, cloobPageUrl, aparatPageUrl, lenzorPageUrl, facenamaPageUrl', 'length', 'max'=>225),
			array('bulletin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, siteName, adminName, adminEmail, adminPhone, siteDescription, siteKeywords, siteAddress, siteSmallAddress, siteLanguage, siteDefaultTheme, siteTimeZone, siteCookiePrefix, siteCharset, minPrice, comission, lowWithdraw, lowWithdrawBankComission, parsPalMerchantID, parsPalPassword, zarinPalMerchantID, bulletin, yahooID, facebookPageUrl, twitterPageUrl, instagaramPageUrl, googlePlusPageUrl, youtubePageUrl, cloobPageUrl, aparatPageUrl, lenzorPageUrl, facenamaPageUrl', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'siteName' => 'Site Name',
			'adminName' => 'Admin Name',
			'adminEmail' => 'Admin Email',
			'adminPhone' => 'Admin Phone',
			'siteDescription' => 'Site Description',
			'siteKeywords' => 'Site Keywords',
			'siteAddress' => 'Site Address',
			'siteSmallAddress' => 'Site Small Address',
			'siteLanguage' => 'Site Language',
			'siteDefaultTheme' => 'Site Default Theme',
			'siteTimeZone' => 'Site Time Zone',
			'siteCookiePrefix' => 'Site Cookie Prefix',
			'siteCharset' => 'Site Charset',
			'minPrice' => 'Min Price',
			'comission' => 'Comission',
			'lowWithdraw' => 'Low Withdraw',
			'lowWithdrawBankComission' => 'Low Withdraw Bank Comission',
			'parsPalMerchantID' => 'Pars Pal Merchant',
			'parsPalPassword' => 'Pars Pal Password',
			'zarinPalMerchantID' => 'Zarin Pal Merchant',
			'bulletin' => 'Bulletin',
			'yahooID' => 'Yahoo',
			'facebookPageUrl' => 'Facebook Page Url',
			'twitterPageUrl' => 'Twitter Page Url',
			'instagaramPageUrl' => 'Instagaram Page Url',
			'googlePlusPageUrl' => 'Google Plus Page Url',
			'youtubePageUrl' => 'Youtube Page Url',
			'cloobPageUrl' => 'Cloob Page Url',
			'aparatPageUrl' => 'Aparat Page Url',
			'lenzorPageUrl' => 'Lenzor Page Url',
			'facenamaPageUrl' => 'Facenama Page Url',
			'projehFormat' => 'Projeh format'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('siteName',$this->siteName,true);
		$criteria->compare('adminName',$this->adminName,true);
		$criteria->compare('adminEmail',$this->adminEmail,true);
		$criteria->compare('adminPhone',$this->adminPhone,true);
		$criteria->compare('siteDescription',$this->siteDescription,true);
		$criteria->compare('siteKeywords',$this->siteKeywords,true);
		$criteria->compare('siteAddress',$this->siteAddress,true);
		$criteria->compare('siteSmallAddress',$this->siteSmallAddress,true);
		$criteria->compare('siteLanguage',$this->siteLanguage,true);
		$criteria->compare('siteDefaultTheme',$this->siteDefaultTheme,true);
		$criteria->compare('siteTimeZone',$this->siteTimeZone,true);
		$criteria->compare('siteCookiePrefix',$this->siteCookiePrefix,true);
		$criteria->compare('siteCharset',$this->siteCharset,true);
		$criteria->compare('minPrice',$this->minPrice);
		$criteria->compare('comission',$this->comission);
		$criteria->compare('lowWithdraw',$this->lowWithdraw);
		$criteria->compare('lowWithdrawBankComission',$this->lowWithdrawBankComission);
		$criteria->compare('parsPalMerchantID',$this->parsPalMerchantID,true);
		$criteria->compare('parsPalPassword',$this->parsPalPassword,true);
		$criteria->compare('zarinPalMerchantID',$this->zarinPalMerchantID,true);
		$criteria->compare('bulletin',$this->bulletin,true);
		$criteria->compare('yahooID',$this->yahooID,true);
		$criteria->compare('facebookPageUrl',$this->facebookPageUrl,true);
		$criteria->compare('twitterPageUrl',$this->twitterPageUrl,true);
		$criteria->compare('instagaramPageUrl',$this->instagaramPageUrl,true);
		$criteria->compare('googlePlusPageUrl',$this->googlePlusPageUrl,true);
		$criteria->compare('youtubePageUrl',$this->youtubePageUrl,true);
		$criteria->compare('cloobPageUrl',$this->cloobPageUrl,true);
		$criteria->compare('aparatPageUrl',$this->aparatPageUrl,true);
		$criteria->compare('lenzorPageUrl',$this->lenzorPageUrl,true);
		$criteria->compare('facenamaPageUrl',$this->facenamaPageUrl,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}