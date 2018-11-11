<?php
class CategoryViewModel extends CFormModel
{
	public $id;
	public $name;
	
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
			array('name', 	'required'),
			array('name', 	'length', 'max'=>45),
			array('id', 	'safe'),
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
			'name' 		=> Yii::t('category', 'Category Name'),
		);
	}
	
}