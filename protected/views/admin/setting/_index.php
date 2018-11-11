<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'Setting'=>array('index'),
	'Manage Setting',
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'siteName'); ?>
		<?php echo $form->textField($model,'siteName'); ?>
		<?php echo $form->error($model,'siteName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adminName'); ?>
		<?php echo $form->textField($model,'adminName'); ?>
		<?php echo $form->error($model,'adminName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adminEmail'); ?>
		<?php echo $form->textField($model,'adminEmail'); ?>
		<?php echo $form->error($model,'adminEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteDescription'); ?>
		<?php echo $form->textField($model,'siteDescription'); ?>
		<?php echo $form->error($model,'siteDescription'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteKeywords'); ?>
		<?php echo $form->textField($model,'siteKeywords'); ?>
		<?php echo $form->error($model,'siteKeywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteAddress'); ?>
		<?php echo $form->textField($model,'siteAddress'); ?>
		<?php echo $form->error($model,'siteAddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteSmallAddress'); ?>
		<?php echo $form->textField($model,'siteSmallAddress'); ?>
		<?php echo $form->error($model,'siteSmallAddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteLanguage'); ?>
		<?php echo $form->textField($model,'siteLanguage'); ?>
		<?php echo $form->error($model,'siteLanguage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteDefaultTheme'); ?>
		<?php echo $form->textField($model,'siteDefaultTheme'); ?>
		<?php echo $form->error($model,'siteDefaultTheme'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteTimeZone'); ?>
		<?php echo $form->textField($model,'siteTimeZone'); ?>
		<?php echo $form->error($model,'siteTimeZone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteCookiePrefix'); ?>
		<?php echo $form->textField($model,'siteCookiePrefix'); ?>
		<?php echo $form->error($model,'siteCookiePrefix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteCharset'); ?>
		<?php echo $form->textField($model,'siteCharset'); ?>
		<?php echo $form->error($model,'siteCharset'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('form', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->