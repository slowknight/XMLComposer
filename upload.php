<?php

/**
 * Front End Controller
 */

// Dependencies
require_once 'services/FileUtil.php';
require_once 'services/Converter.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
	    echo 'No file uploaded.';
	}
	
	// Case : file uploaded
	else {
		
		$configuration = array(
			'allowed_ext' => array('csv'),
			'allowed_size' => 300000,
		);
		
		try {
			$fileUtil = new FileUtil($configuration);
		} catch ( Exception $e ) {
			echo "Error instantiating environment.";
		}
		
		$file = $_FILES['file'];
		
		// Case : Uploaded file valid
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


