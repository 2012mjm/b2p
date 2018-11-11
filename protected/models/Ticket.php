<?php

/**
 * This is the model class for table "{{ticket}}".
 *
 * The followings are the available columns in table '{{ticket}}':
 * @property integer $id
 * @property integer $subId
 * @property integer $userId
 * @property integer $assignId
 * @property string $title
 * @property string $description
 * @property string $creationDate
 * @property string $status
 * @property string $manageStatus
 *
 * The followings are the available model relations:
 * @property Ticket $sub
 * @property Ticket[] $tickets
 * @property User $user
 * @property User $assign
 */
class Ticket extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ticket the static model class
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
		return '{{ticket}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, assignId, description, creationDate', 'required'),
			array('subId, userId, assignId', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
			array('status, manageStatus', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subId, userId, assignId, title, description, creationDate, status, manageStatus', 'safe', 'on'=>'search'),
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
			'sub' => array(self::BELONGS_TO, 'Ticket', 'subId'),
			'tickets' => array(self::HAS_MANY, 'Ticket', 'subId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'assign' => array(self::BELONGS_TO, 'User', 'assignId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subId' => Yii::t('ticket', 'Sub'),
			'userId' => Yii::t('ticket', 'User'),
			'assignId' => Yii::t('ticket', 'Assign'),
			'title' => Yii::t('ticket', 'Title'),
			'description' => Yii::t('ticket', 'Description'),
			'creationDate' => Yii::t('ticket', 'Creation Date'),
			'status' => Yii::t('ticket', 'Status'),
			'manageStatus' => Yii::t('ticket', 'Manage Status'),
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
		$criteria->compare('subId',$this->subId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('assignId',$this->assignId);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('manageStatus',$this->manageStatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}