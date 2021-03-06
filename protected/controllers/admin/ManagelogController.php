<?php

class ManagelogController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $showSidebar = false;
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function filters()
    {
        return array( 'accessControl' ); // perform access control for CRUD operations
    }

	public function accessRules()
	{
		return array(
			array('allow', // allow admin subcategory to perform all actions
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * *************************************************
	 */
	public function actionIndex()
	{
		$service = new LogService();
		$dataProvider = $service->getAllDataProvider();
	
		$this->render('index', array('dataProvider'=>$dataProvider));
	}

	/**
	 * *************************************************
	 */
	public function actionView()
	{
		$id = (int)	Yii::app()->request->getQuery('id');

		if(!empty($id))
		{
			$service = new LogService();
			$model = $service->getById($id);

			//set read
			LogService::setRead($model);

			$this->render('view', array('model'=>$model));
		}
	}
}

?>