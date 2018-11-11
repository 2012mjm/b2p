<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Profile');
$this->breadcrumbs=array(
	yii::t('main', 'Profile'),
);
?>

<h1><?php echo yii::t('main', 'My Profile'); ?></h1>
<br />

<div class="row-fluid">

	<div class="span9">
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
						'value'=>(($model->birthday != null AND $model->birthday != '0000-00-00') ? Yii::app()->jdate->date("j F Y", strtotime($model->birthday)) : NULL),
					),
					array(
						'name'=>'registrationDate',
						'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime(Yii::app()->jdate->toGregorianOnePart($model->registrationDate)))
					),
					array(
						'name'=>'lastVisit',
						'value'=>(($model->lastVisit != null AND $model->lastVisit != '0000-00-00 00:00:00') ? Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->lastVisit)) : NULL)
					),
			    ),
			));
		?>
		
		<div id="you-credit"></div>
		<br />
		<blockquote>
			<h3>مشخصات حساب</h3>
		</blockquote>
		
		<?php
			$this->widget('bootstrap.widgets.TbDetailView', array(
			    'data'=>$model,
			    'attributes'=>array(
					array(
						'label'=>'فروش شما',
						'value'=>Yii::app()->format->formatPrice($sumSale),
						'type'=>'raw',
					),
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
	</div>
	
	<?php $this->renderPartial('//user/_menu'); ?>

</div>