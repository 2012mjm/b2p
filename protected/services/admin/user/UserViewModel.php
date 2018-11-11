<?php
class UserViewModel extends CFormModel
{
	public $id;
	public $username;
	public $password;
	public $email;
	public $firstname;
	public $lastname;
	public $fieldStudy;
	public $phone;
	public $mobile;
	public $gender;
	public $birthday;
	public $bankName;
	public $bankAccountNumber;
	public $bankCardNumber;
	public $registrationDate;
	public $lastVisit;
	public $status;
	public $virtualCredit;
	public $realCredit;
	
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
			array('username, password, email, registrationDate', 'required'),
			array('bankAccountNumber, bankCardNumber, virtualCredit, realCredit', 'numerical', 'integerOnly'=>true),
			array('username, password, firstname, lastname, fieldStudy', 'length', 'max'=>45),
			array('email', 'length', 'max'=>255),
			array('phone, mobile', 'length', 'max'=>20),
			array('gender', 'length', 'max'=>6),
			array('bankName', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('birthday, lastVisit', 'safe'),
            array('status', 'length', 'max'=>8),
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
			'firstname' 		=> Yii::t('user', 'First Name'),
			'lastname' 			=> Yii::t('user', 'Last Name'),
			'email' 			=> Yii::t('user', 'Email'),
			'gender' 			=> Yii::t('user', 'Gender'),
			'birthday' 			=> Yii::t('user', 'Birthday'),
			'fieldStudy' 		=> Yii::t('user', 'Field Study'),
			'phone' 			=> Yii::t('user', 'Phone'),
			'mobile' 			=> Yii::t('user', 'Mobile'),
			'bankName' 			=> Yii::t('user', 'Bank Name'),
			'bankAccountNumber'	=> Yii::t('user', 'Bank Account Number'),
			'bankCardNumber' 	=> Yii::t('user', 'Bank Card Number'),
			'status' 			=> Yii::t('user', 'Status'),
		);
	}
	
}