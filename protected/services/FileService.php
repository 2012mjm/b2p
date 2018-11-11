<?php
class FileService
{
	public $webroot;
	
	public function __construct() {
		$this->webroot = Yii::getPathOfAlias('webroot');
	}
	
	//----------------------------------------------------------------------------
	public function uploadFile(CUploadedFile $uploadedFile, $type)
	{
		$rootPath 	= $this->webroot;
		$filePath	= '/data/'.$type.'/';
		$fileName	= self::generateFileNameForSave($uploadedFile->getName());

		if($uploadedFile->saveAs($rootPath.$filePath.$fileName) === true)
		{
			// insert to file table
			if($this->saveFile(Yii::app()->user->id, $type, $fileName, $uploadedFile->getType(), $uploadedFile->getSize()))
			{
				if($type == 'photo')
				{
					//write text on pic
					$objWriter = new WriteOnPic();
					$objWriter->inputImage 	= $rootPath.$filePath.$fileName;
					$objWriter->text 		= 'www.bia2projeh.ir';
					$objWriter->save 		= true;
					$objWriter->action();

					//generate Thumbnail Photo
					self::generateThumbnailPhoto($filePath, $fileName);
				}

				return Yii::app()->db->getLastInsertID();
			}
		} else {
			return false;
		}
	}
	
	//----------------------------------------------------------------------------
	public function deleteFile($idOrFileModel) {

		if(is_object($idOrFileModel)) {
			$fileModel = $idOrFileModel;
		}
		else {
			$id = intval($idOrFileModel);
			$fileModel = File::model()->findByPk($id);
		}
		
		//$fileModel->isDeleted = 'yes';
		@unlink(Yii::getPathOfAlias('webroot') . $fileModel->filePath . $fileModel->fileName);
		
		//return $fileModel->save(true, $fileModel);
		return $fileModel->delete();
	}
	
	//----------------------------------------------------------------------------
	public function saveFile($userId, $type, $fileName, $fileType=null, $fileSize=null)
	{
		$fileModel = new File();

		$fileModel->userId 			= $userId;
		$fileModel->type 			= $type;
		$fileModel->fileName 		= $fileName;
		$fileModel->fileType 		= ($fileType !== null) ? $fileType : pathinfo($fileName, PATHINFO_EXTENSION);
		$fileModel->fileSize 		= ($fileSize !== null) ? $fileSize : filesize($this->webroot.'/data/'.$type.'/'.$fileName);
		$fileModel->filePath 		= '/data/'.$type.'/';
		$fileModel->creationDate 	= date('Y-m-d H:i:s');
		$fileModel->isDeleted 		= 'no';
		
		return $fileModel->save(true, $fileModel);
	}
	
	/**
	 * Generate new file name for save from orginal file name uploaded
	 */
	public static function generateFileNameForSave($filePath)
	{
		$pathinfo = pathinfo($filePath);
		$extension = $pathinfo['extension'];
		$fileName = trim($pathinfo['filename']);
		
		$seoFileName = Text::generateSeoUrlPersian($fileName, '_');
		$seoFileName = uniqid() . '_' . $seoFileName;
		
		return $seoFileName.'.'.$extension;
	}
	
	/**
	 * save thumbnail photo
	 * @param string, $filePath
	 * @param string, $fileName
	 */
	private static function generateThumbnailPhoto($filePath, $fileName)
	{
		$dimension 	= array('width'=>280, 'height'=>180);
		$quality 	= 85;
		$rootPath 	= Yii::getPathOfAlias('webroot').$filePath;
		
		// load image 
		try {
			$cImage = Yii::app()->image->load($rootPath.$fileName);
		}
		catch( Exception $e ) {
			// set flash for error message
			Yii::app()->user->setFlash('notice', $e->getMessage());
		}
		
		$cImage->resize($dimension['width'], $dimension['height'], Image::WIDTH)->quality($quality);
		if($cImage->save($rootPath.'t_'.$fileName))
		{
			//write text on pic
			$objWriter = new WriteOnPic();
			$objWriter->inputImage 	= $rootPath.'t_'.$fileName;
			$objWriter->text 		= 'www.bia2projeh.ir';
			$objWriter->save 		= true;
			$objWriter->action();
			
			return true;
		}
	}
}
