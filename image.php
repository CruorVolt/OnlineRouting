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
$darkred = imagecolorallocate($image, 170, 0, 0);
$palered = imagecolorallocate($image, 255, 85, 85);
$blue = imagecolorallocate($image, 128, 229, 255);
$darkblue = imagecolorallocate($image, 1, 190, 246);
$white = imagecolorallocate($image, 187, 187, 187);

//let s:White	=	['#ffffff', '#dddddd', '#bbbbbb']
//let s:Black	=	['#000000', '#001621', '#1B3641', '#00222B']
//let s:DarkBlue	=	['#00117B', '#0D4CAD', '#01BEF6']
//let s:LightBlue	=	['#004455', '#0088AA', '#00CCFF', '#55DDFF', '#80E5FF']
//let s:Red	=	['#2b0000', '#800000', '#AA0000', '#FF0000', '#FF2A2A', '#FF5555']
 
imagesetthickness($image, 2);
 
//Paint the edges
foreach ($graph->getEdges() as $line) {
	$coords = $line->coords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
		$red );
}

//Paint the triangles
foreach ($graph->getTriangles() as $triangle) {
	$t_edges = $triangle->getEdges();
	foreach ($t_edges as $line) {
		$coords = $line->coords();
		ImageLine( $image, 
			$coords["v1"]["x"], $coords["v1"]["y"],
			$coords["v2"]["x"], $coords["v2"]["y"],
			$red );
	}
	
	//Paint the circumcircles
	if ($_SESSION['circles'] == 1) {
		imagesetthickness($image, 1);
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
		6, 6, $darkblue);
}

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

//Reset session (Why is this necessary?);
$_SESSION['circles'] = 0;

?>
