<?php

session_start();
include_once 'GraphClass/Graph.php';
ini_set ("display_errors", "0");
error_reporting(E_ALL);
header('content-type: image/png');

if ( isset($_SESSION['graph']) ) {
	$graph = unserialize($_SESSION['graph']);
} else {
	$graph = new Graph();
}

//Image
$size = $graph->size;
$image = imagecreate($size, $size);

//Colors
$back = imagecolorallocate($image, 0, 34, 43);
$red = imagecolorallocate($image, 255, 0, 0);
$blue = imagecolorallocate($image, 128, 229, 255);
 
imagesetthickness($image, 2);
 
//Graph Data
$vertices = $graph->getVertices();
$edges = $graph->getEdges();

//Paint the edges
foreach ($edges as $line) {
	$coords = $line->coords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
		$red );
}

//Paint the points
foreach ($vertices as $point) {
	$coords = $point->coords();
	ImageFilledEllipse($image, 
		$coords["x"], 
		$coords["y"], 
		6, 6, $blue);
}

//border
//imageLine($image,0,0,0,$size, $red);
//imageLine($image,0,0,$size,0, $red);
//imageLine($image,$size-1,$size-1,0,$size-1, $red);
//imageLine($image,$size-1,$size-1,$size-1,0, $red);

imagepng($image);
imagedestroy($image);

?>