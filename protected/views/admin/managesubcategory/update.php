<?php
/* @var $this SubcategoryController */
/* @var $model Subcategory */

$this->breadcrumbs=array(
	'Subcategories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('subcategory', 'Manage Sub Categories'), 'url'=>array('index')),
    array('label'=>Yii::t('subcategory', 'Create Sub Category'), 'url'=>array('create')), 
	array('label'=>Yii::t('subcategory', 'Delete Sub Category'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('subcategory', 'Update Sub Category'); echo ' #'.$model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>