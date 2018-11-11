<?php
class Encrypt {
	/**
	 * @return hash string.
	 */
	public static function encryptPassword($password = "") {
		if (strlen($password) == 0) return false;
		$firstChar = substr($password, -1, 1);
		$hash = md5(md5($password) . $firstChar . md5($firstChar));
		return $hash;
	}
}