$(function()
{
	var postalSignupButtonClick = false;

	$('#postal-signup-button').click(function(event)
	{
		if(!postalSignupButtonClick)
		{
			$("#postal-signup-form").slideDown('slow');
			$("html, body").animate({ scrollTop: event.pageY });
			postalSignupButtonClick = true;
			event.preventDefault();
			
		}	
	});
});