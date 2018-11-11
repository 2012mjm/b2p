<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'Contact Us');
$this->breadcrumbs=array(
	yii::t('main', 'Contact Us'),
);
?>

<h1><?php echo yii::t('main', 'Contact Us'); ?></h1>
<br />

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'name'); ?>
	
	<?php echo $form->textFieldRow($model,'email'); ?>
	
	<?php echo $form->textFieldRow($model,'subject'); ?>
	
	<?php echo $form->textAreaRow($model,'body'); ?>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="control-group ">
		<?php echo $form->labelEx($model,'verifyCode', array('class'=>'control-label required')); ?>
		<div class="controls">
			<?php $this->widget('CCaptcha'); ?>
			<br />
			<?php echo $form->textField($model,'verifyCode'); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>yii::t('contact', 'Send'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>Yii::t('form', 'Cancel'),
			'url'=>Yii::app()->homeUrl,
		    'type'=>'danger',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->