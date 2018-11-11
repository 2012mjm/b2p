<?php
class SearchViewModel extends CFormModel
{
	public $key;
	public $kind;

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
			array('key', 'required'),
			array('kind', 'safe'),
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
			'key' 	=> Yii::t('form', 'Search'), //Yii::t('form', 'key'),
			'kind' 	=> Yii::t('form', 'kind'),
		);
	}
}