<?php

include_once 'Vertex.php';
include_once 'Edge.php';

ini_set ("display_errors", "1");
error_reporting(E_ALL);
header('content-type: image/png');
session_start();
 
//Image
$size = isset($_SESSION['imagesize']) ? $_SESSION['imagesize'] : 500;
$image = imagecreate($size, $size);
 
//Colors
$back = imagecolorallocate($image, 0, 34, 43);
$fore = imagecolorallocate($image, 255, 0, 0);

//border
imageLine($image,0,0,0,$size, $fore);
imageLine($image,0,0,$size,0, $fore);
imageLine($image,$size-1,$size-1,0,$size-1, $fore);
imageLine($image,$size-1,$size-1,$size-1,0, $fore);

//Graph Data
if (isset($_SESSION['vertices'])) { $vertices = $_SESSION['vertices']; }
	else { $vertices = array(); }
if (isset($_SESSION['edges'])) { $edges = $_SESSION['edges']; }
	else { $edges = array(); }

//Paint the points
foreach ($vertices as $point) {
	ImageFilledEllipse($image, $point->coords()["x"], 
		$point->coords()["y"], 5, 5, $fore);
}

//Paint the edges
foreach ($edges as $line) {
	$coords = $line->getCoords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
	       	$fore );
}

imagepng($image);
imagedestroy($image);
?>

