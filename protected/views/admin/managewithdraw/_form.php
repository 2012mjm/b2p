<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'withdraw-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'userId',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'credit',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'requestDate',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>8)); ?>
	
	<?php echo $form->dropDownListRow($model,'status', ZHtml::enumItem($withdrawModel, 'status')); ?>

	<?php echo $form->textFieldRow($model,'rejectReason',array('class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
