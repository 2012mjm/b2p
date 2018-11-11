$(function()
{
	var province 	= $('#province-list');
	var city 		= $('#city-list');
	
	provinceCity(province, city, parseInt(city.attr('title')));
	province.change(function() {
		provinceCity(province, city);
	});
	
	function provinceCity(province, city, def)
	{
		city.empty();
		city.append($('<option>'));
		
		if(province.val() != '')
		{
			provinceId 	= parseInt(province.val());
	
			$.each(cityArray[provinceId], function(key, val)
			{
				if(def == key) {
				   city.append($('<option>', { 
					   	value: key,
					   	text : val,
					   	selected : 'selected',
				   }));
				}
				else {
				   city.append($('<option>', { 
					   	value: key,
					   	text : val,
				   }));
				}
			});
		}
	}
});