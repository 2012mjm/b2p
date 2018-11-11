$(function()
{
	var province 	= $('#province-list');
	var city 		= $('#city-list');
	
	province.change(function()
	{
		city.empty();
		city.append($('<option>'));

		$.each(cityListJson, function(key, val)
		{
		   if(province.val() == val.provinceId)
		   {
			   city.append($('<option>', { 
				   	value: val.id,
				   	text : val.name 
			   }));
		   }
		});
	});
});