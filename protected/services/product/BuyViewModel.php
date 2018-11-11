<?php
class BuyViewModel extends CFormModel
{
	public $firstName;
	public $lastName;
	public $phoneHome;
	public $mobile;
	public $email;
	public $phoneWork;
	public $postalCode;
	public $address;
	
	//post type
	public $R;
	
	//hidden field
	public $productsCount;
	public $idOstan;
	public $idShahr;
	public $vendorsSerial;
	public $B2;
	public $products;
	public $description;

	public $vendorName;
	public $factorKey;
	
	public $resultTracking;
	
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
			array('firstName, lastName, phoneHome, postalCode, address, R, productsCount, idShahr, idOstan, vendorsSerial, B2, products', 'required'),
			array('firstName, lastName', 'length', 'max'=>45),
			array('phoneWork, phoneHome', 'length', 'max'=>20),
			array('mobile', 'length', 'max'=>11),
			array('email', 'email'),
			array('address', 'length', 'max'=>255),
			//array('description', 'length', 'max'=>255),
			array('postalCode', 'length', 'max'=>10),
			array('vendorName, factorKey, description, resultTracking', 'safe'),
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
			'firstName' 		=> Yii::t('user', 		'First Name'),
			'lastName' 			=> Yii::t('user', 		'Last Name'),
			'phoneWork' 		=> Yii::t('user', 		'Phone Work'),
			'phoneHome' 		=> Yii::t('user', 		'Phone Home'),
			'mobile' 			=> Yii::t('user', 		'Mobile'),
			'email' 			=> Yii::t('user', 		'Email'),
			'postalCode' 		=> Yii::t('user', 		'Postal Code'),
			'address' 			=> Yii::t('user', 		'Address'),
			'description' 		=> Yii::t('product', 	'Description'),
		);
	}
	
}