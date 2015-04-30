<?php

/**
 * File Processing Tools
 * 
 * @author: Wissam K
 */

class FileUtil {
	
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
				array_unique(array_merge($this->_config, $config));
			}
		}
	}
	
	public function validateUploadedFile ($file)
	{
		if ( !in_array(self::getFileExtension($file['name']), $this->_config['allowed_ext']) ) {
			return FALSE;
		}
		if ( $file['size'] > $this->_config['allowed_size'] ) {
			return FALSE;
		}
		if ( $file['error'] !== 0 ) {
			return FALSE;
		}
		return TRUE;
	}
	
	public static function getFileExtension ($filename)
	{
		$file_ext = explode('.', $filename);
		$file_ext = strtolower(end($file_ext));
		return $file_ext;
	}
	
	public static function extractData ($handle, $option=null)
	{
		$out_arr = array();
		while ( ($data = fgetcsv($handle)) !== FALSE ) {
			$out_arr[] = $data;
		}
		return $out_arr;
	}
	
}




