<?php

class ManageproductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow', // allow admin product to perform all actions
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
		$criteria = new CDbCriteria;
// 		$criteria->compare('t.status', '<>hidden');
		$criteria->order = 't.id DESC';
		$criteria->limit = 20;
		$criteria->together = true;
		$criteria->with[] = 'subcategory';
		$criteria->with[] = 'subcategory.category';

		$dataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>new Product(),
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$productService = new ProductService();
		$model = $productService->getProductId($id);

		if(!$model) {
			throw new CHttpException(404, 'محصول مورد نظر یافت نشد.');
		}
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$productService = new ProductService();
		$viewModel 		= new ProductViewModel('update');
		$productModel	= new Product();
		
		// get viewModel & set Product then return to viewModel
		$viewModel = $productService->getProductId($id, $viewModel);
		$viewModel->price /= 10;

		if(!$viewModel) {
			throw new CHttpException(404, 'محصول مورد نظر یافت نشد.');
		}

		$currentTag = $viewModel->tags;
		if(isset($_POST['ProductViewModel']))
		{
			$viewModel->attributes 	= $_POST['ProductViewModel'];
			$viewModel->photo 		= CUploadedFile::getInstance($viewModel, 'photo');
			$viewModel->demoFile 	= CUploadedFile::getInstance($viewModel, 'demoFile');
			$viewModel->projehFile 	= CUploadedFile::getInstance($viewModel, 'projehFile');
			$viewModel->price 		*= 10;
		
			if ($viewModel->validate())
			{
				if($productService->update($viewModel))
				{
// 					//set log
// 					$log = new LogService;
// 					$log->title = 'ویرایش محصول';
// 					$log->description = "محصول #".$id." ویرایش شد.";
// 					$log->route = '/admin/manageproduct/update';
// 					$log->params = array('id'=>$id);
// 					$log->save();

					//update tags
					$productService->setTags($viewModel->tags, $id, $currentTag);

					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}
		
		$subcategoryArray = SubcategoryService::subcategoryList();
		$cs = Yii::app()->clientScript;
		$cs->registerScript('subcategoryArray', 'var subcategoryArray='.CJavaScript::encode($subcategoryArray).';', CClientScript::POS_HEAD);

		$this->render('update', array(
			'viewModel'=>$viewModel,
			'productModel'=>$productModel,
		));
	}

	/**
	 * Create a particular model.
	 */
	public function actionCreate()
	{
		$productService = new ProductService();
		$viewModel 		= new ProductViewModel();
		$productModel	= new Product();

		if(isset($_POST['ProductViewModel']))
		{
			$viewModel->attributes = $_POST['ProductViewModel'];
			
			if ($viewModel->validate())
			{
				if($productService->create($viewModel))
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
			'model'=>$viewModel,
			'productModel'=>$productModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$productService = new ProductService();
		if($productService->delete($id))
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
			
			$productService = new ProductService();
			if($productService->deletes($items))
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
			
			$productService = new ProductService();
			if($productService->statuses($items, $_POST['selectedStatus']))
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
	

	public function actionStatusReason($id)
	{
		$productService = new ProductService();
		$viewModel 		= new ProductStatusReasonViewModel();
		$viewModel->id = $id;
	
		// get viewModel & set Product then return to viewModel
		$viewModel = $productService->getProductStatusReasonId($viewModel, $productModel);
	
		if(!$viewModel) {
			throw new CHttpException(404, 'محصول مورد نظر یافت نشد.');
		}

		if(isset($_POST['ProductStatusReasonViewModel']))
		{
			$viewModel->attributes 	= $_POST['ProductStatusReasonViewModel'];
	
			if ($viewModel->validate())
			{
				if($productService->statusReason($viewModel, $productModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'یادداشت مدیر ذخیره شد.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'در ذخیره یادداشت مدیر مشکلی پیش آمده است!'));
				}
			}
		}
	
		$this->render('statusReason', array(
			'viewModel'=>$viewModel,
		));
	}	
}
