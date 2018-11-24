<?php

class ManageorderController extends Controller
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$model->isRead = true;
		$model->save();
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$orderService = new OrderService();
		$totalPay = $orderService->getTotalPay();

		$criteria = new CDbCriteria;
		$criteria->order = 't.id DESC';
		$criteria->limit = 20;
		$criteria->together = true;
		$criteria->with[] = 'product';
		$criteria->with[] = 'user';
		$criteria->with[] = 'payment';

		$dataProvider = new CActiveDataProvider('Order', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'totalPay'=>$totalPay,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
