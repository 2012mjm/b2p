<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
)); ?>

    <?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>45)); ?>

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

    <?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>8)); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>Yii::t('form', 'Search'), 
        )); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->