<?php
class TagService
{
	/**
	 * get tag name with id
	 */
	public static function getNameWithId($id)
	{
		$model = Tag::model()->findByPk($id);
		if($model) {
			return $model->name;
		} else {
			return null;
		}
	}
	

	/**
	 * get tags
	 */
	public static function getTopArrayListTags()
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->with[] = 'product2tags';
		$criteria->select = 'COUNT(t.id) AS count, *';
		$criteria->group = 't.id';
		$criteria->having = 'product2tags.id IS NOT NULL';
		$criteria->order = 'count DESC';
		$criteria->limit = 5;
		$model = Tag::model()->findAll($criteria);
		return $model;
	}
}
?>