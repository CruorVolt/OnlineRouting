<?php

	ini_set ("display_errors", "1");
	error_reporting(E_ALL);
	header('content-type: image/png');

	include_once 'GraphClass/GraphImage.php';

	//Image
	$size = 200;
	$image = imagecreate($size, $size);
	$g = new GraphImage( new Graph(array(), array()), $image );
?>
