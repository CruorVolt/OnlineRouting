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
$image = imagecreatetruecolor($size, $size);
imageantialias($image, true); //Only works with true-color images

//Colors
$back = imagecolorallocate($image, 0, 34, 43);
imagefill($image, 0, 0, $back);

$red = imagecolorallocate($image, 255, 0, 0);
$darkred = imagecolorallocate($image, 170, 0, 0);
$palered = imagecolorallocate($image, 255, 85, 85);
$blue = imagecolorallocate($image, 128, 229, 255);
$darkblue = imagecolorallocate($image, 1, 190, 246);
$white = imagecolorallocate($image, 187, 187, 187);
$green = imagecolorallocate($image, 77, 255, 0);
$yellow = imagecolorallocate($image, 255, 255, 0);

//Paint the edges
foreach ($graph->getEdges() as $line) {
	$coords = $line->coords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
		$darkblue );
}

imagesetthickness($image, 2);

//Paint the circumcircles
if ($_SESSION['circles'] == 1) {
	imagesetthickness($image, 1);
	foreach ($graph->getTriangles() as $triangle) {
		$radius = $triangle->c_radius;
		if ($raidus < 1000) { // Visual bug with larger circles
			$diameter = $radius*2;
			$c_coords = $triangle->c_circumcenter->coords();
			imageellipse($image, $c_coords["x"], $c_coords["y"], 
				$diameter, $diameter, $white);
		}
	}
	imagesetthickness($image, 2);
}


//Paint the points
foreach ($graph->getVertices() as $point) {
	$coords = $point->coords();
	ImageFilledEllipse($image, 
		$coords["x"], 
		$coords["y"], 
		5, 5, $yellow);
}

imageantialias($image, false); //Turn off smoothing

//Paint the path
imagesetthickness($image, 3);
foreach ($graph->getPath() as $line) {
	$coords = $line->coords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
		$yellow );
}
imagesetthickness($image, 2);

//Highlght the s,t vertices
$st = $graph->getPathVertices();
$s = $st["source"];
$s_coords = $s->coords();
$t = $st["dest"];
$t_coords = $t->coords();
ImageFilledEllipse($image, $s_coords["x"], $s_coords["y"], 7, 7, $red);
ImageFilledEllipse($image, $t_coords["x"], $t_coords["y"], 7, 7, $green);


//border
if ($_SESSION['circles'] == 1 ) {
	imagesetthickness($image, 3);
	imageLine($image,0,0,0,$size, $darkred);
	imageLine($image,0,0,$size,0, $darkred);
	imageLine($image,$size-1,$size-1,0,$size-1, $darkred);
	imageLine($image,$size-1,$size-1,$size-1,0, $darkred);
}

imagepng($image);
imagedestroy($image);

?>
