<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('category', 'Manage Categories'), 'url'=>array('index')),
    array('label'=>Yii::t('category', 'Create Category'), 'url'=>array('create')), 
	array('label'=>Yii::t('category', 'Delete Category'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('category', 'Update Category'); echo ' #'.$model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>