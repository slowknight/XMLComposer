<?php

/**
 * File Processing Tools
 * 
 * @author: Wissam K
 */

class FileUtil 
{
	/**
	 * Configuration array
	 * @var array
	 */
	protected $_config = [];
	
	/**
	 * Constructs FileUtil
	 * 
	 * @param array key-value pair configuration settings
	 */
	public function __construct ($config=null)
	{
		$this->_config = array(
			'allowed_ext' => array('csv'),
			'allowed_size' => 50000,
		);
		if ( !empty($config) ) {
			if ( !is_array($config) ) {
				throw new Exception("Invalid configuration input.");
			} else {
				foreach ($config as $key => $value) {
					if ( !empty($value) ) {
						$this->_config[$key] = $value;
					}
				}
			}
		}
	}
	
	/**
	 * Validates a file upload
	 * 
	 * @param array $file the uploaded file
	 * @return bool true is file is valid, false otherwise
	 */
	public function validateUploadedFile ($file)
	{
		// Check file extension is valid
		if ( !in_array(self::_getFileExtension($file['name']), $this->_config['allowed_ext']) ) {
			return FALSE;
		}
		
		// Check file size is within range
		if ( $file['size'] > $this->_config['allowed_size'] ) {
			return FALSE;
		}
		
		// Error occured
		if ( $file['error'] !== 0 ) {
			return FALSE;
		}
		
		// No errors
		return TRUE;
	}
	
	/**
	 * Helper function obtains the extension of file from its name
	 * 
	 * @param string $filename Name of the file
	 * @return string Extension of the file
	 */
	public static function _getFileExtension ($filename)
	{
		$file_ext = explode('.', $filename);
		$file_ext = strtolower(end($file_ext));
		return $file_ext;
	}
	
	/**
	 * Generates an array from a CSV file
	 * 
	 * @param resource $handle File handle
	 * @return array Array of data
	 */
	public static function extractData ($handle, $option=null)
	{
		$out_arr = array();
		while ( ($data = fgetcsv($handle)) !== FALSE ) {
			$out_arr[] = $data;
		}
		return $out_arr;
	}
	
	/**
	 * Get the configuration array
	 * 
	 * @return array Configuration array
	 */
	public function _getConfig ()
	{
		return $this->_config;
	}
	
}





