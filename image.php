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
$darkblue = imagecolorallocate($image, 100, 100, 255);
 
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
		$radius = $triangle->c_radius;
		if ($raidus < 1000) { // Visual bug with larger circles
			$diameter = $radius*2;
			$c_coords = $triangle->c_circumcenter->coords();
			imageellipse($image, $c_coords["x"], $c_coords["y"], 
				$diameter, $diameter, $darkblue);
		}
	}
}

//Paint the points
foreach ($graph->getVertices() as $point) {
	$coords = $point->coords();
	ImageFilledEllipse($image, 
		$coords["x"], 
		$coords["y"], 
		6, 6, $blue);
}

//border
imageLine($image,0,0,0,$size, $darkblue);
imageLine($image,0,0,$size,0, $darkblue);
imageLine($image,$size-1,$size-1,0,$size-1, $darkblue);
imageLine($image,$size-1,$size-1,$size-1,0, $darkblue);

imagepng($image);
imagedestroy($image);

//Reset session (Why is this necessary?);
$_SESSION['circles'] = 0;

?>
