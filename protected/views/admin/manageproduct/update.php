<?php
/* @var $this ProductController */
/* @var $viewModel Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$viewModel->id=>array('view','id'=>$viewModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('product', 'Manage Products'), 'url'=>array('index')),
    array('label'=>Yii::t('product', 'Create Product'), 'url'=>array('create')), 
	array('label'=>Yii::t('product', 'Delete Product'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$viewModel->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('product', 'Update Product'); echo ' #'.$viewModel->id; ?></h1>

<?php echo $this->renderPartial('_form', array('viewModel'=>$viewModel, 'productModel'=>$productModel, 'new'=>false)); ?>