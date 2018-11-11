	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'page-form',
	    'type'=>'horizontal',
		//'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<p class="help-block"><?php echo Yii::t('main', 'Fields with {*} are required.', array('{*}'=>'<span class="required">*</span>')); ?></p>

	<?php echo $form->errorSummary($pageViewModel); ?>

	<?php echo $form->textFieldRow($pageViewModel,'title',array('id'=>'page-title')); ?>
	<?php if($pageViewModel->type != 'system') echo $form->textFieldRow($pageViewModel,'key',array('id'=>'page-key')); ?>
	

	<div class="control-group">
		<?php echo $form->labelEx($pageViewModel, 'context', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
				'model'=>$pageViewModel,
				'attribute'=>'context',
				'autoLanguage' => false,
				'width' => '100%',
				'toolbar'=>array(
					array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat', '-', 'Link', 'Unlink', ),
					array('Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar'),
					array('Font', 'FontSize', 'TextColor', 'BGColor',)
				),
			));
			?>
		</div>
	</div>

	<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>Yii::t('form', 'Save'),
		'buttonType'=>'submit',
	));  ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
$("#page-title").keyup(function() {
	$("#page-key").val($(this).val().replace(/[^\u0622-\u063A\u0641-\u064A\u0660-\u0669\u067E\u0686\u0698\u06CC\u06F0-\u06F90-9A-Za-z]+/g, '-').replace(/^-/g, '').replace(/-$/g, ''));
});
</script>