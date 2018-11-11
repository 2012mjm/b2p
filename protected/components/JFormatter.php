<?php
class JFormatter extends CFormatter
{
    /* @var int The text length limit for the ShortText formatter. */
    public $shortTextLimit = 60;
    
    /**
     * shortens the supplied text after last word
     * @param string $value
     */
	public function formatShortenText($value, $params=array())
	{
		if(isset($params['length'])) {
			$max_length = $params['length'];
		} else {
			$max_length = $this->shortTextLimit;
		}
        
		$value = trim($value);

		//Sentence
		if(empty($value) || mb_strlen($value, Yii::app()->charset) <= $max_length)
		{
			return CHtml::tag(
		    	'p', 
		    	array(
//		    		'title'=>CHtml::tag(
//		    			'p', array('class'=>'product-tooltip'), 
//		    			nl2br($value)
//		    		)
		    	), 
		    	nl2br($value)
			);
		}
		
		//Sentence ...
		$stack_count = 0;
		$max_length = $this->shortTextLimit;
		
		while($max_length > 0)
		{
			$char = mb_substr($value, --$max_length, 1, Yii::app()->charset);
			if(preg_match('#[^\p{L}\p{N}]#iu', $char)) {	
				$stack_count++; //only alnum characters
			}
			elseif($stack_count > 0) {
				$max_length++;
            	break;
			}
		}

    	return CHtml::tag(
	    	'p', 
	    	array(
//	    		'title'=>CHtml::tag(
//	    			'p', array('class'=>'product-tooltip'), 
//	    			nl2br($value)
//	    		)
	    	), 
	    	nl2br(mb_substr($value, 0, $max_length, Yii::app()->charset)).' ...'
	    );
	}

	public function formatPrice($value)
	{
//		$jahanPasaj_currencies = '';
//
//		if(isset(Yii::app()->request->cookies['jahanPasaj_currency'])) {
//			$jahanPasaj_currencies = Yii::app()->request->cookies['jahanPasaj_currency']->value;
//		}

		$amount 	= CHtml::tag('strong', array('class'=>'price-amount', 'id'=>'button-price-currency'), $this->formatNumber($value/10));
		$currency 	= CHtml::tag('span', array('class'=>'price-currency'), Yii::t('main', 'Toman'));

		return $amount.' '.$currency;
	}
	
	public function decodeImc($string)
	{
		return str_replace('&amp;', '&', $string);
	}
}
?>