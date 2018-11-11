<?php
class SubcategoryService
{		
	/**
	 * get products
	 */
	public static function getArrayListSubcategories()
	{
		$model = Subcategory::model()->findAll();
		if($model)
		{
			foreach ($model as $value) {
				$arr[$value->id] = $value->name;
			}
		}
		
		return $arr;
	}
	
	/**
	 * get subcategory with id
	 */
	public function getSubcategoryId($id, $viewModel=null)
	{
		$model = Subcategory::model()->findByPk($id);
		
		if($viewModel !== null) {
			$viewModel->attributes = $model->attributes;
			return $viewModel;
		}
		else {
			return $model;
		}
	}
	
	public static function subcategoryList()
	{
		$models = Category::model()->with('subcategories')->findAll();
		if($models != null)
		{
			foreach ($models as $model)
			{
				foreach ($model->subcategories as $subcategories)
				{
					$returnValue[$model->id][$subcategories->id] = $subcategories->name;
				}
			}
			
			return $returnValue;
		}
		
		return false;
	}
	
	/**
	 * get subcategory name with id
	 */
	public static function getSubcategoryNameWithId($id)
	{
		if($id != 0) {
			$model = Subcategory::model()->findByPk($id);
		} else {
			$model = null;
		}

		if($model) {
			return $model->name;
		} else {
			return null;
		}
	}
	
	/**
	 * Update Subcategory
	 */
	public function update($viewModel) {
		
		$subcategoryModel = new Subcategory();
		
		$subcategoryModel->attributes = $viewModel->attributes;
		$subcategoryModel->id = $viewModel->id;
		
		$subcategoryModel->setIsNewRecord(false);
		return $subcategoryModel->save($subcategoryModel);
	}
	
	/**
	 * Create Subcategory
	 */
	public function create($viewModel) {
		
		$subcategoryModel = new Subcategory();
		$subcategoryModel->attributes = $viewModel->attributes;
		
		$subcategoryModel->setIsNewRecord(true);
		return $subcategoryModel->save($subcategoryModel);
	}
	
	/**
	 * Delete Subcategory
	 */
	public function delete($id)
	{
		$model = Subcategory::model()->findByPk($id);
		if($model != null) {
			return $model->delete();
		}
		
		return false;
	}

	/**
	 * Delete Subcategorys
	 * @param array $items
	 * example: array('2', '5')
	 */
	public function deletes($items)
	{
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $items);
		return Subcategory::model()->deleteAll($criteria);
	}
}
?>