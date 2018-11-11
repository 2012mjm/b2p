<?php

class PageController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
		);
	}


	/**
	 * show static page
	 */
	public function actionIndex($key)
	{
		$model = Page::model()->findByAttributes(array('key'=>$key));
		
		if ($model === NULL)
			throw new CHttpException(404, Yii::t('main', 'The requested does not exist.'));
			
		//add visits
		$model->visit++;
		$model->save();
		
		$this->render('index', array(
			'model'=>$model,
		));
	}
}
