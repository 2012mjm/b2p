<?php
class WithdrawViewModel extends CFormModel
{
	public $credit;
	
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
			array('credit', 'required'),
			array('credit', 'numerical', 'integerOnly'=>true, 'min'=>500),
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
			'credit' 			=> Yii::t('withdraw', 'Credit'),
		);
	}
	
}