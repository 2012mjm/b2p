<?php
class TicketViewModel extends CFormModel
{
	public $title;
	public $description;
	public $assignId;
	public $fixed;
	
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
			array('description', 'required'),
			array('title', 'required', 'on'=>'create'),
			array('title, assignId', 'required', 'on'=>'createAll'),
			array('assignId', 'required', 'on'=>'answerAll'),
			array('fixed', 'safe', 'on'=>'answerAll'),
			array('title', 'length', 'max'=>45),
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
			'title' => Yii::t('ticket', 'Title'),
			'description' => Yii::t('ticket', 'Description'),
			'assignId' => Yii::t('ticket', 'Assign To'),
			'fixed' => Yii::t('ticket', 'حل شده'),
		);
	}
}