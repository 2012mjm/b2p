<?php
$this->menu=array(
	array('label'=>'Manage Report','url'=>array('index')),
);
?>

<h1>View Report #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		array(
			'name'=>'user.username',
			'label'=>Yii::t("user", "Username"),
		),
		array(
			'name'=>'product.title',
			'value'=>CHtml::link($model->product->title, array("/product/view", "id"=>$model->productId, "title"=>Text::generateSeoUrlPersian($model->product->title))),
			'label'=>Yii::t("product", "Product Title"),
			'type'=>'raw',
		),
		array(
			'name'=>'orderId',
			'value'=>CHtml::link($model->orderId, array("/admin/manageOrder/view", "id"=>$model->orderId)),
			'label'=>Yii::t("order", "Order Id"),
			'type'=>'raw',
		),
		//'type',
        array(
        	'name'=>'creationDate',
        	'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
        ),
		array(
			'name'=>'orderId',
			'value'=>CHtml::link($model->orderId, array("/admin/manageOrder/view", "id"=>$model->orderId)),
			'label'=>Yii::t("order", "Order Id"),
			'type'=>'raw',
		),
		array(
			'name'=>'answer',
			'value'=>nl2br($model->answer),
			'label'=>Yii::t("order", "Order Id"),
			'type'=>'raw',
		),
		'',
	),
)); ?>

<hr>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'order-report-form',
	    'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<?php echo $form->errorSummary($viewModelReport); ?>

		<?php echo $form->textAreaRow($viewModelReport, 'answer', array('class'=>'span5', 'rows'=>7)); ?>

		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'type'=>'primary',
				'label'=>'ارسال',
				'buttonType'=>'submit',
				'size'=>'large',
			));  ?>
		</div>
	
	<?php $this->endWidget(); ?>
