$(function()
{
	var category 		= $('#categories-list');
	var subcategory 	= $('#subcategories-list');

	categories(category, subcategory, parseInt(subcategory.attr('title')));
	category.change(function() {
		categories(category, subcategory);
	});
	
	function categories(category, subcategory, def)
	{
		subcategory.empty();
		subcategory.append($('<option>'));
		
		if(category.val() != '')
		{
			categoryId = parseInt(category.val());
	
			$.each(subcategoryArray[categoryId], function(key, val)
			{
				if(def == key) {
					subcategory.append($('<option>', { 
					   	value: key,
					   	text : val,
					   	selected : 'selected',
				   }));
				}
				else {
					subcategory.append($('<option>', { 
					   	value: key,
					   	text : val,
				   }));
				}
			});
		}
	}
});