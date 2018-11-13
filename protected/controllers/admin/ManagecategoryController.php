<?php

class ManagecategoryController extends Controller
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
			array('allow', // allow admin category to perform all actions
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model = new Category('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$categoryService = new CategoryService();
		
		$this->render('view',array(
			'model'=>$categoryService->getCategoryId($id),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$categoryService = new CategoryService();
		$viewModel 		= new CategoryViewModel();
		
		// get viewModel & set Category then return to viewModel
		$viewModel = $categoryService->getCategoryId($id, $viewModel);

		if(isset($_POST['CategoryViewModel']))
		{
			$viewModel->attributes = $_POST['CategoryViewModel'];
			
			if ($viewModel->validate())
			{
				if($categoryService->update($viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}

		$this->render('update', array(
			'model'=>$viewModel
		));
	}

	/**
	 * Create a particular model.
	 */
	public function actionCreate()
	{
		$categoryService = new CategoryService();
		$viewModel 		= new CategoryViewModel();

		if(isset($_POST['CategoryViewModel']))
		{
			$viewModel->attributes = $_POST['CategoryViewModel'];
			
			if ($viewModel->validate())
			{
				if($categoryService->create($viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'The data was not created.'));
				}
			}
		}

		$this->render('create', array(
			'model'=>$viewModel
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$categoryService = new CategoryService();
		if($categoryService->delete($id))
		{
			Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully removed.'));
		}
		else {
			Yii::app()->user->setFlash('error', yii::t('form', 'The data was not removed.'));
		}
		
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	
	public function actionDeletes()
	{
		if(isset($_POST['selectedIds']) && !empty($_POST['selectedIds']))
		{
			$items = explode(',', $_POST['selectedIds']);
			
			$categoryService = new CategoryService();
			if($categoryService->deletes($items))
			{
				Yii::app()->user->setFlash('success', yii::t('form', 'The datas were successfully removed.'));
			}
			else {
				Yii::app()->user->setFlash('error', yii::t('form', 'The datas were not removed.'));
			}
	    }
	    else {
	    	Yii::app()->user->setFlash('notice', yii::t('form', 'At least one item must be selected.'));
	    }
	}
	
	public function actionStatuses()
	{
		if(isset($_POST['selectedIds']) && !empty($_POST['selectedIds']))
		{
			$items = explode(',', $_POST['selectedIds']);
			
			$categoryService = new CategoryService();
			if($categoryService->statuses($items, $_POST['selectedStatus']))
			{
				Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
			}
			else {
				Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
			}
	    }
	    else {
	    	Yii::app()->user->setFlash('notice', yii::t('form', 'At least one item must be selected.'));
	    }
	}
}
