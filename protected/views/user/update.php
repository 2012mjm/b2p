<?php
/* @var $this UserController */
/* @var $viewModel User */
/* @var $form CActiveForm */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('user', 'Edit profile');
?>

<h1><?php echo yii::t('user', 'Edit profile'); ?></h1>
<br>

<div class="row-fluid">
	<div class="span9">
		<div class="form">
		
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'update-form',
		    'type'=>'horizontal',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
		
			<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>
		
			<?php echo $form->errorSummary($viewModel); ?>
		
			<?php echo $form->textFieldRow($viewModel,'firstname'); ?>
		
			<?php echo $form->textFieldRow($viewModel,'lastname'); ?>
		
			<?php echo $form->textFieldRow($viewModel,'email'); ?>
		
			<?php echo $form->dropDownListRow($viewModel,'gender', ZHtml::enumItem($userModel, 'gender'), array('empty' => '')); ?>
		
			<?php echo $form->textFieldRow($viewModel,'birthday'); ?>
			<?php 
				$this->widget('application.widgets.JalaliDatePicker.JalaliDatePicker', array(
					'textField'=>'birthday',
					'model'=>$viewModel,
					'options'=>array(
						'changeMonth'=>'true',
						'changeYear'=>'true',
						'yearRange' => (date('Y')-621-70).':'.(date('Y')-621),
						'dateFormat'=>'yy-mm-dd',
					)
				));		
			?>
		
			<?php echo $form->textFieldRow($viewModel,'fieldStudy'); ?>

			<?php echo $form->textFieldRow($viewModel,'phone'); ?>
		
			<?php echo $form->textFieldRow($viewModel,'mobile'); ?>
		
			<?php echo $form->dropDownListRow($viewModel,'bankName', ZHtml::enumItem($userModel, 'bankName'), array('empty' => '')); ?>
		
			<?php echo $form->textFieldRow($viewModel,'bankAccountNumber'); ?>
		
			<?php echo $form->textFieldRow($viewModel,'bankCardNumber'); ?>
			
			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
		            'buttonType'=>'submit',
		            'type'=>'primary',
		            'label'=>yii::t('form', 'Save'),
		        ));
		        ?>
		        <?php $this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>Yii::t('form', 'Cancel'),
					'url'=>array('/user/profile'),
				    'type'=>'danger',
				)); ?>
			</div>
		
		<?php $this->endWidget(); ?>
		
		</div><!-- form -->
	</div>
	<?php $this->renderPartial('//user/_menu'); ?>
</div>