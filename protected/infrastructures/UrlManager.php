<?php

class UrlManager {
	const ERROR_NONE = 0;
	const ERROR_CURL_NOT_AVAILABLE = 1;
	const ERROR_CURL_MALFORMED_OPTION = 2;
	const ERROR_BAD_FILE = 3;
	const ERROR_BAD_FILE_HEADER = 4;
	const ERROR_EXECUTING_CURL = 5;
	const ERROR_OPENING_FILE = 6;
	const ERROR_INITIALIZING_CURL = 7;
	

	private static function cURLcheckBasicFunctions()
	{
		if( !function_exists("curl_init") &&
				!function_exists("curl_setopt") &&
				!function_exists("curl_exec") &&
				!function_exists("curl_close") ) return false;
		else return true;
	}

	/*
	 * Returns string status information.
	* Can be changed to int or bool return types.
	*/
	public static function cURLdownload($url, $file, &$result)
	{
		if( !self::cURLcheckBasicFunctions() ) return self::ERROR_CURL_NOT_AVAILABLE;
		$ch = curl_init();
		if($ch)
		{
			$fp = fopen($file, "w");
			if($fp)
			{
				if( !curl_setopt($ch, CURLOPT_URL, $url) )
				{
					fclose($fp); // to match fopen()
					curl_close($ch); // to match curl_init()
					return self::ERROR_CURL_MALFORMED_OPTION;
				}
				if( !curl_setopt($ch, CURLOPT_FILE, $fp) ) return self::ERROR_BAD_FILE;
				if( !curl_setopt($ch, CURLOPT_HEADER, 0) ) return self::ERROR_BAD_FILE_HEADER;
				if( !curl_exec($ch) ) return self::ERROR_EXECUTING_CURL;
				$info = curl_getinfo($ch);
				$result['size'] = $info['download_content_length'];
				$result['type'] = $info['content_type'];
				$result['curl_info'] = $info; // for future maintenence
				curl_close($ch);
				fclose($fp);
				return self::ERROR_NONE;
			}
			else return self::ERROR_OPENING_FILE;
		}
		else return self::ERROR_INITIALIZING_CURL;
	}
}