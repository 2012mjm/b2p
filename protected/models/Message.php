<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property integer $senderId
 * @property integer $recieverId
 * @property string $title
 * @property string $context
 * @property string $answer
 * @property string $creationDate
 *
 * The followings are the available model relations:
 * @property User $sender
 * @property User $reciever
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return '{{message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('senderId, recieverId, title, context, creationDate', 'required'),
			array('senderId, recieverId', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
			array('answer', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, senderId, recieverId, title, context, answer, creationDate', 'safe', 'on'=>'search'),
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
			'sender' => array(self::BELONGS_TO, 'User', 'senderId'),
			'reciever' => array(self::BELONGS_TO, 'User', 'recieverId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'senderId' => 'Sender',
			'recieverId' => 'Reciever',
			'title' => 'Title',
			'context' => 'Context',
			'answer' => 'Answer',
			'creationDate' => 'Creation Date',
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
		$criteria->compare('senderId',$this->senderId);
		$criteria->compare('recieverId',$this->recieverId);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('context',$this->context,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('creationDate',$this->creationDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}