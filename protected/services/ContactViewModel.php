<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactViewModel extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// email and body are required
			array('email, body', 'required'),
			// name and subject are safe
			array('name, subject', 'safe'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
			'verifyCode'	=> Yii::t('contact', 'Verification Code'),
			'name' 			=> Yii::t('contact', 'Name'),
			'email' 		=> Yii::t('contact', 'Email'),
			'subject' 		=> Yii::t('contact', 'Subject'),
			'body' 			=> Yii::t('contact', 'Body'),
		);
	}
}