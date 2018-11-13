<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'Signup');
$this->breadcrumbs=array(
	yii::t('main', 'Signup'),
);

// include js file
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/user.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/provinceCity.js');
?>

<h1><?php echo yii::t('user', 'Signup Form'); ?></h1>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'signup-form',
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

	<?php echo $form->passwordFieldRow($model,'verifyPassword'); ?>

	<?php echo $form->textFieldRow($model,'email', array('hint' => 'لطفا در وارد کردن پست الکترونیکی دقت فرمایید، پست الکترونیکی نیاز به فعال سازی دارد.')); ?>

	<?php echo $form->dropDownListRow($model,'gender', ZHtml::enumItem($userModel, 'gender'), array('empty' => '')); ?>

	<?php echo $form->textFieldRow($model,'birthday'); ?>
	<?php 
		$this->widget('application.widgets.JalaliDatePicker.JalaliDatePicker', array(
			'textField'=>'birthday',
			'model'=>$model,
			'options'=>array(
				'changeMonth'=>'true',
				'changeYear'=>'true',
				'yearRange' => (date('Y')-621-70).':'.(date('Y')-621),
				'dateFormat'=>'yy-mm-dd',
			)
		));		
	?>

	<?php echo $form->textFieldRow($model,'fieldStudy'); ?>
	
	<hr>
	<blockquote>
		<small>در صورتی که قصد فروش فایل‌های خود را دارید، در تکمیل فیلد‌های زیر دقت فرمائید.</small>
	</blockquote>
	<?php echo $form->dropDownListRow($model,'bankName', ZHtml::enumItem($userModel, 'bankName'), array('empty' => '')); ?>

	<?php echo $form->textFieldRow($model,'bankAccountNumber'); ?>

	<?php echo $form->textFieldRow($model,'bankCardNumber'); ?>

	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>yii::t('user', 'Signup'),
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>Yii::t('form', 'Cancel'),
			'url'=>Yii::app()->homeUrl,
		    'type'=>'danger',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->