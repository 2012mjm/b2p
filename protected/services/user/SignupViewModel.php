<?php
class SignupViewModel extends CFormModel
{
	public $username;
	public $password;
	public $firstname;
	public $lastname;
	public $email;
	public $gender;
	public $birthday;
	public $fieldStudy;
	public $phone;
	public $mobile;
	public $bankName;
	public $bankAccountNumber;
	public $bankCardNumber;
	
	//don't exist in database
	public $verifyPassword;
	
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
			array('username, password, email, verifyPassword', 'required'),
			array('username', 'length', 'min' => 3, 'max' => 45, 'message' => yii::t('user', 'Incorrect username (length between 3 and 45 characters).')),
			array('password', 'length', 'min' => 4, 'max' => 45, 'message' => yii::t('user', 'Incorrect password (length between 4 and 45 characters).')),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => yii::t('user', 'Incorrect symbols (A-z0-9 and underline).')),
			array('email', 'email'),
			array('username', 'unique', 'className' => 'User', 'message' => yii::t('user', 'A user with this username already exists.')),
			array('email', 'unique', 'className' => 'User', 'message' => yii::t('user', 'A user with this email address already exists.')),
			array('email', 'length', 'max'=>255),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password'),
			
			array('firstname, lastname, fieldStudy, bankAccountNumber, bankCardNumber', 'length', 'max'=>45),
			array('phone, mobile', 'length', 'max'=>20),
			array('gender', 'length', 'max'=>6),
			array('bankName', 'length', 'max'=>10),

			array('birthday', 'safe'),
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
			'id' => 'ID',
			'username'			=> Yii::t('user', 'Username'),
			'password' 			=> Yii::t('user', 'Password'),
			'verifyPassword' 	=> Yii::t('user', 'Verify Password'),
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
		);
	}
	
}