<h2>مدیریت صفحات ثابت</h2>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'ایجاد صفحه جدید',
    'type'=>'info', 
    'size'=>'small',
	'url'=>array('create'),
)); ?>

<div class="panel panel-default">
    <div class="panel-body">
	
		<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'slider-grid',
			'dataProvider'=>$model->search(),
			'ajaxUpdate'=>'flash',
			'afterAjaxUpdate'=>'js:function() { flash(); }',
			'columns'=>array(
				'title',
				array(
					'name'=>'key',
					'header'=>Yii::t("main", "Link"),
					'value'=>'CHtml::textField("", Yii::app()->createAbsoluteUrl("/page/index", array("key"=>$data->key)), array("class"=>"ltr"))',
					'type'=>'raw',
				),
				array(
					'name'=>'type',
					'value'=>'Yii::t("enumItem", $data->type)',
				),
				array(
					'name'=>'creationDate',
					'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
				),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{update} {delete}',
		        	'buttons' => array(
						'delete' => array(
							'visible'=>'($data->type != "system")',
		       			),
		       		)
				),
			),
		)); ?>
	
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $("input:text").focus(function() { $(this).select(); } );
});
</script>