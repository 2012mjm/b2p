<h1>View Log #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'ip',
		),
		array(
			'name'=>'user.username',
			'label'=>Yii::t("user", "Username"),
		),
		array(
			'name'=>'title',
		),
		array(
			'name'=>'description',
		),
        array(
        	'name'=>'creationDate',
        	'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
        ),
		array(
			'label'=>Yii::t("user", "Link"),
			'value'=>($model->pageRoute) ? CHtml::link(Yii::app()->createAbsoluteUrl($model->pageRoute, CJSON::decode($model->pageParams)), Yii::app()->createUrl($model->pageRoute, CJSON::decode($model->pageParams))) : '-',
			'type'=>'raw'
		),
	),
)); ?>
