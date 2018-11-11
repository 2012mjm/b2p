<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage category',
);

$this->menu=array(
	array('label'=>Yii::t('category', 'Manage Categories'), 'url'=>array('index')),
    array('label'=>Yii::t('category', 'Create Category'), 'url'=>array('create')), 
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('category', 'Manage Categories'); ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link(Yii::t('form', 'Advanced Search'), '#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'enableHistory'=>true,
	'ajaxUpdate'=>'flash',
	'afterAjaxUpdate'=>'js:function() { flash(); }',
	'selectableRows' => 2,
	'columns'=>array(
		array(
            'id' => 'selected-ids',
            'class' => 'CCheckBoxColumn'
        ),
		'id',
		'name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>


<?php
	echo CHtml::ajaxButton(Yii::t('form', 'Delete selected datas'), array('deletes'),
		array(
			'type'=>'POST',
			'data'=>'js:{selectedIds : $.fn.yiiGridView.getChecked("category-grid","selected-ids").toString()}',
        	'success'=>'function() { $.fn.yiiGridView.update("category-grid"); }',
		),
		array('confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))
	);
?>