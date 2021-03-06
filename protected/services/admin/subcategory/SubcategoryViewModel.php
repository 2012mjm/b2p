<?php
class SubcategoryViewModel extends CFormModel
{
	public $id;
	public $categoryId;
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
			array('categoryId, name', 	'required'),
			array('categoryId', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
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
			'categoryId' 	=> Yii::t('subcategory', 'Category'),
			'name' 			=> Yii::t('subcategory', 'Sub Category Name'),
		);
	}
	
}