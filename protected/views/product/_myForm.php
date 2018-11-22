<?php 
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/select2.min.js');
// Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/category.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/projehFile.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/demoFile.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/photoFile.js');

Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/select2.min.css');

Yii::app()->getClientScript()->registerScript('select_tag', '
	$(document).ready(function()
	{
		var testData = [{id:0, text:"test1"}, {id:1, text:"test2"}, {id:2, text:"test3"}];
		
		function formatRepo(repo)
		{
			if (repo.loading) return repo.text;

			var markup = "<div class=\"clearfix\">" + repo.text;
		
			if(repo.count != 0) {
				markup += " ( " + repo.count + " بار استفاده شده )";
			}
		
			markup += "</div>";

			return markup;
		}
		
		function formatRepoSelection(repo) {
			return repo.text;
		}

		$(".tags").select2({
			//data: {results: testData, text:"text"}},
			tags: true,
			tokenSeparators: [","],
			ajax : {
				url : "'. Yii::app()->createUrl('/product/ajaxTag') .'",
				dataType : "json",
				delay : 250,
				data : function(params) {
					return {
						q : params.term, // search term
						page : params.page
					};
				},
				processResults : function(data, page) {
					// parse the results into the format expected by Select2.
					// since we are using custom formatting functions we do not need to
					// alter the remote JSON data
					return {
						results : data.items
					};
				},
				cache : true
			},
			escapeMarkup : function(markup) { return markup; }, // let our custom formatter work
			minimumInputLength : 2,
			templateResult : formatRepo, // omitted for brevity, see the source of
			templateSelection : formatRepoSelection,
			language: {
      			inputTooShort: function () { return "حداقل دو حرف برای جستجو وارد کنید."; },
				searching: function (){ return "در حال جستجو…" },
				maximumSelected: function () { return "حداکثر پنج تگ می‌توانید انتخاب نمایید." }
			},
			maximumSelectionLength: 5
		});

		function formatRepoCategory(repo)
		{
			if (repo.loading) return repo.text;
			var markup = "<div class=\"clearfix\">" + repo.text;
			markup += "</div>";
			return markup;
		}
		
		function formatRepoSelectionCategory(repo) {
			return repo.text;
		}

		$(".category").select2({
			ajax : {
				url : "'. Yii::app()->createUrl('/product/ajaxCategory') .'",
				dataType : "json",
				delay : 250,
				data : function(params) {
					return {
						q : params.term, // search term
						page : params.page
					};
				},
				processResults : function(data, page) {
					// parse the results into the format expected by Select2.
					// since we are using custom formatting functions we do not need to
					// alter the remote JSON data
					return {
						results : data.items
					};
				},
				cache : true
			},
			escapeMarkup : function(markup) { return markup; }, // let our custom formatter work
			minimumInputLength : 0,
			templateResult : formatRepoCategory, // omitted for brevity, see the source of
			templateSelection : formatRepoSelectionCategory,
			language: {
      			inputTooShort: function () { return "حداقل دو حرف برای جستجو وارد کنید."; },
				searching: function (){ return "در حال جستجو…" },
				maximumSelected: function () { return "حداکثر سه دسته می‌توانید انتخاب نمایید." }
			},
			placeholder: "دسته مورد نظر را تایپ کنید",
			maximumSelectionLength: 3
		});

		function formatRepoFormat(repo)
		{
			if (repo.loading) return repo.text;
			var markup = "<div class=\"clearfix\">" + repo.text;
			markup += "</div>";
			return markup;
		}
		
		function formatRepoSelectionFormat(repo) {
			return repo.text;
		}

		$(".format").select2({
			escapeMarkup : function(markup) { return markup; }, // let our custom formatter work
			minimumInputLength : 0,
			templateResult : formatRepoFormat, // omitted for brevity, see the source of
			templateSelection : formatRepoSelectionFormat,
		});
	});
');
?>

<style>
.select2-search__field {
	box-shadow: 0 0 0 0 !important;
	border-radius: 0 !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice, 
.select2-container .select2-search--inline {
	float: right !important;
}
.select2-container--default .select2-search--inline .select2-search__field {
	text-align: right !important;
}
.select2-container--default .select2-results > .select2-results__options {
	text-align: right !important;
	direction: rtl !important;
}
</style>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'update-product-form',
	    'type'=>'horizontal',
		//'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	)); ?>

	<p class="note"><?php echo yii::t('form', 'Fields with * are required.', array('*'=>'<span class="required">*</span>')); ?></p>

	<?php echo $form->errorSummary($viewModel); ?>

	<?php echo $form->dropDownListRow($viewModel, 'categories', Text::valueToKey($viewModel->categories), array('class'=>'category span5', 'multiple'=>'multiple')); ?>

	<?php echo $form->textFieldRow($viewModel,'title'); ?>

	<?php echo $form->textAreaRow($viewModel,'shortDescription', array('class'=>'span3', 'rows'=>3)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($viewModel, 'description', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
				'model'=>$viewModel,
				'attribute'=>'description',
				'autoLanguage' => false,
				'width' => '100%',
				'toolbar'=>array(
					array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat', '-', 'Link', 'Unlink', ),
					array('Image', 'Table', 'HorizontalRule', 'SpecialChar'),
					array('FontSize', 'TextColor', 'BGColor',)
				),
			));
			?>
		</div>
	</div>
		
	<?php /*
	<div class="control-group">
		<?php echo $form->labelEx($viewModel, 'description', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
				'model'=>$viewModel,
				'attribute'=>'description',
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
	*/ ?>

	<?php //echo $form->textAreaRow($viewModel,'description', array('class'=>'span5', 'rows'=>10)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($viewModel, 'photo', array('class'=>'control-label')); ?>
		<div class="controls">
			
			<?php if($new OR $viewModel->photoPath == null) : ?>
				<?php echo $form->fileField($viewModel, 'photo'); ?>
			<?php else : ?>
			
				<div id="photo-file-remove">
					<?php echo CHtml::image($viewModel->photoPath, null, array('style'=>'height: 50px')); ?>
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'حذف تصویر جاری یا تغییر آن'),
					    'type'=>'danger',
					    'size'=>'small',
						'htmlOptions'=>array('id'=>'remove-replace-photo-file'),
					)); ?>
				</div>
				<div style="display:none" id="photo-file-add">
					<div id="photo-file-place" style="display: inline;"></div>
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'Dissuasion'),
					    'type'=>'info',
					    'size'=>'small',
						'htmlOptions'=>array('id'=>'dissuasion-photo-file'),
					)); ?>
				</div>
				
				<?php $viewModel->photoFileRemove = '0'; ?>
				<?php echo $form->hiddenField($viewModel, 'photoFileRemove', array('id'=>'photo-hidden-remove')); ?>
				
			<?php endif; ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($viewModel, 'price', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($viewModel, 'price', array('class'=>'my-price-product')); ?>
			<?php echo Yii::t('main', 'Toman'); ?>
			
			<?php if(!empty(Yii::app()->setting->comission) || Yii::app()->setting->comission == '0') : ?>
			<br><br>
			<blockquote>
				<small style="color: blue"><?php echo Yii::t('product', 'Minimum product cost').': <span class="my-min-price-product">'.(Yii::app()->setting->minPrice/10).'</span> '.Yii::t('main', 'Toman'); ?></small>
				<small style="color: blue"><?php echo Yii::t('product', 'Commission sales system product').': <span class="my-comission-product">'.Yii::app()->setting->comission.'</span>%'; ?></small>
				<small style="color: blue"><?php echo Yii::t('product', 'Your income from the sale of the product').': <span class="my-final-product">0</span> '.Yii::t('main', 'Toman'); ?></small>
			</blockquote>
			<?php endif; ?>
		</div>
	</div>

	<?php //echo $form->dropDownListRow($viewModel, 'status', array('active'=>'فعال', 'inactive'=>'غیر فعال')); ?>
	
	<?php echo $form->dropDownListRow($viewModel, 'tags', Text::valueToKey($viewModel->tags), array('class'=>'tags span5', 'multiple'=>'multiple')); ?>

	<hr>

	<?php echo $form->dropDownListRow($viewModel, 'format', Text::valueToKey(array_map('trim', explode(',', Yii::app()->setting->projehFormat))), array('class'=>'format span5', 'multiple'=>'multiple')); ?>
	<div class="control-group">
		<div class="controls">
			<blockquote>
				<small>فرمت فایل‌های موجود درون پروژه خود را انتخاب نمایید.</small>
			</blockquote>
		</div>
	</div>

	<?php echo $form->textFieldRow($viewModel, 'countPage'); ?>

	<div class="control-group">
		<?php echo $form->labelEx($viewModel, 'demoFile', array('class'=>'control-label')); ?>
		<div class="controls">
		
			<?php if($new OR $viewModel->demoFilePath == null) : ?>
				<?php echo $form->fileField($viewModel, 'demoFile'); ?>
			<?php else : ?>

				<div id="demo-file-remove">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'Download current file'),
						'url'=>$viewModel->demoFilePath,
					    'type'=>'info',
					    'size'=>'small',
					)); ?>
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'حذف فایل دمو جاری یا تغییر آن'),
					    'type'=>'danger',
					    'size'=>'small',
						'htmlOptions'=>array('id'=>'remove-replace-demo-file'),
					)); ?>
				</div>
				<div style="display:none" id="demo-file-add">
					<div id="demo-file-place" style="display: inline;"></div>
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'Dissuasion'),
					    'type'=>'info',
					    'size'=>'small',
						'htmlOptions'=>array('id'=>'dissuasion-demo-file'),
					)); ?>
				</div>
				<?php $viewModel->demoFileRemove = '0'; ?>
				<?php echo $form->hiddenField($viewModel, 'demoFileRemove', array('id'=>'demo-hidden-remove')); ?>
			<?php endif; ?>
			
			<blockquote>
				<small><?php echo Yii::t('product', 'The file is placed in this section, is available for download by all users.'); ?></small>
			</blockquote>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($viewModel, 'projehFile', array('class'=>'control-label')); ?>
		<div class="controls">
		
			<?php if($new OR $viewModel->projehFilePath == null) : ?>
				<?php echo $form->fileField($viewModel, 'projehFile'); ?>
			<?php else : ?>
			
				<div id="projeh-file-remove">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>$viewModel->projehFileName,
					    'type'=>'info',
					    'size'=>'small',
						'url'=>$viewModel->projehFilePath,
						'htmlOptions'=>array('style'=>'direction: ltr; font-family: tahoma'),
					)); ?>
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'تغییر پروژه جاری'),
					    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					    'size'=>'small', // null, 'large', 'small' or 'mini'
						'htmlOptions'=>array('id'=>'remove-replace-projeh-file'),
					)); ?>
				</div>
				<div style="display:none" id="projeh-file-add">
					<div id="projeh-file-place" style="display: inline;"></div>
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>Yii::t('product', 'Dissuasion'),
					    'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					    'size'=>'small', // null, 'large', 'small' or 'mini'
						'htmlOptions'=>array('id'=>'dissuasion-projeh-file'),
					)); ?>
				</div>
	
			<?php endif; ?>
			
			<blockquote>
				<small><?php echo Yii::t('product', 'The project file as the original file and the link will appear to the customer after purchase.'); ?></small>
				<small style="color:red"><?php echo Yii::t('product', 'حداکثر حجم فایل پروژه 50 مگابایت می‌باشد.'); ?></small>
			</blockquote>
		</div>
	</div>

	<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'label'=>Yii::t('form', 'Save'),
		'buttonType'=>'submit',
	));  ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>Yii::t('form', 'Cancel'),
		'url'=>array('/product/my'),
		'type'=>'danger',
	)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div id="projeh-file-input" style="display: none">
	<?php echo $form->fileField($viewModel, 'projehFile'); ?>
</div>
<div id="demo-file-input" style="display: none">
	<?php echo $form->fileField($viewModel, 'demoFile'); ?>
</div>
<div id="photo-file-input" style="display: none">
	<?php echo $form->fileField($viewModel, 'photo'); ?>
</div>