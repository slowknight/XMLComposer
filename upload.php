<?php

/**
 * Front End Controller
 */

require_once 'services/FileUtil.php';
require_once 'services/Converter.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	if ( isset($_FILES['file']) ) {
		
		try {
			$fileUtil = new FileUtil();
		} catch ( Exception $e ) {
			echo "Error instantiating environment.";
		}
		
		$file = $_FILES['file'];
		
		if ( $fileUtil->validateUploadedFile($file) ) {
			
			$handle = fopen($file['tmp_name'], "r");
			
			// Converting csv content to array
			if ( $handle !== FALSE ) {
				$out_arr = $fileUtil::extractData($handle);
			}
			
			if ( !empty($out_arr) ) {
				$converter = new Converter("1.0", "UTF-8");
				
				// Generating XML
				$xml_str = $converter->generateXML($out_arr);
				
				if ( !empty($xml_str) ) {
					$xml_file_output = $_SERVER["DOCUMENT_ROOT"] . '/' . 'output' . rand() . '.xml';
					$converter->save($xml_file_output);
					
					// Render response
					$file_location = $xml_file_output;
					
					// Download file
					if (file_exists($file_location)) {
				            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
				            header("Cache-Control: public"); //For IE
				            header("Content-Type: application/xml");
				            header("Content-Length:".filesize($file_location));
				            readfile($file_location);
				            die();        
				        }
					
				}
				
			}
			
		}
		
	}
	
}


