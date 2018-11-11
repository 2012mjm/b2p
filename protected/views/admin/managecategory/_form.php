<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'category-form',
    'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div> 

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('form', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->