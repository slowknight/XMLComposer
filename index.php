<?php

// Dependencies
require_once 'services/Converter.php';

$converter = new Converter();

// Extracting data from csv

$filename = "data/mini.csv";

$handle = fopen($filename, "r");

if ( $handle !== FALSE ) {
	$out_arr = $converter::extractData($handle);
	echo "<pre>";
	print_r($out_arr);
	echo "</pre>";
}

// Converting data to xml


