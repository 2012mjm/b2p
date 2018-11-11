<?php
class ProductStatusReasonViewModel extends CFormModel
{
	public $id;
	public $statusReason;
	public $reasonOnlyShowAdmin;
	
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
			array('statusReason, reasonOnlyShowAdmin', 'safe'),
			array('statusReason', 'length', 'max'=>255),
			array('id', 'unsafe'),
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
			'statusReason' => Yii::t('product', 'Status Reason'),
			'reasonOnlyShowAdmin' => 'نمایش تنها برای مدیر',
		);
	}
	
}