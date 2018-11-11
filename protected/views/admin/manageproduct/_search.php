<?php
/* @var $this ProductController */ 
/* @var $model Product */ 
/* @var $form CActiveForm */ 
?> 

<div class="wide form"> 

<?php $form=$this->beginWidget('CActiveForm', array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
)); ?>

    <div class="row"> 
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'subcategoryId'); ?>
        <?php echo $form->textField($model,'subcategoryId'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'shortDescription'); ?>
        <?php echo $form->textField($model,'shortDescription',array('size'=>45,'maxlength'=>45)); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'photoId'); ?>
        <?php echo $form->textField($model,'photoId'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'price'); ?>
        <?php echo $form->textField($model,'price'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'visit'); ?>
        <?php echo $form->textField($model,'visit'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'creationDate'); ?>
        <?php echo $form->textField($model,'creationDate'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'updateDate'); ?>
        <?php echo $form->textField($model,'updateDate'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status', ZHtml::enumItem($model, 'status')); ?>
    </div> 

    <div class="row buttons"> 
        <?php echo CHtml::submitButton('Search'); ?>
    </div> 

<?php $this->endWidget(); ?>

</div><!-- search-form -->