<?php

// Dependencies
require_once 'services/Converter.php';

$converter = new Converter("1.0", "UTF-8");

// Extracting data from csv

$filename = "data/mini.csv";

$handle = fopen($filename, "r");

if ( $handle !== FALSE ) {
	$out_arr = $converter::extractData($handle);
	// echo "<pre>";
	// print_r($out_arr);
	// echo "</pre>";
}

// var_dump($converter);
// die();

// Converting data to xml

$xml_str = $converter->generateXML($out_arr);

$converter->save("example.xml");



