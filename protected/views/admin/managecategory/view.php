<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('category', 'Manage Categories'), 'url'=>array('index')),
	array('label'=>Yii::t('category', 'Update Category'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('category', 'Delete Category'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1>ID #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'name',
    ),
)); ?> 
