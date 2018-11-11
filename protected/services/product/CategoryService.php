<?php
class CategoryService
{		
	/**
	 * get categories
	 */
	public static function getArrayListCategories()
	{	
		$model = Category::model()->with('subcategories')->findAll();
		return $model;
	}
	
	/**
	 * get categories
	 */
	public static function getArrayListCategoriesAdmin()
	{
		$model = Category::model()->findAll();
		if($model)
		{
			foreach ($model as $value) {
				$arr[$value->id] = $value->name;
			}
		}
		
		return $arr;
	}
	
	public static function getCategoriesList()
	{
		$models = Category::model()->findAll();
		if($models != null)
		{
			// format models resulting using listData
			return CHtml::listData($models, 'id', 'name');
		}
		
		return array();
	}
	
	/**
	 * get category with id
	 */
	public function getCategoryId($id, $viewModel=null)
	{
		$model = Category::model()->findByPk($id);
		
		if($viewModel !== null) {
			$viewModel->attributes = $model->attributes;
			return $viewModel;
		}
		else {
			return $model;
		}
	}
	
	/**
	 * get category name with id
	 */
	public static function getCategoryNameWithId($id)
	{
		$model = Category::model()->findByPk($id);
		if($model) {
			return $model->name;
		} else {
			return null;
		}
	}
	
	/**
	 * Update Category
	 */
	public function update($viewModel) {
		
		$categoryModel = new Category();
		
		$categoryModel->attributes = $viewModel->attributes;
		$categoryModel->id = $viewModel->id;
		
		$categoryModel->setIsNewRecord(false);
		return $categoryModel->save($categoryModel);
	}
	
	/**
	 * Create Category
	 */
	public function create($viewModel) {
		
		$categoryModel = new Category();
		$categoryModel->attributes = $viewModel->attributes;
		
		$categoryModel->setIsNewRecord(true);
		return $categoryModel->save($categoryModel);
	}
	
	/**
	 * Delete Category
	 */
	public function delete($id)
	{
		$model = Category::model()->findByPk($id);
		if($model != null) {
			return $model->delete();
		}
		
		return false;
	}

	/**
	 * Delete Categorys
	 * @param array $items
	 * example: array('2', '5')
	 */
	public function deletes($items)
	{
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $items);
		return Category::model()->deleteAll($criteria);
	}
}
?>