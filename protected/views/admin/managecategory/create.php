<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('category', 'Manage Categories'), 'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('category', 'Create Category'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>