<?php
/* @var $this SubcategoryController */
/* @var $model Subcategory */

$this->breadcrumbs=array(
	'Subcategories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('subcategory', 'Manage Sub Categories'), 'url'=>array('index')),
	array('label'=>Yii::t('subcategory', 'Update Sub Category'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('subcategory', 'Delete Sub Category'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1>ID #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		array(
			'name'=>'categoryId',
			'value'=>$model->category->name
		),
        'name',
    ),
)); ?> 
