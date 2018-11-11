<?php
class ProductService
{
	/**
	 * get product with id
	 */
	public function getProductId($id, $viewModel=null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $id);
// 		$criteria->compare('t.status', '<>hidden');
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'demoFile';
		$criteria->with[] = 'projehFile';
		$criteria->together = true;
		
		$model = Product::model()->find($criteria);
		if(!$model) {
			return null;
		}
		
		if($viewModel !== null) {
			$viewModel->attributes 	= $model->attributes;
			$viewModel->id = $model->id;
				
			// $viewModel->categoryId 		= $model->subcategory->categoryId;
			$viewModel->photoPath 		= ($model->photo) 		? Yii::app()->baseUrl . $model->photo->filePath . $model->photo->fileName : null;
			$viewModel->demoFilePath 	= ($model->demoFile) 	? Yii::app()->baseUrl . $model->demoFile->filePath . $model->demoFile->fileName : null;
				
			$viewModel->projehFilePath	= ($model->projehFile) 	? Yii::app()->baseUrl . $model->projehFile->filePath . $model->projehFile->fileName : null;
			$viewModel->projehFileName 	= ($model->projehFile) 	? substr($model->projehFile->fileName, strpos($model->projehFile->fileName, '_')+1) : null;

			//get tags
			foreach ($model->product2tags as $product2tag) {
				$viewModel->tags[$product2tag->tag->id] = $product2tag->tag->name;
			}

			//get categories
			foreach ($model->product2subcategories as $product2subcategory) {
				$viewModel->categories[$product2subcategory->subcategory->id] = $product2subcategory->subcategory->category->name.' - '.$product2subcategory->subcategory->name;
			}
		
			return $viewModel;
		}
		else {
			return $model;
		}
	}
	
	/**
	 * get product with id and active status
	 */
	public function getProductIdActive($id, $viewModel=null)
	{
		$model = Product::model()->with(array('photo', 'user', 'demoFile'))->findByAttributes(array('id'=>$id, 'status'=>'active'));
		
		if($viewModel !== null) {
			$viewModel->attributes = $model->attributes;
			$viewModel->id = $model->id;
			return $viewModel;
		}
		else {
			return $model;
		}
	}

	/**
	 * get product with id
	 */
	public function getMyProductId($id, $viewModel=null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $id);
		$criteria->compare('t.userId', Yii::app()->user->id);
		$criteria->compare('t.status', '<>hidden');
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'demoFile';
		$criteria->with[] = 'projehFile';
		$criteria->with[] = 'product2subcategories';
		$criteria->with[] = 'product2tags.tag';
		$criteria->together = true;

		$model = Product::model()->find($criteria);
		
		if($viewModel !== null) {
			$viewModel->attributes 	= $model->attributes;
			
			$viewModel->photoPath 		= ($model->photo) 		? Yii::app()->baseUrl . $model->photo->filePath . $model->photo->fileName : null;
			$viewModel->demoFilePath 	= ($model->demoFile) 	? Yii::app()->baseUrl . $model->demoFile->filePath . $model->demoFile->fileName : null;
			
			$viewModel->projehFilePath	= ($model->projehFile) 	? Yii::app()->baseUrl . $model->projehFile->filePath . $model->projehFile->fileName : null;
			$viewModel->projehFileName 	= ($model->projehFile) 	? substr($model->projehFile->fileName, strpos($model->projehFile->fileName, '_')+1) : null;

			//get tags
			foreach ($model->product2tags as $product2tag) {
				$viewModel->tags[$product2tag->tag->id] = $product2tag->tag->name;
			}

			//get categories
			foreach ($model->product2subcategories as $product2subcategory) {
				$viewModel->categories[$product2subcategory->subcategory->id] = $product2subcategory->subcategory->category->name.' - '.$product2subcategory->subcategory->name;
			}
			
			return $viewModel;
		}
		else {
			return $model;
		}
	}

	/**
	 * ************************************************************
	 * get products
	 */
	public function getProductsIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->order = 't.id DESC';
		$criteria->limit = 40;
		//'subcategory','subcategory.category',
		return Product::model()->with(array('photo'))->findAll($criteria);
	}

	/**
	 * ************************************************************
	 * get max count sell products
	 */
	public static function getProductsMaxSell()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->order = 't.countSell DESC';
		$criteria->limit = 5;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		
		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>5,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * get products dataprovider
	 */
	public function getProductsDataProvider()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->order = 't.id DESC';
		$criteria->limit = 40;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		//'subcategory','subcategory.category',
		
		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * get my products dataprovider
	 */
	public function getMyProductsDataProvider()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.userId', Yii::app()->user->id);
		$criteria->compare('t.status', '<>hidden');
		$criteria->order = 't.id DESC';
		$criteria->limit = 20;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		
		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * 
	 */
	public function myDelete($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $id);
		$criteria->compare('t.userId', Yii::app()->user->id);
		$criteria->compare('t.status', '<>hidden');
		
		$model = Product::model()->find($criteria);
		if($model) {
			$model->status = 'hidden';
			if($model->save()) {
				return $model;
			}
			//return $model->delete();
		}
		
		return false;
	}

	/**
	 * ************************************************************
	 * insert my product
	 */
	public function myCreate($viewModel)
	{
		$fileService = new FileService();
		
		$model = new Product();
		$model->setAttributes($viewModel->attributes);
		if(empty($model->shortDescription)) {
			$model->shortDescription = trim(Text::ellipsis(strip_tags($model->description), 43));
		}

		//photo
		if($viewModel->photo) {
			$model->photoId = $fileService->uploadFile($viewModel->photo, 'photo');
		}

		// demo file
		if($viewModel->demoFile) {
			$model->demoFileId = $fileService->uploadFile($viewModel->demoFile, 'demo');
		}

		// projeh file
		if($viewModel->projehFile) {
			$model->projehFileId = $fileService->uploadFile($viewModel->projehFile, 'projeh');
		}
		
		$model->price *= 10;
		if($model->save()) {
			return $model;
		}
		
		return false;
	}

	/**
	 * ************************************************************
	 * update my product
	 */
	public function myUpdate($id, $viewModel)
	{
		$fileService = new FileService();

		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $id);
		$criteria->compare('t.userId', Yii::app()->user->id);
		$criteria->compare('t.status', '<>hidden');
		
		$model = Product::model()->find($criteria);
		if($model == null) {
			return false;
		}

		$model->setAttributes($viewModel->attributes);
		if(empty($model->shortDescription)) {
			$model->shortDescription = trim(Text::ellipsis(strip_tags($model->description), 43));
		}

		//photo
		if($viewModel->photo) {
			$model->photoId = $fileService->uploadFile($viewModel->photo, 'photo');
		}
		elseif($viewModel->photoFileRemove == '1') {
			$model->photoId = null;
		}

		// demo file
		if($viewModel->demoFile) {
			$model->demoFileId = $fileService->uploadFile($viewModel->demoFile, 'demo');
		}
		elseif($viewModel->demoFileRemove == '1') {
			$model->demoFileId = null;
		}

		// projeh file
		if($viewModel->projehFile) {
			$model->projehFileId = $fileService->uploadFile($viewModel->projehFile, 'projeh');
		}
		
		$model->price *= 10;
		return $model->save();
	}

	/**
	 * ************************************************************
	 * get products category dataprovider
	 */	
	public function getProductsCategoryDataProvider($id, $subId)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->order = 't.id DESC';
		$criteria->together = true;
		$criteria->with[] = 'photo';
		
		//exist subId
		if($subId != 0) {
			$criteria->with[] = 'product2subcategories';
			$criteria->compare('product2subcategories.subcategoryId', $subId);
		}
		else {
			$criteria->with[] = 'product2subcategories.subcategory';
			$criteria->compare('subcategory.categoryId', $id);
		}

		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * get products tag dataprovider
	 */	
	public function getProductsTagDataProvider($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->order = 't.id DESC';
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'product2tags';
		
		$criteria->compare('product2tags.tagId', $id);

		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * get products tag dataprovider
	 */	
	public function getTagsCategoryDataProvider($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->order = 't.id DESC';
		$criteria->limit = 40;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'product2tags';
		
		$criteria->compare('product2tags.tagId', $id);

		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * get products author dataprovider
	 */	
	public function getProductsUserDataProvider($username)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'active');
		$criteria->compare('user.username', $username);
		$criteria->order = 't.id DESC';
		$criteria->limit = 40;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'user';

		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}

	/**
	 * ************************************************************
	 * get products search dataprovider
	 */	
	public function getProductsSearchDataProvider($searchViewModel)
	{
		$key = $searchViewModel->key;

		$criteria = new CDbCriteria;
		
		$criteria->addSearchCondition('user.username', 		$key);
		$criteria->addSearchCondition('user.firstname', 	$key, true, 'OR');
		$criteria->addSearchCondition('user.lastname', 		$key, true, 'OR');
		$criteria->addSearchCondition('t.title', 			$key, true, 'OR');
		$criteria->addSearchCondition('t.shortDescription', $key, true, 'OR');
		$criteria->addSearchCondition('t.description', 		$key, true, 'OR');
		$criteria->addSearchCondition('tag.name', 			$key, true, 'OR');
		
		$criteria->compare('t.status', 'active');
		
		$criteria->order = 't.id DESC';
		$criteria->limit = 40;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'user';
		$criteria->with[] = 'product2tags.tag';

		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $productsDataProvider;
	}
	
	/**
	 * Update Product
	 */
	public function update($viewModel) {
		
		$fileService = new FileService();

		$model = Product::model()->findByPk($viewModel->id);
		if($model == null) {
			return false;
		}
		
		$model->setAttributes($viewModel->attributes);
		$model->updateDate = date('Y-m-d H:i:s');
		
		//photo
		if($viewModel->photo) {
			$model->photoId = $fileService->uploadFile($viewModel->photo, 'photo');
		}
		elseif($viewModel->photoFileRemove == '1') {
			$model->photoId = null;
		}
		
		// demo file
		if($viewModel->demoFile) {
			$model->demoFileId = $fileService->uploadFile($viewModel->demoFile, 'demo');
		}
		elseif($viewModel->demoFileRemove == '1') {
			$model->demoFileId = null;
		}
		
		// projeh file
		if($viewModel->projehFile) {
			$model->projehFileId = $fileService->uploadFile($viewModel->projehFile, 'projeh');
		}
		
		$model->price *= 10;
		return $model->save();
	}
	
	/**
	 * Create Product
	 */
	public function create($viewModel) {
		
		$productModel = new Product();
		$productModel->attributes = $viewModel->attributes;

		$productModel->creationDate = date('Y-m-d H:i:s');
		
		$productModel->setIsNewRecord(true);
		return $productModel->save($productModel);
	}
	
	/**
	 * Delete Product
	 */
	public function delete($id)
	{
		$model = Product::model()->with(array('photo', 'demoFile', 'projehFile'))->findByPk($id);
		if($model != null) {
			
			//$fileService = new FileService();

			//$fileService->deleteFile($model->photo);
			//$fileService->deleteFile($model->demoFile);
			//$fileService->deleteFile($model->projehFile);
			
			$model->status = 'hidden';
			return $model->save();
			//return $model->delete();
		}
		
		return false;
	}

	/**
	 * Delete Products
	 * @param array $items
	 * example: array('2', '5')
	 */
	public function deletes($items)
	{
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $items);
		
		$models = Product::model()->with(array('photo', 'demoFile', 'projehFile'))->findAll($criteria);
		if($models != null) {
		
			foreach ($models as $model)
			{
				$fileService = new FileService();
	
				$fileService->deleteFile($model->photo);
				$fileService->deleteFile($model->demoFile);
				$fileService->deleteFile($model->projehFile);
			}
			
			return Product::model()->deleteAll($criteria);
		}
		
		return false;
	}

	/**
	 * change status Products
	 * @param array $items
	 * example: array('2', '5')
	 */
	public function statuses($items, $status)
	{
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $items);
		return Product::model()->updateAll(array('status'=>$status), $criteria);
	}
	
	/**
	 * product in shopping cart
	 */
	public static function getBasket()
	{
		$arrayProducts = array();
		if(($products = Yii::app()->shoppingCart->getPositions()) != null)
		{
			foreach ($products as $product)
			{
				$arrayProducts[] = array(
					'id'=>$product->id,
					'title'=>$product->title,
					'price'=>$product->price,
					'quantity'=>$product->getQuantity(),
					'sumPrice'=>$product->getSumPrice(),
				);
			}
		}
		
		return $arrayProducts;
	}
	
	public static function updateBasket($id, $count)
	{
		$productModel = Yii::app()->shoppingCart->itemAt($id);
		Yii::app()->shoppingCart->update($productModel, $count);
	}
	
	public static function addVisit($model, $count=1)
	{
		$model->visit += $count;
		return $model->save(true);
	}
	
	public static function generateKeywordsFromTitle($title)
	{
		$title = Text::generateSeoUrlPersian($title);
		
		$keywords = explode('-', $title);
		
		$generateKeyword = null;
		foreach($keywords as $keyword)
		{
			if(in_array($keyword, array('را','و','از','با','در','به','بر','که','تا','یا',))) continue;
			if(in_array($keyword, array('این','آن','ها','های','دیگر','دیگه','پیش','پس','قبل','بعد','برخی','هنگام','آنها','ی','ای','‌ای','هر','برای',))) continue;

			if (@preg_match("/^[0-9]+$/is", $keyword) == false) {
				$generateKeywords[] = $keyword;
			}
		}
		
		return implode(',', $generateKeywords);
	}
	
	public static function getProductDetail($productId) {
		$model = Product::model()->findByPk($productId);
		if($model) {
			return $model;
		}
			
		return null;
	}
	
	public function dataProviderRelatedProducts($model)
	{
		$criteria = new CDbCriteria;

		$criteria->addSearchCondition('t.title', 			$model->title);
		$criteria->addSearchCondition('t.shortDescription', $model->shortDescription, true, 'OR');
		//$criteria->addSearchCondition('t.description', 		$model->description, true, 'OR');
		
		$criteria->compare('t.id', '<>'.$model->id);
		$criteria->compare('t.status', 'active');
		
		$criteria->order = 'RAND()';
		$criteria->limit = 4;
		$criteria->together = true;
		$criteria->with[] = 'photo';
		$criteria->with[] = 'user';

		$productsDataProvider = new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>4,
		    ),
		));
		
		return $productsDataProvider;
	}

	public function setTags($currentTags, $productId, $oldTags=array())
	{
		$criteria = new CDbCriteria();
		$criteria->addInCondition('name', $currentTags);
		
		$tagModels = Tag::model()->findAll($criteria);
		$existTags = CHtml::listData($tagModels, 'id', 'name');
		
		$notExistTags = array_diff((array)$currentTags, $existTags);
		foreach ($notExistTags as $newTag)
		{
			$tagModel = new Tag();
			$tagModel->name = $newTag;
			$tagModel->save();
			
			$existTags[$tagModel->id] = $tagModel->name;
		}

		//add tag to product2tag
		if($oldTags) {
			$existTags = array_diff($existTags, $oldTags);
		}
		
		foreach ($existTags as $id => $name)
		{
			$product2tagModel = new Product2tag();
			$product2tagModel->productId = $productId;
			$product2tagModel->tagId = $id;
			$product2tagModel->save();
		}
		
		//remove tag from product2tag
		if($oldTags)
		{
			$exteraTags = array_diff($oldTags, $currentTags);

			$criteria = new CDbCriteria();
			$criteria->addInCondition('tagId', array_keys($exteraTags));
			$criteria->compare('productId', $productId);
			Product2tag::model()->deleteAll($criteria);
		}
		
		return true;
	}

	public function setCategories($currentCategories, $productId, $oldCategories=array())
	{
		foreach (Subcategory::model()->with(array('category'))->findAll() as $subcategory) {
			$list[$subcategory->category->name.' - '.$subcategory->name] = $subcategory->id;
		}

		foreach($currentCategories as $i=>$currentCategory) {
			$currentCategories[$i] = $list[$currentCategory];
		}
		$oldCategories = array_keys($oldCategories);

		// add subcategory to product2subcaterory
		$existCategories = array_diff($currentCategories, $oldCategories);
		foreach ($existCategories as $id)
		{
			$product2subcateroryModel = new Product2subcategory();
			$product2subcateroryModel->productId = $productId;
			$product2subcateroryModel->subcategoryId = $id;
			$product2subcateroryModel->save();
		}

		//remove subcategories from product2subcategory
		$exteraCategories = array_diff($oldCategories, $currentCategories);
		if($exteraCategories)
		{
			$criteria = new CDbCriteria();
			$criteria->addInCondition('subcategoryId', $exteraCategories);
			$criteria->compare('productId', $productId);
			Product2subcategory::model()->deleteAll($criteria);
		}
		return true;
	}
	
	
	public function getProductStatusReasonId($viewModel=null, &$productModel) {
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $viewModel->id);
		
		$productModel = Product::model()->find($criteria);
		if(!$productModel) {
			return null;
		}
		
		if($viewModel !== null) {
			$viewModel->attributes 	= $productModel->attributes;
		}
		
		return $viewModel;
	}
	
	public function statusReason($viewModel, $productModel)
	{
		$productModel->attributes = $viewModel->attributes;
		return $productModel->save();
	}
}
?>