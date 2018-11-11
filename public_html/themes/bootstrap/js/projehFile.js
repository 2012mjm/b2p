$(function()
{
	var removeReplaceProjehFile = $('#remove-replace-projeh-file');
	var dissuasionProjehFile 	= $('#dissuasion-projeh-file');
	var projehFileAdd 			= $('#projeh-file-add');
	var projehFileRemove 		= $('#projeh-file-remove');
	var projehFilePlace 		= $('#projeh-file-place');
	var projehFileInput 		= $('#projeh-file-input');

	removeReplaceProjehFile.click(function(event)
	{
		projehFileRemove.fadeOut('fast', function() {
			projehFilePlace.html(projehFileInput.html());
			projehFileAdd.fadeIn();
		});
		event.preventDefault();
	});

	dissuasionProjehFile.click(function(event)
	{
		projehFileAdd.fadeOut('fast', function() {
			projehFilePlace.html('');
			projehFileRemove.fadeIn();
		});
		event.preventDefault();
	});
});