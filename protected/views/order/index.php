<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Orders');
?>

<h1><?php echo yii::t('main', 'My Orders'); ?></h1>

<br />

<blockquote>
	<p>در صورت خرید یک پروژه و نامرتبط بودن محتویات فایل ها، می توانید از طریق کلید گزارش تخلف در جلوی <strong>پروژه های پرداخت شده</strong>، گزارش خود را به مدیریت اطلاع دهید، و پس از بررسی گزارش شما، در صورت نامرتبط بودن محتویات فایل ها، هزینه پروژه کسر شده به حساب شما بازگشت داده می‌شود.</p>
	<p style="color: #f89406;">توجه: برای ارسال گزارش تخلف در رابطه با هر پروژه خریداری شده حداکثر 48 ساعت فرصت دارید.</p>
</blockquote>

<hr>

<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'orders-grid',
		'dataProvider'=>$orderDataProvider,
		'enableHistory'=>true,
		'afterAjaxUpdate'=>'js:function() { priceCurrencyConvertor(); }',
		'template'=>"{summary}{items}{pager}",
    	'enablePagination' => true,
		'pager'=> array(
	        'class'=>'bootstrap.widgets.TbPager',
			'nextPageLabel'=>'&larr;',
			'prevPageLabel'=>'&rarr;',
	    ),
		'columns'=>array(
			array(
				'name'=>'product.title',
				'value'=>'CHtml::link(mb_substr($data->product->title, 0, 20, "UTF-8").((strlen($data->product->title) > 20) ? " . . ." : ""), array("/product/view", "id"=>$data->productId, "title"=>Text::generateSeoUrlPersian($data->product->title)))',
				'type'=>'raw',
			),
			array(
				'name'=>'linkDownload',
				'value'=>'($data->status == "accepted") ? CHtml::link(Yii::t("order", "Receive"), array("/main/download", "key"=>$data->linkDownload)) : "-"',
				'type'=>'raw',
			),
			'trackingCode',
			array(
				'name'=>'price',
				'value'=>'Yii::app()->format->formatPrice($data->price)',
				'type'=>'raw',
			),
			array(
				'name'=>'creationDate',
				'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
			),
			array(
				'name'=>'status',
				'value'=>'Yii::t("enumItem", $data->status)',
			),
	        array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{report}',
	        	'buttons' => array(
					'report' => array(
						'url'=>'array("report", "id"=>$data->id, "pid"=>$data->productId, "#"=>($data->status == "accepted") ? ((!checkReports($data->reports)) ? "report-modal" : "once-report-modal") : "not-report-modal")',
	        			'label'=>Yii::t("report", "Report Abuse"),
	        			'icon'=>'ban-circle',
	        			'options'=>array(
	        				'role'=>'button',
	        				'data-toggle'=>'modal',
	        				'class'=>'report-button',
	       				),
						'visible'=>'strtotime($data->creationDate)+172800 >= time()', //24 hours
	       			)
	       		)
	        ),
		),
	));
?>

<?php
function checkReports($reports) {
	if($reports == null) return false;
	foreach ($reports as $report) {
		if($report->status != 'fixed') {
			return true;
		}
	}
	
	return false;
}
?>


<!-- Modal -->
<div id="not-report-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo Yii::t("report", "Report Abuse"); ?></h3>
	</div>
	<div class="modal-body">
		<?php echo Yii::t('main', 'شما ابتدا باید هزینه این محصول را پرداخت کنید!'); ?>  
	</div>
</div>

<!-- Modal -->
<div id="once-report-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo Yii::t("report", "Report Abuse"); ?></h3>
	</div>
	<div class="modal-body">
		<?php echo Yii::t('main', 'گزارش شما در حال بررسی توسط بخش پشتیبانی می باشد.'); ?>  
	</div>
</div>

<!-- Modal -->
<div id="report-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'order-report-form',
	    'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'action'=>array('report'),
	)); ?>
	
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo Yii::t("report", "Report Abuse"); ?></h3>
		</div>
		<div class="modal-body">
			<div class="form">

				<div class="control-group">
					<?php echo $form->labelEx($viewModelReport, 'description', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textArea($viewModelReport, 'description', array('style'=>'width: 90%; height: 150px;')); ?>
					</div>
				</div>
			
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Yii::t("form", "Close"); ?></button>
			<button class="btn btn-primary"><?php echo Yii::t("form", "Save"); ?></button>
		</div>
	
	<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
$('.report-button').click(function()
{
	var url = $(this).attr('href').replace(/#.*$/, '');
	$('#order-report-form').attr('action', url);
});
</script>