<?php
/* @var $this ProductController */
/* @var $viewModel Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$viewModel->id=>array('view','id'=>$viewModel->id),
	'Status Reason',
);

$this->menu=array(
	array('label'=>Yii::t('product', 'Manage Products'), 'url'=>array('index')),
    array('label'=>Yii::t('product', 'Create Product'), 'url'=>array('create')), 
    array('label'=>Yii::t('product', 'Update Product'), 'url'=>array('update', 'id'=>$viewModel->id)), 
	array('label'=>Yii::t('product', 'Delete Product'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$viewModel->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('product', 'Status Reason'); echo ' برای پروژه #'.$viewModel->id; ?></h1>
<br>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'status-reason-product-form',
	    'type'=>'horizontal',
		//'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	)); ?>

	<?php echo $form->textAreaRow($viewModel,'statusReason', array('class'=>'span7', 'rows'=>2)); ?>
	
	<?php echo $form->checkBoxRow($viewModel, 'reasonOnlyShowAdmin', array('value'=>'1')); ?>

	<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>Yii::t('form', 'Save'),
		'buttonType'=>'submit',
	));  ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>Yii::t('form', 'Cancel'),
		'url'=>array('/admin/manageProduct/index'),
		'type'=>'danger',
	)); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->