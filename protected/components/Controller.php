<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $siteTitle;
	public $siteDescription;
	public $siteKeywords;

	public $isLocal;

	public $showSidebar = true;
	

	public function init()
	{
		Yii::app()->clientScript->registerCoreScript('jquery');

		Yii::app()->name = (Yii::app()->setting->siteName) ? Yii::app()->setting->siteName : Yii::t('main', Yii::app()->name);
		
		Yii::app()->language 	= Yii::app()->setting->siteLanguage;
		Yii::app()->theme 		= Yii::app()->setting->siteDefaultTheme;
		Yii::app()->charset 	= Yii::app()->setting->siteCharset;
		Yii::app()->timezone 	= Yii::app()->setting->siteTimeZone;

		$this->siteTitle 		= Yii::app()->name;
		$this->siteDescription 	= Yii::app()->setting->siteDescription;
		$this->siteKeywords 	= Yii::app()->setting->siteKeywords;
        
		$this->isLocal 			= ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' OR $_SERVER['REMOTE_ADDR'] == '::1');

        parent::init();
    }
}