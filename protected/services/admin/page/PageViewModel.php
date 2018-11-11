<?php
class PageViewModel extends CFormModel
{
	private $model;

	public $title;
	public $key;
	public $context;
	public $type;
	
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
			array('type', 'unsafe'),
			array('key', 'unsafe', 'on'=>'system'),
			
			array('title, context', 'required'),
			array('key', 'required', 'on'=>'normal'),

			array('key', 'unique', 'className' => 'Page', 'message' => yii::t('main', 'A key is already exists.'), 'criteria' => array(
				'condition' => 'id != :id',
				'params' => array(':id' => $this->model->id)
			)),
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
			'title'=>'عنوان',
			'key' => 'کلید',
			'context'=>'محتویات',
		);
	}
	

	public function get($id=null) {

		if($id) {
			//for update
			$this->model = Page::model()->findByPk($id);
			if(!$this->model) return false;
			
			$this->attributes 	= $this->model->attributes;
			$this->type	 		= $this->model->type;
			$this->key	 		= $this->model->key;
		}
		else {
			//for create
			$this->model = new Page();
			$this->model->id = 0;
			$this->type	 = 'normal';
		}

		$this->setScenario($this->type);
		
		return true;
	}
	
	public function set($attributes) {
		
		$this->setAttributes($attributes);
	}
	

	public function create() {

		$this->model->attributes = $this->attributes;
		$this->model->creationDate = date('Y-m-d H:i:s');
		$this->model->type = $this->type;
		$this->model->visit = 0;

		if($this->model->save()) {
			return true;
		}
		return false;
	}
	

	public function update() {
	
		$this->model->attributes = $this->attributes;
		$this->model->updateDate = date('Y-m-d H:i:s');

		if($this->model->save()) {
			return true;
		}

		return false;
	}
}