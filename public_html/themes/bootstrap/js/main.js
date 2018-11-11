function delimitNumbers(str) {
	return (str + "").replace(/\b(\d+)((\.\d+)*)\b/g, function(a, b, c) {
		return (b.charAt(0) > 0 && !(c || ".").lastIndexOf(".") ? b.replace(/(\d)(?=(\d{3})+$)/g, "$1,") : b) + c;
	});
}

function flash()
{
	$(".flash-sub").css('display', 'none');
	
	$(".flash-sub").fadeIn(500, function() {
		$(".flash-sub").animate({opacity: 1.0}, 3000).fadeOut("slow");
	});
}


function checkPersian(val) {
	firstChar = val.substr(0, 1);
	if( typeof this.characters == 'undefined' )
		this.characters = ['ا','آ','ء','أ','إ','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ؤ','ه','ی','ي'];
	return this.characters.indexOf( firstChar ) != -1;
}

function setDirection(input, rtl)
{
	if(rtl) {
		input.addClass('rtl');
		input.removeClass('ltr');
	}
	else {
		input.addClass('ltr');
		input.removeClass('rtl');
	}
}

function checkDirectionAllInput() {
	$('input').each(function()
	{
		if(checkPersian($(this).val())) {
			setDirection($(this), true);
		} else {
			setDirection($(this), false);
		}
	});
}

function checDirectionkInput()
{
	if($(this).val() != "")
	{
		if(checkPersian($(this).val())) {
			setDirection($(this), true);
		} else {
			setDirection($(this), false);
		}
	}
}

function calComission() {
	if(!$('.my-price-product').length) return;

	var priceVal = $('.my-price-product').val().replace(/,/g, "");
	if(priceVal == '') priceVal = '0';
	var price = parseInt(priceVal);
	var comission = parseInt($('.my-comission-product').text());
	var finalPrice = parseInt(price * (100-comission) / 100);
	$('.my-final-product').text(delimitNumbers(finalPrice));
}

$(function()
{
	checkDirectionAllInput();
	$('input').change(checDirectionkInput);
	$('input').keydown(checDirectionkInput);
	$('input').keyup(checDirectionkInput);
	
	$('ul.tree').css('display', 'none');

	$('.tree-toggler').click(function ()
	{		
		sub = $(this).parent();

		if(sub.children('ul.tree').css('display') == 'none') {
			$(this).removeClass('icon-chevron-left');
			$(this).addClass('icon-chevron-down');
			
			$('.tree-title', sub).addClass('tree-title-actived');
		}
		else {
			$(this).removeClass('icon-chevron-down');
			$(this).addClass('icon-chevron-left');
			
			$('.tree-title', sub).removeClass('tree-title-actived');
		}

		sub.children('ul.tree').toggle(300);
	});

	calComission();
	$('.my-price-product').on('input', calComission);	
	
    $.emailify = {

        settings: {
            atSign: " [at] ",
            // String that will be replaced by '@'.
            dotSign: " [dot] ",
            // String that will be replaced by '.'.
            substitute: function(email) {
                return (this.constructLink(email));
            } // Function that returns the substitute string.
        },

        initialize: function(options) {
            this.settings.substitute = this.constructLink;
            this.settings = $.extend({}, this.settings, options);
            return this;
        },

        deobfuscate: function() {
            this.deobfuscated =
            this.html().replace(this.settings.atSign, "@").replace(this.settings.dotSign, ".");
            return (this);
        },

        construct: function() {
            this.substitution = this.settings.substitute(this.deobfuscated);
            return (this);
        },

        substitute: function() {
            this.html(this.substitution);
            return (this);
        },

        constructLink: function(deobfuscated) {
            return (
            $("<a>", {
                href: "mailto:" + deobfuscated,
                text: deobfuscated
            }));
        }

    }

    $.fn.emailify = function(options) {
        this.each(function() {
            $(this).extend($.emailify).initialize(options).deobfuscate().construct().substitute();
        });
    }
    
    $("span.email").emailify();
    
    //ConvertNumberToPersion();

    $.fn.digitsInput = function() {
        return this.each(function() {
            $(this).val($(this).val().replace(/,/g, "").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        })
    }
    $.fn.resetPriceInput = function() {
        return this.each(function() {
            $(this).val($(this).val().replace(/,/g, ""));
        })
    }
    
    $('.my-price-product').digitsInput();
    var priceContent = $('.my-price-product').val();
    $('.my-price-product').keyup(function() {
    	if ($('.my-price-product').val() != priceContent) {
    		$('.my-price-product').digitsInput();
    	}
    });
    
    $('.form').submit(function() {
    	$('.my-price-product').resetPriceInput();
    })
});

/*function ConvertNumberToPersion() {
    persian = { 0: '۰', 1: '۱', 2: '۲', 3: '۳', 4: '۴', 5: '۵', 6: '۶', 7: '۷', 8: '۸', 9: '۹' };
    function traverse(el) {
        if (el.nodeType === 3 && el.parentNode.localName != "style" && el.parentNode.localName != "script") {
            var list = el.data.match(/^[0-9]+$|[^a-z][0-9]+[^a-z]/ig);
            if (list != null && list.length != 0) {
            	list = el.data.match(/[0-9]/g);
                for (var i = 0; i < list.length; i++)
                    el.data = el.data.replace(list[i], persian[list[i]]);
            }
        }
        for (var i = 0; i < el.childNodes.length; i++) {
            traverse(el.childNodes[i]);
        }
    }
    traverse(document.body);
}*/


