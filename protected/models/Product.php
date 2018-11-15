<?php

/** 
 * This is the model class for table "{{product}}". 
 * 
 * The followings are the available columns in table '{{product}}': 
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $shortDescription
 * @property string $description
 * @property integer $photoId
 * @property integer $demoFileId
 * @property integer $projehFileId
 * @property integer $price
 * @property integer $visit
 * @property integer $countSell
 * @property string $creationDate
 * @property string $updateDate
 * @property string $status
 * @property string $statusReason
 * 
 * The followings are the available model relations: 
 * @property FileProduct[] $fileProducts
 * @property Order[] $orders
 * @property File $demoFile
 * @property File $projehFile
 * @property File $photo
 * @property User $user
 * @property Report[] $reports
 * @property Product2tag[] $product2tags
 */ 
class Product extends CActiveRecord implements IECartPosition
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return '{{product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, title, description, projehFileId, creationDate', 'required'),
			array('userId, countPage, photoId, demoFileId, projehFileId, price, visit, countSell, reasonOnlyShowAdmin', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			array('shortDescription', 'length', 'max'=>45),
			array('status', 'length', 'max'=>8),
			array('statusReason', 'length', 'max'=>255),
			array('description, updateDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, title, shortDescription, format, countPage, description, photoId, demoFileId, projehFileId, price, visit, countSell, creationDate, updateDate, status, reasonOnlyShowAdmin', 'safe', 'on'=>'search'),
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
            'fileProducts' => array(self::HAS_MANY, 'FileProduct', 'productId'),
            'orders' => array(self::HAS_MANY, 'Order', 'productId'),
            'photo' => array(self::BELONGS_TO, 'File', 'photoId'),
            'demoFile' => array(self::BELONGS_TO, 'File', 'demoFileId'),
            'projehFile' => array(self::BELONGS_TO, 'File', 'projehFileId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'reports' => array(self::HAS_MANY, 'Report', 'productId'),
			'product2tags' => array(self::HAS_MANY, 'Product2tag', 'productId'),
			'product2subcategories' => array(self::HAS_MANY, 'Product2subcategory', 'productId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' 			=> Yii::t('product', 'User'),
			'title' 			=> Yii::t('product', 'Product Title'),
			'shortDescription' 	=> Yii::t('product', 'Short Description'),
			'description' 		=> Yii::t('product', 'Description'),
			'photoId' 			=> Yii::t('product', 'Picture'),
			'demoFileId' 		=> Yii::t('product', 'Demo File'),
			'projehFileId' 		=> Yii::t('product', 'Projeh File'),
			'price' 			=> Yii::t('product', 'Price'),
			'visit' 			=> Yii::t('product', 'Visit'),
			'countSell' 		=> Yii::t('product', 'Count Sell'),
			'creationDate' 		=> Yii::t('product', 'Creation Date'),
			'updateDate' 		=> Yii::t('product', 'Update Date'),
			'status' 			=> Yii::t('product', 'Status'),
			'statusReason' 		=> Yii::t('product', 'Status Reason'),
			'reasonOnlyShowAdmin' => Yii::t('product', 'نمایش تنها برای مدیر'),
			'format' 			=> Yii::t('product', 'فرمت‌های پروژه'),
			'countPage'			=> Yii::t('product', 'تعداد صفحات پروژه'),
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
        $criteria->compare('title',$this->title,true);
        $criteria->compare('shortDescription',$this->shortDescription,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('photoId',$this->photoId);
        $criteria->compare('demoFileId',$this->demoFileId);
        $criteria->compare('projehFileId',$this->projehFileId);
        $criteria->compare('price',$this->price);
        $criteria->compare('visit',$this->visit);
		$criteria->compare('countSell',$this->countSell);
        $criteria->compare('creationDate',$this->creationDate,true);
        $criteria->compare('updateDate',$this->updateDate,true);
        $criteria->compare('status',$this->status,true);
        $criteria->compare('statusReason',$this->statusReason,true);
        $criteria->compare('reasonOnlyShowAdmin',$this->reasonOnlyShowAdmin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	function getId(){
        return $this->id;
    }

    function getPrice(){
        return $this->price;
    }
}