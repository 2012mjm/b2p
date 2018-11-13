<?php

class ManagepageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $showSidebar = false;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$pageViewModel = new PageViewModel();
		$pageViewModel->get();

		if(isset($_POST['PageViewModel']))
		{
			$pageViewModel->set($_POST['PageViewModel']);
			
			if($pageViewModel->validate())
			{
				if($pageViewModel->create()) {
					Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'The data was not created.'));
				}
			}
		}

		$this->render('create',array(
			'pageViewModel'=>$pageViewModel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$pageViewModel = new PageViewModel();
		if(!$pageViewModel->get($id)) {
			throw new CHttpException(404, Yii::t('form', 'The requested does not exist.'));
		}

		if(isset($_POST['PageViewModel']))
		{
			$pageViewModel->set($_POST['PageViewModel']);
			
			if($pageViewModel->validate())
			{
				if($pageViewModel->update()) {
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}

		$this->render('update',array(
			'pageViewModel'=>$pageViewModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		$model = Page::model()->findByPk($id);
		if(!$model) {
			throw new CHttpException(404, Yii::t('form', 'The requested does not exist.'));
		}
		
		if($model->type == 'normal') {
			if($model->delete()) {
				Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully removed.'));
			} else {
				Yii::app()->user->setFlash('error', yii::t('form', 'The data was not removed.'));
			}
		}
		elseif($model->type == 'system') {
			Yii::app()->user->setFlash('error', yii::t('form', 'This is an item from the system and can not be removed.'));
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Page('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
			$model->attributes=$_GET['Page'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
