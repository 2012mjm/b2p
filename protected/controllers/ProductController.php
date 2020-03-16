<?php

class ProductController extends Controller
{
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
				array('allow', // allow all users to access all actions.
						'users' => array('@'),
						'actions' => array('my', 'myView', 'myUpdate', 'myCreate', 'myDelete', 'ajaxTag', 'ajaxCategory'),
				),
				array('allow', // allow all visitors to access all actions.
						'users' => array('*'),
						'actions' => array('index', 'view', 'shoppingCart', 'addShoppingCart', 'removeShoppingCart', 'category', 'author', 'search', 'trackingCode', 'tag'),
				),
				array('deny', // allow all visitors to access all actions.
						'users' => array('*'),
				),
		);
	}

	/**
	 * *************************************************
	 */
	public function actionIndex()
	{
		$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('/main'));
	}

	/**
	 * *************************************************
	 */
	public function actionMy()
	{
		$service = new ProductService();
		$myProductsDataProvider = $service->getMyProductsDataProvider();
	
		$this->render('my', array('myProductsDataProvider'=>$myProductsDataProvider));
	}

	/**
	 * *************************************************
	 */
	public function actionMyView()
	{
		$id = (int)	Yii::app()->request->getQuery('id');

		if(!empty($id))
		{
			$service = new ProductService();
			$model = $service->getMyProductId($id);

			$this->render('myView', array('model'=>$model));
		}
	}

	/**
	 * *************************************************
	 */
	public function actionMyUpdate()
	{
		$id = (int)	Yii::app()->request->getQuery('id');

		if(!empty($id))
		{
			$service 			= new ProductService();
			$productModel		= new Product();
			$viewModel 			= new MyProductViewModel('update');
			$viewModel 			= $service->getMyProductId($id, $viewModel);
			$viewModel->price 	/= 10;

			$currentTag = $viewModel->tags;
			$currentCategory = $viewModel->categories;

			if(isset($_POST['MyProductViewModel']))
			{
				$viewModel->attributes 	= $_POST['MyProductViewModel'];
				$viewModel->format 		= $_POST['MyProductViewModel']['format'];
				$viewModel->tags 		= $_POST['MyProductViewModel']['tags'];
				$viewModel->updateDate	= date('Y-m-d H:i:s');
				$viewModel->photo 		= CUploadedFile::getInstance($viewModel, 'photo');
				$viewModel->demoFile 	= CUploadedFile::getInstance($viewModel, 'demoFile');
				$viewModel->projehFile 	= CUploadedFile::getInstance($viewModel, 'projehFile');

				//get categories
				foreach (Subcategory::model()->with(array('category'))->findAll() as $subcategoryModel) {
					foreach($viewModel->categories as $i=>$subcategory) {
						if($subcategory == $subcategoryModel->id) {
							$viewModel->categories[$i] = $subcategoryModel->category->name.' - '.$subcategoryModel->name;
						}
					}
				}

				if ($viewModel->validate())
				{
					if($service->myUpdate($id, $viewModel))
					{
						//set log
						$log = new LogService;
						$log->title = 'ویرایش محصول';
						$log->description = "محصول #".$id." ویرایش شد.";
						$log->route = '/admin/manageproduct/update';
						$log->params = array('id'=>$id);
						$log->save();
						
						//update tags
						$service->setTags($viewModel->tags, $id, $currentTag);

						//set category for product
						$service->setCategories($viewModel->categories, $id, $currentCategory);
						
						Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
						$this->redirect(array('/product/my'));
					}
					else {
						Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
					}
				}
			}

			$this->render('myUpdate', array(
				'viewModel'=>$viewModel,
				'productModel'=>$productModel,
			));
		}
	}

	/**
	 * *************************************************
	 */
	public function actionMyCreate()
	{
		$service 		= new ProductService();
		$productModel	= new Product();
		$viewModel 		= new MyProductViewModel('create');

		if(isset($_POST['MyProductViewModel']))
		{
			$viewModel->attributes 	= $_POST['MyProductViewModel'];

			$viewModel->userId 		= Yii::app()->user->id;
			$viewModel->creationDate= date('Y-m-d H:i:s');
			$viewModel->photo 		= CUploadedFile::getInstance($viewModel, 'photo');
			$viewModel->demoFile 	= CUploadedFile::getInstance($viewModel, 'demoFile');
			$viewModel->projehFile 	= CUploadedFile::getInstance($viewModel, 'projehFile');
			//$viewModel->attaches	= CUploadedFile::getInstances($viewModel, 'attaches');

			//get categories
			foreach (Subcategory::model()->with(array('category'))->findAll() as $subcategoryModel) {
				foreach($viewModel->categories as $i=>$subcategory) {
					if($subcategory == $subcategoryModel->id) {
						$viewModel->categories[$i] = $subcategoryModel->category->name.' - '.$subcategoryModel->name;
					}
				}
			}

			if ($viewModel->validate())
			{
				$model = $service->myCreate($viewModel);
				if($model !== false)
				{
					//set log
					$log = new LogService;
					$log->title = 'ایجاد محصول جدید';
					$log->description = "محصول #".$model->id.' با عنوان "'.$model->title.'" ایجاد شد.';
					$log->route = '/product/view';
					$log->params = array('id'=>$model->id, 'title'=>Text::generateSeoUrlPersian($model->title));
					$log->save();
					
					//set tag for this product
					$service->setTags($viewModel->tags, $model->id);

					//set category for product
					$service->setCategories($viewModel->categories, $model->id);
						
					Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
					$this->redirect(array('/product/my'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'The data was not created.'));
				}
			}
		}

		$this->render('myCreate', array(
			'viewModel'=>$viewModel,
			'productModel'=>$productModel,
		));
	}

	/**
	 * *************************************************
	 */
	public function actionMyDelete()
	{
		$id = (int)	Yii::app()->request->getQuery('id');

		if(!empty($id))
		{
			$service = new ProductService();

			$model = $service->myDelete($id);
			if($model !== false)
			{
				//set log
				$log = new LogService;
				$log->title = 'حذف محصول';
				$log->description = "محصول #".$id.' با عنوان "'.$model->title.'" حذف شد.';
				$log->save();
					
				Yii::app()->user->setFlash('success', yii::t('product', 'Your product was successfully delete.'));	
			} else {
				Yii::app()->user->setFlash('error', yii::t('product', 'Your product was not delete.'));
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('/product/my'));
	}
	
	/**
	 * *************************************************
	 */
	public function actionView()
	{
		$id 	= (int)		Yii::app()->request->getQuery('id');
		$title 	= (string)	Yii::app()->request->getQuery('title');

		if(!empty($id))
		{
			$service = new ProductService();
			$model = $service->getProductIdActive($id);
			
			if(!$model) {
				throw new CHttpException(404, 'محصول مورد نظر یافت نشد.');
			}
			
			if(empty($title) OR $title != Text::generateSeoUrlPersian($model->title)) {
				$this->redirect(array("/product/view", "id"=>$model->id, "title"=>Text::generateSeoUrlPersian($model->title)));
			}
				
			//add visit
			$service->addVisit($model, 1);
			
			$dataProviderRelatedProducts = $service->dataProviderRelatedProducts($model);

			$this->render('view', array('model'=>$model, 'dataProviderRelatedProducts'=>$dataProviderRelatedProducts));
		}
	}
	
	/**
	 * *************************************************
	 */
	public function actionShoppingCart()
	{
		$orderViewModel = new OrderViewModel();
			
		if(!Yii::app()->user->isGuest) {
			$orderViewModel = OrderService::fillPostalBuy($orderViewModel);
		}

		/**
		 * ********************
		 * buy
		 */
		if(isset($_POST['OrderViewModel']))
		{
			$orderViewModel->setAttributes($_POST['OrderViewModel']);
			$orderViewModel->creationDate	= date('Y-m-d H:i:s');
			$orderViewModel->userId 		= (!Yii::app()->user->isGuest) ? Yii::app()->user->id : null;

			if($orderViewModel->validate())
			{
				$orderService = new OrderService();

				$paymentModel = $orderService->savePayment();
				if($paymentModel !== false)
				{
					// update basket and order
					$products = ProductService::getBasket();
					if($products == null) {
						return $this->redirect(array('/main'));
					}
					
					$totalPrice = 0;
					foreach ($products as $product)
					{
						$saveOrderAndPrice = $orderService->saveOrder($paymentModel->id, $product['id'], 1, $orderViewModel);
						if($saveOrderAndPrice !== false) {
							$totalPrice += $saveOrderAndPrice;
						}
					}
					
					if($totalPrice > 0) {
						//update price
						$paymentModel->price = $totalPrice;
						$paymentModel->save();
						
						$res = $orderService->sendToRestParsPal($paymentModel);
						// $res = $orderService->sendToParsPal($paymentModel);
 						// $res = $orderService->sendToZarinPal($paymentModel);

						//set log
						$log = new LogService;
						$log->title = 'خطا در ارتباط با سیستم بانک';
						$log->description = "پرداخت مبلغ ".($totalPrice/10)." تومان، در ارتباط با سیستم پرداخت بانک مشکلی پیش آمده است! خطای: ".$res;
						$log->save();
						
						Yii::app()->user->setFlash('error', $res);
						//$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('/main'));
					}
				} else {
					Yii::app()->user->setFlash('error', 'اطلاعات شما ثبت نشد!');
				}
			}
		}
			
		$this->render('shoppingCart', array(
			'viewModel'=>$orderViewModel,
			'products'=>ProductService::getBasket(),
			'totalCount'=>Yii::app()->shoppingCart->getItemsCount(),
			'totalCost'=>Yii::app()->shoppingCart->getCost(false),
		));
	}
	
	/**
	 * *************************************************
	 */
	public function actionAddShoppingCart($id)
	{
		if(empty($id)) {
			Yii::app()->user->setFlash('error', yii::t('product', 'The product was not added to shopping cart'));
		}
		else
		{
			if(Yii::app()->shoppingCart->itemAt($id)) {
				Yii::app()->user->setFlash('error', 'این مورد در سبد خرید شما موجود می باشد.');
			}
			else {
				$service = new ProductService();
				$model = $service->getProductIdActive($id);
				
				if($model != null)
				{
					Yii::app()->shoppingCart->put($model);
					
					//set log
					/*$log = new LogService;
					$log->title = 'افزودن محصول به سبد خرید';
					$log->description = "محصول #".$model->id.' با عنوان "'.$model->title.'" به سبد خرید اضافه شد.';
					$log->route = '/product/view';
					$log->params = array('id'=>$model->id, 'title'=>Text::generateSeoUrlPersian($model->title));
					$log->save();*/
					
					Yii::app()->user->setFlash('success', yii::t('product', 'The product was successfully added to shopping cart'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('product', 'The product was not added to shopping cart'));
				}
			}
		}
		
		$this->redirect(array('/product/shoppingCart'));
		return;
	}
	
	/**
	 * *************************************************
	 */
	public function actionRemoveShoppingCart($id)
	{
		Yii::app()->shoppingCart->remove($id);

		//set log
		/*$log = new LogService;
		$log->title = 'حذف محصول از سبد خرید';
		$log->description = "محصول #".$id.' از سبد خرید حذف شد.';
		$log->route = '/product/view';
		$log->params = array('id'=>$id);
		$log->save();*/
		
		Yii::app()->user->setFlash('success', yii::t('product', 'The product was successfully removed from shopping cart'));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('index'));
	}

	public function actionCategory()
	{
		$id 	= (int)		Yii::app()->request->getQuery('id');
		$subId 	= (int)		Yii::app()->request->getQuery('subId', 0);
		$title 	= (string)	Yii::app()->request->getQuery('title', null);

		$fixCategoryTitle = CategoryService::getCategoryNameWithId($id);

		if(Text::generateSeoUrlPersian($fixCategoryTitle) != $title) {
			if($subId != 0) {
				return $this->redirect(array('/product/category', 'id'=>$id, 'subId'=>$subId, 'title'=>Text::generateSeoUrlPersian($fixCategoryTitle)));
			} else {
				return $this->redirect(array('/product/category', 'id'=>$id, 'title'=>Text::generateSeoUrlPersian($fixCategoryTitle)));
			}
		}
		
		$productService 		= new ProductService();
		$productsDataProvider 	= $productService->getProductsCategoryDataProvider($id, $subId);

		$this->render('category', array(
			'productsDataProvider' => $productsDataProvider,
			'categoryName' => $fixCategoryTitle,
			'subCategoryName' => SubcategoryService::getSubcategoryNameWithId($subId),
		));
	}

	public function actionTag()
	{
		$id 	= (int)		Yii::app()->request->getQuery('id');
		$title 	= (string)	Yii::app()->request->getQuery('title', null);
		
		$fixTitle = TagService::getNameWithId($id);
		
		if(Text::generateSeoUrlPersian($fixTitle) != $title) {
			return $this->redirect(array('/product/tag', 'id'=>$id, 'title'=>Text::generateSeoUrlPersian($fixTitle)));
		}

		$productService 		= new ProductService();
		$productsDataProvider 	= $productService->getTagsCategoryDataProvider($id);

		$this->render('tag', array(
			'productsDataProvider' => $productsDataProvider,
			'tagName' => $fixTitle,
		));
	}

	public function actionAuthor()
	{
		$username 	= (string) Yii::app()->request->getQuery('username');
		$name 		= (string)	Yii::app()->request->getQuery('name', null);

		$productService 		= new ProductService();
		$productsDataProvider 	= $productService->getProductsUserDataProvider($username);
		
		$userModel = User::model()->findByAttributes(array('username'=>$username));

		$this->render('author', array(
			'productsDataProvider' => $productsDataProvider,
			'username' 	=> $username,
			'name'		=> $name,
			'userModel' => $userModel,
		));
	}
	
	/**
	 * *************************************************
	 */
	public function actionSearch()
	{
		$searchViewModel = new SearchViewModel();

		if(isset($_GET['SearchViewModel']))
		{
			$searchViewModel->setAttributes($_GET['SearchViewModel']);
			
			if($searchViewModel->validate())
			{
				$productService = new ProductService();
				$productsDataProvider = $productService->getProductsSearchDataProvider($searchViewModel);

				//set log
				$log = new LogService;
				$log->title = 'جستجوی محصول';
				$log->description = 'کلمه "'.$searchViewModel->key.'" در سیستم جستحو شد.';
				$log->route = '/product/search';
				$log->params = array(CHtml::activeName($searchViewModel, 'key') => $searchViewModel->key);
				$log->save();
			}
		
			$this->render('search', array(
				'productsDataProvider' 	=> $productsDataProvider,
				'searchViewModel'		=> $searchViewModel,
			));
		}
		else {
			$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('/main'));
		}
	}
		
	public function actionTrackingCode()
	{
		$result = array();
		$trackingCodeViewModel = new TrackingCodeViewModel();

		if(isset($_POST['TrackingCodeViewModel']))
		{
			$trackingCodeViewModel->setAttributes($_POST['TrackingCodeViewModel']);
			
			if($trackingCodeViewModel->validate())
			{
				$orderService = new OrderService();
				$model = $orderService->trackingCheck($_POST['TrackingCodeViewModel']['code']);
				
				if($model)
				{
					//set log
					$log = new LogService;
					$log->title = 'پیگیری کد رهگیری';
					$log->description = 'کد "'.$model->trackingCode.'" در سیستم رهگیری شده است.';
					$log->save();
				}
			}
			
			$this->render('trackingCode', array(
				'model'=>$model,
				'trackingCodeViewModel'=>$trackingCodeViewModel)
			);
		}
		else {
			$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('/main'));
		}
	}
	
	public function actionAjaxTag()
	{
		$q = str_replace(['#', '،'], '', $_GET['q']);
		
		$criteria = new CDbCriteria();
		$criteria->compare('t.name', $q, true);
		$criteria->together = true;
		$criteria->with[] = 'product2tags';
		
		$models = Tag::model()->findAll($criteria);
		
		$items = array();
		$exist = false;
		foreach ($models as $model)
		{
			if($model->name == $q) $exist = true;
			
			$items[] = array(
				'id'	=> $model->name,
				'text'	=> $model->name,
				'count'	=> count($model->product2tags),
			);
		}
		
		if(!$exist)
		{
			$items[] = array(
				'id'	=> $q,
				'text'	=> $q,
				'count'	=> 0,
			);
		}
		
		echo json_encode(array(
			'total_count'=>count($models),
			'items'=>$items,
		));
	}
	
	public function actionAjaxCategory()
	{
		$qList = explode(' ', $_GET['q']);
		
		$criteria = new CDbCriteria();

		foreach($qList as $q) {
			$criteria->compare('t.name', $q, true, 'OR');
			$criteria->compare('category.name', $q, true, 'OR');
		}

		$criteria->together = true;
		$criteria->with[] = 'category';
		
		$models = Subcategory::model()->findAll($criteria);
		
		$items = array();
		$exist = false;
		foreach ($models as $model)
		{
			$items[] = array(
				'id'	=> $model->id,
				'text'	=> $model->category->name.' - '.$model->name,
			);
		}
		
		echo json_encode(array(
			'total_count'=>count($models),
			'items'=>$items,
		));
	}
}

?>