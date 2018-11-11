<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('product', 'Manage Products'), 'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('product', 'Create Product'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'productModel'=>$productModel)); ?>