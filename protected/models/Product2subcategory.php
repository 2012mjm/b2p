<?php

/**
 * This is the model class for table "{{product2subcategory}}".
 *
 * The followings are the available columns in table '{{product2subcategory}}':
 * @property integer $id
 * @property integer $productId
 * @property integer $subcategoryId
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Subcategory $subcategory
 */
class Product2subcategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product2subcategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product2subcategory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productId, subcategoryId', 'required'),
			array('productId, subcategoryId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, productId, subcategoryId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'productId'),
			'subcategory' => array(self::BELONGS_TO, 'Subcategory', 'subcategoryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'productId' => 'Product',
			'subcategoryId' => 'Subcategory',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('subcategoryId',$this->subcategoryId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}