<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'Login');
$this->breadcrumbs=array(
	yii::t('main', 'Login'),
);
?>

<h1><?php echo yii::t('user', 'Login Form'); ?></h1>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'username'); ?>
	
	<?php echo $form->passwordFieldRow($model,'password'); ?>

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>yii::t('user', 'Login'),
			'size'=>'large'
        )); ?>
		<?php echo CHtml::link('فراموشی کلمه عبور', array('/user/forgetPassword'), array('style'=>'margin-right: 20px;')) ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
