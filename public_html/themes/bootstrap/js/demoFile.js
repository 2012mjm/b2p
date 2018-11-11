$(function()
{
	var removeReplaceDemoFile 	= $('#remove-replace-demo-file');
	var dissuasionDemoFile 		= $('#dissuasion-demo-file');
	var demoFileAdd 			= $('#demo-file-add');
	var demoFileRemove 			= $('#demo-file-remove');
	var demoFilePlace 			= $('#demo-file-place');
	var demoFileInput 			= $('#demo-file-input');
	var demoFileRemoveHidden 	= $('#demo-hidden-remove');

	removeReplaceDemoFile.click(function(event)
	{
		demoFileRemoveHidden.val('1');
		demoFileRemove.fadeOut('fast', function() {
			demoFilePlace.html(demoFileInput.html());
			demoFileAdd.fadeIn();
		});
		event.preventDefault();
	});

	dissuasionDemoFile.click(function(event)
	{
		demoFileRemoveHidden.val('0');
		demoFileAdd.fadeOut('fast', function() {
			demoFilePlace.html('');
			demoFileRemove.fadeIn();
		});
		event.preventDefault();
	});
});