<?php
class MyProductViewModel extends CFormModel
{
	public $id;
	public $categories;
	public $userId;
	public $title;
	public $shortDescription;
	public $description;
	public $photo;
	public $demoFile;
	public $projehFile;
	public $price;
	public $creationDate;
	public $updateDate;
	public $status;
	public $format;
	public $countPage;
	public $tags;
	
	public $photoPath;
	public $demoFilePath;
	public $projehFilePath;
	public $projehFileName;

	public $demoFileRemove;
	public $photoFileRemove;
	
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
			array('categories, title, description', 'required'),
			array('price', 'numerical', 'integerOnly'=>true, 'min'=>Yii::app()->setting->minPrice),
			array('countPage', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			array('shortDescription', 'length', 'max'=>40),
			array('status', 'length', 'max'=>8),
			array('id, description, updateDate, photo, demoFile, creationDate, userId, tags, format', 'safe'),
			
			array('photo', 'file', 'types'=>'jpg, jpeg, gif, png, bmp', 'allowEmpty'=>true, 'maxSize'=>5*1024*1024, 'tooLarge'=>'حداکثر حجم تصویر ۵ مگابایت می‌باشد.'),
			array('demoFile', 'file', 'types'=>'jpg, jpeg, gif, png, bmp, zip, rar, txt, docx, doc, pdf', 'allowEmpty'=>true, 'maxSize'=>10*1024*1024, 'tooLarge'=>'حداکثر حجم فایل دمو ۳ مگابایت می‌باشد.'),
			array('projehFile', 'file', 'types'=>'jpg, jpeg, gif, png, bmp, zip, rar, txt, docx, doc, pdf', 'allowEmpty'=>false, 'maxSize'=>50*1024*1024, 'tooLarge'=>'حداکثر حجم فایل پروژه ۵۰ مگابایت می‌باشد.', 'on'=>'create'),
			array('projehFile', 'file', 'types'=>'jpg, jpeg, gif, png, bmp, zip, rar, txt, docx, doc, pdf', 'allowEmpty'=>true, 'maxSize'=>50*1024*1024, 'tooLarge'=>'حداکثر حجم فایل پروژه ۵۰ مگابایت می‌باشد.', 'on'=>'update'),
			//array('attaches', 'file', 'types'=>'jpg, jpeg, gif, png, bmp, zip, rar, txt', 'maxFiles'=>'999999999'),
			
			array('shortDescription, description', 'filter', 'filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('shortDescription, description', 'filter', 'filter'=>array('Text','imgValid')),
				
			array('demoFileRemove, photoFileRemove', 'safe'),
		);
	}
	
	/*public function attachType($attribute, $params) {
		//$params['types']
		var_dump($this->$attribute);die;
	}
	
	public function files($attribute,$params)
	{
		for($i=0; $i<count($_POST['MyProductViewModel']['attaches']); $i++) {
			$viewModel->attaches[$i] = CUploadedFile::getInstance($viewModel, 'attaches['.$i.']');
		}
		
	    foreach(CUploadedFile::getInstances($this,$attribute) as $i=>$file)
	    {
	        $this->{$attribute}[$i] = $file;
			$validator = CValidator::createValidator('file', $this, 'attaches['.$i.']', $params);
	        $validator->validate($this, 'attaches');
	    }
	}*/

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' 			=> Yii::t('product', 'User'),
			'categories' 		=> Yii::t('product', 'دسته‌ها'),
			'title' 			=> Yii::t('product', 'Product Title'),
			'shortDescription' 	=> Yii::t('product', 'Short Description'),
			'description' 		=> Yii::t('product', 'Description'),
			'photo' 			=> Yii::t('product', 'Picture'),
			'demoFile' 			=> Yii::t('product', 'Demo File'),
			'projehFile' 		=> Yii::t('product', 'Projeh File'),
			'price' 			=> Yii::t('product', 'Price'),
			'status' 			=> Yii::t('product', 'Status'),
			'tags' 				=> Yii::t('product', 'تگ ها'),
			'format' 			=> Yii::t('product', 'فرمت‌های پروژه'),
			'countPage'			=> Yii::t('product', 'تعداد صفحات پروژه'),
		);
	}
}