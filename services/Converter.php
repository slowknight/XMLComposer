<?php

require_once 'Node.php';

class Converter {
	
	// private static $option;
	
	public static function extractData ($handle, $option=null)
	{
		$out_arr = array();
		while ( ($data = fgetcsv($handle)) !== FALSE ) {
			$out_arr[] = $data;
		}
		return $out_arr;
	}
	
}



