$(function()
{
	$('#shopping-cart-two').css('display','none');

	$('#order-submit-next').click(function(event)
	{
		$('#shopping-cart-one').slideUp('slow');
		$('#shopping-cart-two').slideDown('slow');
		event.preventDefault();
	});

	$('#order-submit-prev').click(function(event)
	{
		$('#shopping-cart-two').slideUp('slow');
		$('#shopping-cart-one').slideDown('slow');
		event.preventDefault();
	});
});