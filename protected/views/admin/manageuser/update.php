<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('user', 'Manage Users'), 'url'=>array('index')),
	array('label'=>Yii::t('user', 'Delete User'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('user', 'Update User'); echo ' #'.$model->id; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'user-form', 
    'enableAjaxValidation'=>false, 
)); ?>

	<p class="help-block"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>255)); ?>

    <?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->textFieldRow($model,'mobile',array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>6)); ?>

    <?php echo $form->textFieldRow($model,'birthday',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'bankName',array('class'=>'span5','maxlength'=>10)); ?>

    <?php echo $form->textFieldRow($model,'bankAccountNumber',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'bankCardNumber',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'registrationDate',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'lastVisit',array('class'=>'span5')); ?>
    
    <?php echo $form->dropDownListRow($model,'status', ZHtml::enumItem($userModel, 'status'),array('class'=>'span5')); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>Yii::t('form', 'Save'),
        )); ?>
    </div> 

<?php $this->endWidget(); ?>

</div><!-- form -->