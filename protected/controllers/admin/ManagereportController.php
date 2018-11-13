<?php

class ManagereportController extends Controller
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
		
		if($model->status == 'new') {
			$model->status = 'read';
			$model->save();
		}
		
		$viewModelReport = new ManageReportViewModel();
		if(isset($_POST['ManageReportViewModel']))
		{
			$viewModelReport->setAttributes($_POST['ManageReportViewModel']);
			if($viewModelReport->validate())
			{
				$model->answer = $viewModelReport->answer;
				$model->status = 'fixed';
				
				if($model->save())
				{
					Yii::app()->user->setFlash('success', 'پاسخ شما با موفقیت ارسال شد.');

					//send mail
					$to = $model->user->email;
					$subject = "پاسخ به گزارش تخلف شما در بیا تو پروژه";
					$message = '<div style="direction:rtl;text-align:right">';
					$message .= 'پاسخ به گزارش تخلف شما:<br>';
					$message .= nl2br($model->answer);
					$message .= '<br><br><hr>بیا تو پروژه<br><a href="http://bia2projeh.ir">www.bia2projeh.ir</a>';
					$message .= '</div>';
					$headers = "From: ".Yii::app()->setting->adminEmail . "\r\n" .
							"Content-type:text/html;charset=UTF-8";
					
					mail($to,$subject,$message,$headers);
				}
				else {
					Yii::app()->user->setFlash('error', 'مشکلی پیش آمده است دوباره تلاش کنید.');
				}
			}
		}
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'viewModelReport'=>$viewModelReport,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.id DESC';
		$criteria->limit = 20;
		$criteria->together = true;
		$criteria->with[] = 'product';
		$criteria->with[] = 'user';

		$dataProvider = new CActiveDataProvider('Report', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Report::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='report-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
