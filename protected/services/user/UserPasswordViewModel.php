<?php
class UserPasswordViewModel extends CFormModel
{
	public $oldPassword;
	public $password;
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
			array('oldPassword, password, verifyPassword', 'required'),
			array('oldPassword, password, verifyPassword', 'length', 'max'=>45),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password'),
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
			'oldPassword' 		=> Yii::t('user', 'Old password'),
			'password' 			=> Yii::t('user', 'New password'),
			'verifyPassword' 	=> Yii::t('user', 'Verify new Password'),
		);
	}
}