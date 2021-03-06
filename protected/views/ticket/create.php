<?php
$this->siteTitle=Yii::app()->name . ' - '.yii::t('ticket', 'Create Ticket');
?>

<h1><?php echo yii::t('ticket', 'Create Ticket'); ?></h1>
<br>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'create-ticket-form',
	    'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($viewModel); ?>

	<?php echo $form->textFieldRow($viewModel,'title', array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($viewModel,'description', array('class'=>'span5', 'rows'=>7)); ?>

	<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>Yii::t('form', 'Save'),
		'buttonType'=>'submit',
	));  ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>Yii::t('form', 'Cancel'),
		'url'=>array('/ticket/index'),
		'type'=>'danger',
	)); ?>
	</div>
<?php $this->endWidget(); ?>
</div>