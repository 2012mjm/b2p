<?php
class SettingService
{
	function getSetting($viewModel)
	{
		$varViewModel = get_class_vars(get_class($viewModel));
		
		foreach ($varViewModel as $var=>$value)
		{
			if(Yii::app()->setting->$var)
				$viewModel->$var = Yii::app()->setting->$var;
		}

		return $viewModel;
	}
	
	function update($viewModel)
	{
		$settingModel = new Setting();
		
		$settingModel->id = 1;
		$settingModel->attributes = $viewModel->attributes;
		
		$settingModel->setIsNewRecord(false);
		return $settingModel->save($settingModel);
	}
}