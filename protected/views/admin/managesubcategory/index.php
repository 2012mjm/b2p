<?php
/* @var $this SubcategoryController */
/* @var $model Subcategory */

$this->breadcrumbs=array(
	'Subcategories'=>array('index'),
	'Manage Sub Category',
);

$this->menu=array(
	array('label'=>Yii::t('subcategory', 'Manage Sub Categories'), 'url'=>array('index')),
    array('label'=>Yii::t('subcategory', 'Create Sub Category'), 'url'=>array('create')), 
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subcategory-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('subcategory', 'Manage Sub Categories'); ?></h1>

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
	'id'=>'subcategory-grid',
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
        array(
        	'name'=>'categoryId',
        	'value'=>'$data->category->name',
        ),
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
			'data'=>'js:{selectedIds : $.fn.yiiGridView.getChecked("subcategory-grid","selected-ids").toString()}',
        	'success'=>'function() { $.fn.yiiGridView.update("subcategory-grid"); }',
		),
		array('confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))
	);
?>