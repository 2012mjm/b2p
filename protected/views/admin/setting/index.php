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


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'setting-form', 
    'enableAjaxValidation'=>false, 
)); ?>

    <p class="help-block"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'siteName',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textFieldRow($model,'adminName',array('class'=>'span5','maxlength'=>30)); ?>

    <?php echo $form->textFieldRow($model,'adminEmail',array('class'=>'span5','maxlength'=>128)); ?>

    <?php echo $form->textFieldRow($model,'adminPhone',array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->textFieldRow($model,'siteDescription',array('class'=>'span5','maxlength'=>255)); ?>

    <?php echo $form->textFieldRow($model,'siteKeywords',array('class'=>'span5','maxlength'=>255)); ?>

    <?php echo $form->textFieldRow($model,'siteAddress',array('class'=>'span5','maxlength'=>128)); ?>

    <?php echo $form->textFieldRow($model,'siteSmallAddress',array('class'=>'span5','maxlength'=>128)); ?>

    <?php echo $form->textFieldRow($model,'siteLanguage',array('class'=>'span5','maxlength'=>10)); ?>

    <?php echo $form->textFieldRow($model,'siteDefaultTheme',array('class'=>'span5','maxlength'=>30)); ?>

    <?php echo $form->textFieldRow($model,'siteTimeZone',array('class'=>'span5','maxlength'=>15)); ?>

    <?php echo $form->textFieldRow($model,'siteCookiePrefix',array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->textFieldRow($model,'siteCharset',array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->textFieldRow($model,'minPrice',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'comission',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'parsPalMerchantID',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textFieldRow($model,'parsPalPassword',array('class'=>'span5','maxlength'=>45)); ?>
    
    <?php echo $form->textFieldRow($model,'zarinPalMerchantID',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textFieldRow($model,'yahooID',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'facebookPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'twitterPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'instagaramPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'googlePlusPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'youtubePageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'cloobPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'aparatPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'lenzorPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'facenamaPageUrl',array('class'=>'span5')); ?>

    <?php echo $form->textAreaRow($model,'bulletin',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
    
    <p>
    	<br>
    	- برای درخواست های کمتر از <?php echo $form->textField($model,'lowWithdraw',array('class'=>'span1')); ?> تومان، مبلغ <?php echo $form->textField($model,'lowWithdrawBankComission',array('class'=>'span1')); ?> تومان کارمزد تعلق می گیرد.
    </p>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>Yii::t('form', 'Save'), 
        )); ?>
    </div> 

<?php $this->endWidget(); ?>

</div><!-- form -->