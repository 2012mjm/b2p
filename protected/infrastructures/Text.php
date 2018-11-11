<?php
class Text {
	/*
	 * Convert title from filename
	 */
	public static function filenameToTitle($filename) {
		$filename = urldecode($filename);
		$title = pathinfo($filename, PATHINFO_FILENAME);
		$title = preg_replace('/[\W_]+/',' ',$title);
		$title = preg_replace('/^[\s]+/','',$title);
		$title = preg_replace('/[\s]+$/','',$title);
		$title = ucfirst($title);
		if ($title == '') $title = '[No title]';
		return $title;
	}
	
// 	/*
// 	 * Get extension of filename
// 	*/
// 	public static function extensionFilename($filename) {
// 		$extension = pathinfo($filename, PATHINFO_EXTENSION);
// 		return $extension;
// 	}
	
	/*
	 * Convert a string to SEO friendly
	*/
	public static function generateSeoUrl($title) {
		$title = preg_replace('/\%/',' percentage',$title);
		$title = preg_replace('/\@/',' at ',$title);
		$title = preg_replace('/\&/',' and ',$title);
		$title = preg_replace('/\s[\s]+/','-',$title);	// Strip off multiple spaces
		$title = preg_replace('/[\s\W]+/','-',$title);	// Strip off spaces and non-alpha-numeric
		$title = preg_replace('/^[\-]+/','',$title); 	// Strip off the starting hyphens
		$title = preg_replace('/[\-]+$/','',$title);	// Strip off the ending hyphens
		$title = strtolower($title);
		return $title;
	}
	
	public static function generateSeoUrlPersian($title, $replace='-')
	{	
		mb_regex_encoding('UTF-8');

		//this will replace all non alphanumeric char with '-'
		$title = mb_ereg_replace('[^\x{0622}-\x{063A}\x{0641}-\x{064A}\x{0660}-\x{0669}\x{06A9}\x{06AF}\x{067E}\x{0686}\x{0698}\x{06CC}\x{06F0}-\x{06F9}0-9A-Za-z]+', $replace, $title);
		
      	//trim whitespaces
		$title = trim($title, '-');

		return $title;
	}
	
	//public static function formatPrice($price, $dollar=true, $numberFormat=true) {
	public static function formatPrice($price) {
// 		$price = round($price, 2);
// // 		setlocale(LC_MONETARY, 'en_US');
// // 		$price = money_format('%i', $price);
// 		$price = ($numberFormat == true) ? number_format($price, 2, '.', ',') : number_format($price, 2, '.', '');
// 		if ($dollar == true) $price = '$'.$price;
		$price = Yii::app()->numberFormatter->formatCurrency($price, 'USD');
		return $price;
	}
	
	/**
	 * round floor price 
	 */
	function rfloor($real,$decimals = 2) {
		return substr($real, 0,strrpos($real,'.',0) + (1 + $decimals));
	}
	
	/**
	 * Generate a new referred Id
	 * @return $referredId
	 */
	public static function generateReferredId() {
		$modelVariable = Variable::model()->findByPk(1);
		$referredId = $modelVariable->referred;
		$modelVariable->referred++;
		$modelVariable->update();
		return $referredId;
	}
	
	/**
	 * Generate a new order Id
	 * @return $orderId
	 */
	public static function generateOrderId() {
		$modelVariable = Variable::model()->findByPk(1);
		$orderId = $modelVariable->order;
		$modelVariable->order++;
		$modelVariable->update();
		return $orderId;
	}
	
	/**
	 * Generate a new transaction Id
	 * @return $transactionId
	 */
	public static function generateTransactionId() {
		$modelVariable = Variable::model()->findByPk(1);
		$transactionId = $modelVariable->transaction;
		$modelVariable->transaction++;
		$modelVariable->update();
		return $transactionId;
	}
	
	/**
	 * convert html to text
	 * @param string $document, html
	 * @return string, text
	 */
	public static function html2txt($document){
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $document);
		return $text;
	}
	
	/**
	 * check url host name
	 * @param string $url, $domain
	 * @return true or false
	 */
	public static function checkUrlHostName($url, $domain) {
		$url = strtolower($url);
		$domain = strtolower($domain);
		if (parse_url($url,  PHP_URL_HOST) == $domain OR parse_url($url,  PHP_URL_HOST) == 'www.'.$domain) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * get first sentence
	 * @param string
	 * @return string
	 */
	public static function getFirstSentence($sentences) {
		$sentences = trim($sentences);
		$pos = strpos($sentences, '.');
		if ($pos > 0)
			$pos++;
		else
			$pos = strlen($sentences);
		$sentence = substr($sentences, 0, $pos);
		return $sentence;
	}
	
	public static function getBestMetaDescription($sentences) {
		$sentences = trim($sentences);
		$sMax = implode(' ', array_slice(explode(' ', $sentences), 0, 25));
		if (strlen($sMax) >= strlen($sentences))
			return $sentences;
		$sMin = implode(' ', array_slice(explode(' ', $sentences), 0, 7));
		$lenMin = strlen($sMin);
		$posDot = strrpos($sMax, '.');
		$sDot = substr($sMax, 0, $posDot);
		$lenDot = strlen($sDot)+1;
		if ($lenDot < $lenMin)
			return $sMax . '...';
		else
			return $sDot . '.';
	}
	
	public static function strReplaceOnce($string, $find, $replace)
	{
		if($find != null)
			if(($start = strpos($string, $find)) !== false)
				return substr_replace($string, $replace, $start, strlen($find));

		return $string;
	}

	/**
	 * Ellipsis strings
	 * @param  string  $string
	 * @param  integer $max_length
	 * @return string
	 */
	public static function ellipsis($string = '', $max_length = 20)
	{
    	return (strlen($string) > $max_length) ? substr($string,0,strrpos(substr($string, 0, $max_length), ' '))."…" : $string;
	}
	
	public static function imgValid($text) {
		return preg_replace_callback('/(<img.*?src=[\"|\']*)([^\"\']+)([\"|\']*.*?>)/is', 'self::filterImgValid', $text);
	}
	public static function filterImgValid($matches) {
		$extension = strtolower(pathinfo($matches[2], PATHINFO_EXTENSION));
		if($extension) {
			if(!in_array($extension, array('jpg', 'png', 'gif', 'bmp', 'svg', 'jpeg'))) {
				$matches[2] = '';
			}
		}
		
		return $matches[1].$matches[2].$matches[3];
	}
	
	public static function autoUrl($text)
	{
		$text = urldecode($text);
		
		$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
		$text = preg_replace($url, '<a href="$0" target="_blank" title="$0" style="display:inline-table;direction:ltr;">$0</a>', $text);
		
// 		$urlFree = Yii::app()->getBaseUrl(true);
// 		$urlFree = str_replace('/', '\/', $urlFree);
// 		$text = preg_replace('/('.$urlFree.'.*?\.html)/is', '<a href="$1">$1</a>', $text);
		
		return $text;
	}
	
	public static function valueToKey($array)
	{
		if(!is_array($array)) return array();

		$newArray = array();
		foreach ($array as $value) {
			$newArray[$value] = $value;
		}
		
		return $newArray;
	}
}