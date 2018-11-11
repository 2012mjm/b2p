<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage user',
);

$this->menu=array(
	array('label'=>Yii::t('user', 'Manage Users'), 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('user', 'Manage Users'); ?></h1>

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

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped',
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'enableHistory'=>true,
    'enablePagination' => true,
	'pager'=> array(
        'class'=>'bootstrap.widgets.TbPager',
		'nextPageLabel'=>'&larr;',
		'prevPageLabel'=>'&rarr;',
    ),
	'ajaxUpdate'=>'flash',
	'afterAjaxUpdate'=>'js:function() { flash(); }',
	'selectableRows' => 2,
	'columns'=>array(
		array(
            'id' => 'selected-ids',
            'class' => 'CCheckBoxColumn'
        ),
		'id',
		'username',
		'email',
		array(
			'name'=>'gender',
			'value'=>'Yii::t("enumItem", $data->gender)',
			'filter'=>ZHtml::enumItem($model, 'gender'),
		),
		'registrationDate',
		array(
			'name'=>'status',
			'value'=>'Yii::t("enumItem", $data->status)',
			'filter'=>ZHtml::enumItem($model, 'status'),
		),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        	'template'=>'{ticket} {view} {update} {delete}',
        	'buttons' => array(
				'ticket' => array(
					'url'=>'array("/admin/manageticket/create", "uid"=>$data->id)',
        			'icon'=>'comment',
					'visible'=>'($data->id == 1) ? false : true',
       			),
       		)
        ),
	),
)); ?>


<?php
	echo CHtml::ajaxButton(Yii::t('form', 'Delete selected datas'), array('deletes'),
		array(
			'type'=>'POST',
			'data'=>'js:{selectedIds : $.fn.yiiGridView.getChecked("user-grid","selected-ids").toString()}',
        	'success'=>'function() { $.fn.yiiGridView.update("user-grid"); }',
		),
		array('confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))
	);

	echo CHtml::dropDownList('status', '', 
		array(''=>Yii::t('user', 'Status')) + ZHtml::enumItem($model, 'status'),
		array(
			'ajax'=>array(
				'type'=>'POST',
				'url'=>array('statuses'),
				'data'=>'js:{selectedIds : $.fn.yiiGridView.getChecked("user-grid","selected-ids").toString(), selectedStatus : $(this).val()}',
	        	'success'=>'function() { 
	        		$.fn.yiiGridView.update("user-grid");
	        		$("#statuses").val("");
	        	}',
			),
			'id'=>'statuses',
		)
	);
?>