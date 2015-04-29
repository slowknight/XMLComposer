<?php

/**
 * XML Generation Operations
 * 
 * @author: Wissam K
 */

class Converter extends DOMDocument {
	
	protected $ver;
	protected $enc;
	
	public function __construct ($ver, $enc)
	{
		parent::__construct($ver, $enc);
	}
	
	public function generateXML ($arr)
	{
		$root = $this->createElement("root");
		$root = $this->appendChild($root);
		
		foreach ( $arr as $item ) {
			// print_r($item);
			$node = $this->createElement("node");
			$node = $root->appendChild($node);
			foreach ( $item as $subNode ) {
				$child = $this->createElement("property", $subNode);
				$child = $node->appendChild($child);
			}
		}
		
		$xml_str = $this->saveXML();
		
		return $xml_str;
	}
	
}



