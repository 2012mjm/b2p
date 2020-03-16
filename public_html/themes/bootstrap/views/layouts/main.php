<!DOCTYPE html>
<html lang="<?php echo Yii::app()->setting->siteLanguage; ?>">
<head>
    <meta charset="<?php echo Yii::app()->setting->siteCharset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="language" content="<?php echo Yii::app()->setting->siteLanguage; ?>" />
	<meta name="copyright" content="<?php echo Yii::app()->setting->siteSmallAddress; ?>" />
	<meta name="description" content="<?php echo CHtml::encode($this->siteDescription); ?>" />
	<meta name="keywords" content="<?php echo CHtml::encode($this->siteKeywords); ?>" />
	<meta name="author" content="">
	<meta name="title" content="<?php echo CHtml::encode($this->siteTitle); ?>" />

	<title><?php echo CHtml::encode($this->siteTitle); ?> | <?php  echo CHtml::encode($this->siteDescription); ?></title>
	
	<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/img/favicon.gif">

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" rel="stylesheet">

	<?php Yii::app()->bootstrap->register(); ?>
	
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/main.js'); ?>
</head>

<body>

<?php
echo '<div id="flash" class="flash">' . "\n";
$n=1;
foreach(Yii::app()->user->getFlashes() as $key => $message)
{
	if (strpos($key, 'dontshow') !== false) continue;
	if (strpos($key, 'success') !== false) { $key = 'success'; $class = 'alert alert-success'; }
	if (strpos($key, 'error') !== false) { $key = 'error'; $class = 'alert alert-error'; }
	if (strpos($key, 'notice') !== false) { $key = 'notice'; $class = 'alert alert-warning'; }

	echo '<div class="'.$class.' flash-sub flash-' . $key . '" id="flash-' . $n . '">' . $message . '<button type="button" class="close" data-dismiss="alert">&times;</button></div>' . "\n";
	Yii::app()->clientScript->registerScript(
			'myHideEffect-'.$n,
			'$("#flash-'.$n.'").animate({opacity: 1.0}, 4000).fadeOut("slow");',
			CClientScript::POS_READY
	);
	$n++;
}
echo '</div>' . "\n";
?>

<div class="container" id="page">
	
	<?php if(!Yii::app()->user->isGuest) : ?>
		<?php $countUnreadOrder = OrderService::countOwnerUnread(); ?>
		<?php $countUnreadTicket = TicketService::countUnread(); ?>
		<div class="user-menu">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a data-target="#yii_bootstrap_collapse_1" data-toggle="collapse" class="btn btn-navbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="/"></a>
						<div id="yii_bootstrap_collapse_1" class="nav-collapse">
							<ul class="nav" id="yw2">
								<li><?php echo CHtml::link(yii::t('main', 'My Profile'), array('/user/profile')); ?></li>
								<li><?php echo CHtml::link(yii::t('main', 'My Projects'), array('/product/my')); ?></li>
								<li><?php echo CHtml::link(yii::t('main', 'My Orders'), array('/order/index')); ?></li>
								<li><?php echo CHtml::link(yii::t('main', 'فروش من').' <span class="badge badge-'.(($countUnreadOrder > 0) ? 'important' : 'inverse').'">'.$countUnreadOrder.'</span>', array('/sale/index')); ?></li>
								<li><?php echo CHtml::link(yii::t('main', 'My Credit'), array('/credit/index')); ?></li>
								
								<?php if(Yii::app()->user->id != 1) : ?>
									<li><?php echo CHtml::link(yii::t('main', 'My Tickets').' <span class="badge badge-'.(($countUnreadTicket > 0) ? 'important' : 'inverse').'">'.$countUnreadTicket.'</span>', array('/ticket/index')); ?></li>
								<?php endif; ?>
							</ul>
							<a class="user-credit" href="<?php echo Yii::app()->createUrl('/user/profile', array('#'=>'you-credit')); ?>" title="نمایش جزئیات بیشتر">
								<?php echo Yii::t('user', 'اعتبار قابل برداشت:'); ?>
								<strong><?php echo Yii::app()->format->formatPrice(UserService::getvirtualCredit()); ?></strong>
							</a>
							<div class="create-product">
								<?php echo '( '.CHtml::link('ایجاد پروژه جدید', array('/product/myCreate')).' )'; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if(yii::app()->user->getId() == 1) : ?>
		<?php $countManageUnreadTicket = TicketService::countManageUnread(); ?>
		<?php $countManageUnreadOrder = OrderService::countManageUnread(); ?>
		<?php $countManageUnreadWithdraw = CreditService::countManageUnread(); ?>
		<?php $countManageUnreadReport = ReportService::countManageUnread(); ?>
		<?php $countManageUnreadLog = LogService::countManageUnread(); ?>
		<div class="admin-menu">
			<?php $this->widget('bootstrap.widgets.TbNavbar', array(
			    'type'=>'inverse', // '', 'tabs', 'pills' (or 'list')
				'collapse'=>true,
				'brand'=>'',
				'brandUrl'=>'',
			    'items'=>array(
					array(
			            'class'=>'bootstrap.widgets.TbMenu',
						'encodeLabel'=>false,
			            'items'=>array(
			                array('label'=>yii::t('setting', 		'Settings'), 			'url'=>array('/admin/setting')),
							array('label'=>'صفحات ثابت', 									'url'=>array('/admin/managePage')),
							array('label'=>yii::t('user', 			'Users'), 				'url'=>array('/admin/manageUser')),
							array('label'=>yii::t('product', 		'Products'), 			'url'=>array('/admin/manageProduct')),
							array('label'=>yii::t('category', 		'Categories'), 			'url'=>array('/admin/manageCategory')),
							array('label'=>yii::t('subcategory', 	'Sub Categories'), 		'url'=>array('/admin/manageSubcategory')),
							
							array('label'=>yii::t('withdraw', 'Withdraws Credit').' <span class="badge badge-'.(($countManageUnreadWithdraw > 0) ? 'important' : 'inverse').'">'.$countManageUnreadWithdraw.'</span>', 'url'=>array('/admin/manageWithdraw')),
							array('label'=>yii::t('order', 'Orders').' <span class="badge badge-'.(($countManageUnreadOrder > 0) ? 'important' : 'inverse').'">'.$countManageUnreadOrder.'</span>', 'url'=>array('/admin/manageOrder')),
							array('label'=>yii::t('report', 'Reports').' <span class="badge badge-'.(($countManageUnreadReport > 0) ? 'important' : 'inverse').'">'.$countManageUnreadReport.'</span>', 'url'=>array('/admin/manageReport')),							
							array('label'=>yii::t('ticket', 'Tickets').' <span class="badge badge-'.(($countManageUnreadTicket > 0) ? 'important' : 'inverse').'">'.$countManageUnreadTicket.'</span>', 'url'=>array('/admin/manageTicket')),							
							array('label'=>yii::t('main', 'Logs').' <span class="badge badge-'.(($countManageUnreadLog > 0) ? 'important' : 'inverse').'">'.$countManageUnreadLog.'</span>', 'url'=>array('/admin/manageLog')),
			            ),
			        ),
				),
			)); ?>
		</div>
	<?php endif; ?>
				
	<div class="header">
		<div class="row">
			<div class="span3">
				<h1 style="color: blue; font-size: 36px;" class="muted">
					<?php echo CHtml::link(CHtml::encode(Yii::app()->setting->siteName), array('/main/index')); ?> 
					<?php //echo '<small style="font-size: 19px; color: red;">آزمایشی</small>'; ?>
				</h1>
			</div>
			
			<div class="span6">
				<?php $this->widget('bootstrap.widgets.TbMenu', array(
				    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
				    'stacked'=>false, // whether this is a stacked menu
					'encodeLabel' => false,
				    'items'=>array(
						array('label'=>yii::t('main', 'Home'), 'url'=>array('/main/index')),
						
						array('label'=>yii::t('main', 'Shopping Cart (%)', 
							array(
								'%'=>CHtml::tag('span', 
									array('id'=>'shopping-cart-total'), 
									Yii::app()->shoppingCart->getItemsCount())
								)
							), 
							'url'=>array('/product/shoppingCart'),
						),
						
						array('label'=>'راهنمایی خرید', 'url'=>array('/page/index', 'key'=>'buy-help')),
						array('label'=>yii::t('main', 'Contact Us'), 'url'=>array('/main/contact')),
						array('label'=>yii::t('main', 'Login'), 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>yii::t('main', 'Signup'), 'url'=>array('/user/signup'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>yii::t('main', 'فراموشی کلمه عبور'), 'url'=>array('/user/forgetPassword'), 'visible'=>Yii::app()->user->isGuest),
						//array('label'=>yii::t('main', 'My Profile'), 'url'=>array('/user/profile'), 'visible'=>!Yii::app()->user->isGuest),
						array('label'=>yii::t('main', 'Logout').' - '.Yii::app()->user->name, 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest)
				    ),
				    'htmlOptions'=>array('class'=>'pull-left')
				)); ?>
			</div>
			
			<div class="span3">
				<?php
					$searchViewModel = new SearchViewModel();
					$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    					'id'=>'searchForm',
    					'type'=>'search',
						'action'=>array('/product/search'),
						'method'=>'get',
    					'htmlOptions'=>array('style'=>'margin: auto;'),
					));
				?>
					<?php echo $form->textFieldRow($searchViewModel, 'key', array('class'=>'input-medium')); ?>
					<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'<i class="icon-search"></i>', 'encodeLabel'=>false)); ?>
				<?php $this->endWidget(); ?>
			</div>
		</div>
		<br />
		<?php include_once '_contact.php'; ?>
	</div><!-- /header -->

	<hr>
	
	<div class="row">
		<?php if($this->showSidebar) : ?>
		<div class="span3 span3-custom">
		
			<?php if(!$this->isLocal) : ?>
			<div style="text-align: center; margin: 0 auto 20px">
				<!-- Gateway Verify Logo -->

				 <script type="text/javascript"  src="http://www.arianpal.com/xContext/Component/Verify/?UI=d99be41655a34d5389d4a6c5d880bf9b&GID=160130012&MID=824D1498686670B305F762A79AB76A7EBAD914D8&Mode=6" >
				</script>
				<?php /*<noscript><a title="درگاه پرداخت"  href="http://www.parspal.org" >درگاه پرداخت پارس پال</a></noscript>*/ ?>

				<script src="https://cdn.zarinpal.com/trustlogo/v1/trustlogo.js" type="text/javascript"></script>
				<!-- Gateway Verify Logo -->
			</div>
			<?php endif; ?>
		
			<div style="margin: 0 auto 20px; text-align: center">
				<?php
					$trackingCodeViewModel = new TrackingCodeViewModel();
					$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    					'id'=>'trackingCodeForm',
    					'type'=>'inline',
						'action'=>array('/product/trackingCode'),
						'method'=>'post',
    					'htmlOptions'=>array(),
					));
				?>
					<?php echo $form->textFieldRow($trackingCodeViewModel, 'code', array('class'=>'input-medium')); ?>
					<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'<i class="icon-shopping-cart"></i>', 'encodeLabel'=>false)); ?>
				<?php $this->endWidget(); ?>
			</div>

			<?php if($categories = CategoryService::getArrayListCategories()) : ?>
			
				<ul class="nav nav-list">
				<?php foreach ($categories as $cat) : ?>
					<li>
						<i class="tree-toggler icon-chevron-left"></i>
						<?php echo CHtml::link($cat->name, array('product/category', 'id'=>$cat->id, 'title'=>Text::generateSeoUrlPersian($cat->name)), array('class'=>'tree-title')); ?>
						
						<?php if($subCategories = $cat->subcategories) : ?>
						<ul class="nav nav-list tree">
						
							<?php foreach ($subCategories as $sub) : ?>
							<li>
								<?php echo CHtml::link($sub->name, array('product/category', 'id'=>$cat->id, 'subId'=>$sub->id, 'title'=>Text::generateSeoUrlPersian($sub->name))); ?>
							</li>
							<?php endforeach; ?>

						</ul>	
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				</ul>

			<?php endif; ?>
			
			<?php //if($tags = TagService::getTopArrayListTags()) : ?>
			
			<div style="margin: 30px auto 0;">
				<h4 style="background-color: #fbfbfb; padding: 5px 10px;">تگ های برتر</h4>
				<ul class="nav nav-list">
				<?php //foreach ($tags as $tag) : ?>
					<li>
						<?php //echo CHtml::link($tag->name.' ('.$tag->count.' پروژه)', array('product/tag', 'id'=>$tag->id, 'title'=>Text::generateSeoUrlPersian($tag->name))); ?>
					</li>
				<?php //endforeach; ?>
				</ul>
			</div>

			<?php //endif; ?>
			
		
			<div style="margin: 50px auto 0;" id="max-count-sell">
				<h4><?php echo Yii::t('product', 'Best-selling products'); ?></h4>
				<?php
					$this->widget('bootstrap.widgets.TbThumbnails', array(
						'id'=>'max-count-sell-grid',
					    'dataProvider'=>ProductService::getProductsMaxSell(),
					    'itemView'=>'//product/_result',
						'pagerCssClass' => 'pagination',
						'enableHistory' => true,
						'template'=>"{items}",
						/*'pager'=>array(
							'class'=>'bootstrap.widgets.TbPager',
							'nextPageLabel'=>'&larr;',
							'prevPageLabel'=>'&rarr;',
							'firstPageLabel'=>Yii::t('main', '&laquo; First'),
							'lastPageLabel'=>Yii::t('main', 'Last &raquo;'),
						),*/
					));
				?>
			</div>
		</div>
		<?php endif; ?>

		<div class="<?php echo ($this->showSidebar) ? 'span9 span9-custom' : 'span12 span12-custom'; ?>">
			<?php echo $content; ?>
		</div>
	</div>

	<hr>
		
	<?php /*$this->widget('bootstrap.widgets.TbNavbar',array(
	    'items'=>array(
	        array(
	            'class'=>'bootstrap.widgets.TbMenu',
	            'items'=>array(
	                array('label'=>'Home', 'url'=>array('/site/index')),
	                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
	                array('label'=>'Contact', 'url'=>array('/site/contact')),
	                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
	                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
	            ),
	        ),
	    ),
	));*/ ?>


	<div class="footer">
		
		<?php include_once '_follow.php'; ?>

		<p>
			&copy; <?php echo CHtml::encode(Yii::app()->name); ?> - <?php echo Yii::app()->jdate->date('Y'); ?>
		</p>

		<?php if(!$this->isLocal) : ?>
		<div style="float: right">

		</div>

		<div style="display: inline; float: right; margin-top: -2px; margin-right: 5px;">
			<!-- Begin WebGozar.com Counter code -->
			<script type="text/javascript" language="javascript" src="http://www.webgozar.ir/c.aspx?Code=3234382&amp;t=counter" ></script>
			<noscript><a href="http://www.webgozar.com/counter/stats.aspx?code=3234382" target="_blank">&#1570;&#1605;&#1575;&#1585;</a></noscript>
			<!-- End WebGozar.com Counter code -->
		</div>
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-92989110-2', 'auto');
		  ga('send', 'pageview');
		</script>
		﻿<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="4dd0e59a-5cfd-464c-9494-cdd3a405746d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.im/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
		<?php endif; ?>

	</div><!-- /footer -->

</div><!-- page -->

</body>
</html>