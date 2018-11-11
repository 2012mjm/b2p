<?php
class LoginViewModel extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	
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
				array('username, password', 'required'),
				array('rememberMe', 'boolean'),
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
			'username'=>Yii::t('user', 'Username'),
			'password'=>Yii::t('user', 'Password'),
			'rememberMe'=>Yii::t('user', 'Remember me next time'),
		);
	}
	
}