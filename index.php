<?php

// Dependencies
require_once 'services/Converter.php';
require_once 'services/Node.php';
require_once 'services/XMLTreeMaker.php';

$converter = new Converter();

// Extracting data from csv

$filename = "data/mini.csv";

$handle = fopen($filename, "r");

if ( $handle !== FALSE ) {
	$out_arr = $converter::extractData($handle);
	// echo "<pre>";
	// print_r($out_arr);
	// echo "</pre>";
}

// die();

// Converting data to xml
$xml = new DOMDocument('1.0', 'UTF-8');


$root = $xml->createElement("root");
$root = $xml->appendChild($root);
// 


foreach ( $out_arr as $item ) {
	print_r($item);
	$node = $xml->createElement("node");
	$node = $root->appendChild($node);
	foreach ( $item as $subNode ) {
		$child = $xml->createElement("property", $subNode);
		$child = $node->appendChild($child);
	}
}

$xml_str = $xml->saveXML();
$xml->save("example.xml");



