$(function()
{
	var removeReplacePhotoFile 	= $('#remove-replace-photo-file');
	var dissuasionPhotoFile 	= $('#dissuasion-photo-file');
	var photoFileAdd 			= $('#photo-file-add');
	var photoFileRemove 		= $('#photo-file-remove');
	var photoFilePlace 			= $('#photo-file-place');
	var photoFileInput 			= $('#photo-file-input');
	var photoFileRemoveHidden 	= $('#photo-hidden-remove');

	removeReplacePhotoFile.click(function(event)
	{
		photoFileRemoveHidden.val('1');
		photoFileRemove.fadeOut('fast', function() {
			photoFilePlace.html(photoFileInput.html());
			photoFileAdd.fadeIn();
		});
		event.preventDefault();
	});

	dissuasionPhotoFile.click(function(event)
	{
		photoFileRemoveHidden.val('0');
		photoFileAdd.fadeOut('fast', function() {
			photoFilePlace.html('');
			photoFileRemove.fadeIn();
		});
		event.preventDefault();
	});
});