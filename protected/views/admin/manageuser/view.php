<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('user', 'Manage Users'), 'url'=>array('index')),
	array('label'=>Yii::t('user', 'Update User'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('user', 'Delete User'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<?php
$urlAuthor = array('/product/author', 'username'=>$model->username);
if(($model->firstname || $model->lastname) AND !empty(Text::generateSeoUrlPersian($model->firstname.' '.$model->lastname))) {
	$urlAuthor = array_merge($urlAuthor, array('name'=>Text::generateSeoUrlPersian($model->firstname.' '.$model->lastname)));
}
?>
<h1><?php echo CHtml::link($model->username, $urlAuthor); ?></h1>


<div class="view"> 

	<div class="span12">
		<blockquote>
			<h3>مشخصات کاربری</h3>
		</blockquote>
		<?php
			$this->widget('bootstrap.widgets.TbDetailView', array(
			    'data'=>$model,
			    'attributes'=>array(
					'firstname',
					'lastname',
					'email',
					'phone',
					'mobile',
					array(
						'name'=>'gender',
						'value'=>Yii::t('enumItem',$model->gender),
					),
					'fieldStudy',
					array(
						'name'=>'birthday',
						'value'=>(($model->birthday != null AND $model->birthday != '0000-00-00') ? Yii::app()->jdate->date("j F Y", strtotime($model->birthday)) : '-'),
					),
					array(
						'name'=>'registrationDate',
						'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime(Yii::app()->jdate->toGregorianOnePart($model->registrationDate)))
					),
					array(
						'name'=>'lastVisit',
						'value'=>(($model->lastVisit != null AND $model->lastVisit != '0000-00-00 00:00:00') ? Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->lastVisit)) : '-')
					),
					array(
						'name'=>'status',
						'value'=>Yii::t('enumItem', $model->status)
					),
			    ),
			));
		?>
	
		<br />
		<blockquote>
			<h3>مشخصات حساب</h3>
		</blockquote>
		
		<?php
			$this->widget('bootstrap.widgets.TbDetailView', array(
			    'data'=>$model,
			    'attributes'=>array(
			    	array(
			    		'label'=>'اعتبار قابل برداشت (با احتساب  درصد کارمزد سیستم)',
						'value'=>Yii::app()->format->formatPrice($model->virtualCredit),
						'type'=>'raw',
					),
					array(
						'name'=>'bankName',
						'value'=>Yii::t('enumItem',$model->bankName),
					),
					'bankAccountNumber',
					'bankCardNumber',
			    ),
			));
		?>
		
		
		<br />
		<blockquote>
			<h3>پروژه های فروخته شده</h3>
		</blockquote>

	    <?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'order-grid',
			'dataProvider'=>$dataProviderOrder,
			'columns'=>array(
				array(
					'name'=>'product.title',
					'value'=>'($data->product) ? CHtml::link(mb_substr($data->product->title, 0, 20, "UTF-8").((strlen($data->product->title) > 20) ? " ..." : ""), array("/product/view", "id"=>$data->productId, "title"=>Text::generateSeoUrlPersian($data->product->title))) : "-"',
					'header'=>Yii::t("product", "Product Title"),
					'type'=>'raw',
				),
				array(
					'header'=>'خریدار',
					'value'=>'($data->user) ? CHtml::link($data->user->username, array("admin/manageuser/view", "id"=>$data->userId)) : "مهمان"',
					'type'=>'raw',
				),
				array(
					'name'=>'price',
					'value'=>'Yii::app()->format->formatPrice($data->price)',
					'type'=>'raw',
				),
				array(
					'name'=>'count',
					'footer'=>Yii::t('product', 'تعداد کل: ').$totalCount,
				),
				array(
					'header'=>'مبلغ کل',
					'value'=>'Yii::app()->format->formatPrice($data->price * $data->count)',
					'type'=>'raw',
				),
				array(
					'header'=>'کارمزد سیستم',
					'value'=>'Yii::app()->format->formatPrice($data->price * $data->count * $data->systemComission / 100) . " (" . $data->systemComission . "%)"',
					'type'=>'raw',
				),
		        array(
		        	'header'=>'تاریخ فروش',
		        	'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
					'footer'=>Yii::t('product', 'Final price').': '.Yii::app()->format->formatPrice($totalSalePrice).'<br>'.Yii::t('product', 'جمع کل با احتساب کارمزد').': '.Yii::app()->format->formatPrice($totalSalePriceWithCommission),
		        ),
			),
		)); ?>
	</div>
	
</div>
