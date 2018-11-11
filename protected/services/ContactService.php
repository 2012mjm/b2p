<?php
class ContactService
{
	public static function checkYmsgr($yahooId) {
		$lines 	= @file ("http://opi.yahoo.com/online?u=".$yahooId."&m=t");
		
		if ($lines !== false)
		{
			$response = implode("", $lines);
		
			if (strpos ($response, "NOT ONLINE") !== false) {
			   return 'offline';
			}
			elseif (strpos ($response, "ONLINE") !== false) {
				return 'online';
			}
		}
		
		return 'offline';
	}
}