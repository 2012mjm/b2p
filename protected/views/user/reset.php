<?php
/* @var $this UserController */
/* @var $viewModel User */
/* @var $form CActiveForm */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('user', 'تغییر کلمه عبور');
?>

<h1><?php echo yii::t('user', 'تغییر کلمه عبور'); ?></h1>

	<div class="form">
		
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'reset-password-form',
		    'type'=>'horizontal',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
		
			<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>
		
			<?php echo $form->errorSummary($viewModel); ?>
		
			<?php echo $form->passwordFieldRow($viewModel,'password'); ?>
		
			<?php echo $form->passwordFieldRow($viewModel,'verifyPassword'); ?>

			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
		            'buttonType'=>'submit',
		            'type'=>'primary',
		            'label'=>yii::t('form', 'Save'),
		        ));
		        ?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>Yii::t('form', 'Cancel'),
					'url'=>array('/main/index'),
					'type'=>'danger',
				)); ?>
			</div>
		
		<?php $this->endWidget(); ?>
		
	</div><!-- form -->