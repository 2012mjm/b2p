<?php
class ReportViewModel extends CFormModel
{
	public $description;
	public $productId;
	public $orderId;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('description', 'required'),
			array('productId, orderId', 'unsafe'),
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
			'description'	=> Yii::t('report', 'Description'),
		);
	}
}