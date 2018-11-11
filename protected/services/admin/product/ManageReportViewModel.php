<?php
class ManageReportViewModel extends CFormModel
{
	public $answer;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('answer', 'required'),
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
			'answer' => 'پاسخ مدیر',
		);
	}
}