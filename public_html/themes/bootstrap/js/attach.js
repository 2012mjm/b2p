$(function()
{
	var addAttach 		= $('#add-attach');
	var attachTemplate 	= $('#attach-template');
	var fileAttaches 	= $('#file-attaches');

	addAttach.click(function(event)
	{
		fileAttaches.append('<br>'+attachTemplate.html());
		event.preventDefault();
	});
});