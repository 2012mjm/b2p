<?php

/**
 * This is the model class for table "{{report}}".
 *
 * The followings are the available columns in table '{{report}}':
 * @property integer $id
 * @property integer $userId
 * @property integer $productId
 * @property integer $orderId
 * @property string $description
 * @property string $type
 * @property string $creationDate
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property Product $product
 * @property User $user
 */
class Report extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Report the static model class
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
		return '{{report}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, productId, description, creationDate', 'required'),
			array('userId, productId, orderId', 'numerical', 'integerOnly'=>true),
			array('type, status', 'length', 'max'=>5),
			array('answer', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, productId, orderId, description, type, creationDate, status, answer', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'orderId'),
			'product' => array(self::BELONGS_TO, 'Product', 'productId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => Yii::t('report', 'User'),
			'productId' => Yii::t('report', 'Product'),
			'orderId' => Yii::t('report', 'Order'),
			'description' => Yii::t('report', 'Description'),
			'type' => Yii::t('report', 'Type'),
			'creationDate' => Yii::t('main', 'Creation date'),
			'status' => 'وضعیت',
			'answer'=> 'پاسخ',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('answer',$this->answer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}