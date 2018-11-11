<?php

class ConvertController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

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
			array('allow', // allow admin user to perform all actions
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCategory()
	{
		$models = Product::model()->findAll();
		$success = 0;

		foreach($models as $model) {
			$product2subcategory = new Product2subcategory();
			$product2subcategory->productId = $model->id;
			$product2subcategory->subcategoryId = $model->subcategoryId;
			if($product2subcategory->save()) {
				$success++;
			}
		}

		die('FINISH -> all: ' . count($models) . ' -> success: '. $success);
	}
}
