$(function()
{
	if($.cookies.get('jahanPasaj_currency'))
		var priceCurrency = $.cookies.get('jahanPasaj_currency');
	else
		var priceCurrency = priceCurrencyConfig.currencyBase;

	// button
	if(priceCurrency == 'rial')
		$('#button-prices-currency').text(priceCurrencyConfig.currencyRial+' > '+priceCurrencyConfig.currencyToman);
	else
		$('#button-prices-currency').text(priceCurrencyConfig.currencyToman+' > '+priceCurrencyConfig.currencyRial);
	
	//run convertor
	priceCurrencyConvertor();
	
	
	$('#button-price-currency, #button-prices-currency').click(function()
	{
		if(priceCurrency == 'rial')
		{
			priceCurrency = 'toman';
			$('#button-prices-currency').text(priceCurrencyConfig.currencyToman+' > '+priceCurrencyConfig.currencyRial);
		}
		else {
			priceCurrency = 'rial';
			$('#button-prices-currency').text(priceCurrencyConfig.currencyRial+' > '+priceCurrencyConfig.currencyToman);
		}
		
		$.cookies.set('jahanPasaj_currency', priceCurrency, {hoursToLive: 24*365});
		priceCurrencyConvertor();
	});
});

function priceCurrencyConvertor()
{
	var priceCurrency = $.cookies.get('jahanPasaj_currency');

	// convert
	$('.price-amount').each(function(index)
	{
		var priceAmount 		= parseInt($(this).attr('title'));
		var priceCurrencyText 	= priceCurrencyConfig.currencyRial;

		// calculator
		if(priceCurrency == 'toman') {
			priceAmount /= 10;
			priceCurrencyText = priceCurrencyConfig.currencyToman;
		}

		// change text
		$(this).text(($.number(priceAmount)).toFaDigit());
		$('.price-currency', $(this).parent()).text(priceCurrencyText);
		
		// effect
		$(this).effect("highlight", {color:'yellow'}, 500);
	});
}