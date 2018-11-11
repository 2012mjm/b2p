<?php
/* @var $this SubcategoryController */
/* @var $model Subcategory */

$this->breadcrumbs=array(
	'Subcategories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('subcategory', 'Manage Sub Categories'), 'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('subcategory', 'Create Sub Category'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>