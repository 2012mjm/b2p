<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('product', 'Manage Products'), 'url'=>array('index')),
	array('label'=>Yii::t('product', 'Update Product'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('product', 'Delete Product'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1>ID #<?php echo $model->id; ?></h1>

<?php if(!empty($model->statusReason)) echo '<br><div class="alert alert-warning" role="alert"><strong style="color:red">یادداشت مدیر:</strong> '.$model->statusReason.'</div><br>'; ?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		array(
			'name'=>'categoryId',
			'value'=>$model->subcategory->category->name
		),
		array(
			'name'=>'subcategoryId',
			'value'=>$model->subcategory->name
		),
		'shortDescription',
		'description',
        array(
        	'name'=>'price',
        	'value'=>Yii::app()->format->formatPrice($model->price),
        	'type'=>'raw'
        ),
		'visit',
		'countSell',
		array(
			'name'=>'creationDate',
			'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
		),
		array(
			'name'=>'updateDate',
			'value'=>($model->updateDate == '0000-00-00 00:00:00' OR $model->updateDate == null) ? '[ویرایش نشده]' : Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->updateDate)),
		),
		array(
			'name'=>'status',
			'value'=>Yii::t('enumItem', $model->status),
		),
		array(
			'name'=>'photoId',
			'value'=>($model->photo) ? CHtml::link(CHtml::image(Yii::app()->baseUrl.$model->photo->filePath.'t_'.$model->photo->fileName, null, array('style'=>'max-height: 100px')), Yii::app()->baseUrl.$model->photo->filePath.$model->photo->fileName) : null,
			'type'=>'raw',
		),
		array(
			'name'=>'demoFileId',
			'value'=>($model->demoFile) ? CHtml::link(Yii::t('product', 'Download current file'), Yii::app()->baseUrl.$model->demoFile->filePath.$model->demoFile->fileName) : null,
			'type'=>'raw',
		),
		array(
			'name'=>'projehFileId',
			'value'=>($model->projehFile) ? CHtml::link(Yii::t('product', 'Download current file'), Yii::app()->baseUrl.$model->projehFile->filePath.$model->projehFile->fileName) : null,
			'type'=>'raw',
		),
	),
)); ?>
