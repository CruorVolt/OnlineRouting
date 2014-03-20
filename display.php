<?php

include_once 'Vertex.php';
include_once 'Edge.php';

ini_set ("display_errors", "1");
error_reporting(E_ALL);
header('content-type: image/png');
session_start();
 
//Image
if (isset($_SESSION['imagesize'])) {
	$size = $_SESSION['imagesize'];
} else {
	$size = 500;
}
$image = imagecreate($size, $size);
 
//Colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

//border
imageLine($image,0,0,0,500, $black);
imageLine($image,0,0,500,0, $black);
imageLine($image,499,499,0,499, $black);
imageLine($image,499,499,499,0, $black);

//Graph Data
if (isset($_SESSION['vertices'])) { $vertices = $_SESSION['vertices']; }
	else { $vertices = array(); }
if (isset($_SESSION['edges'])) { $edges = $_SESSION['edges']; }
	else { $edges = array(); }

//Paint the points
foreach ($vertices as $point) {
	ImageFilledEllipse($image, $point->coords()["x"], 
		$point->coords()["y"], 5, 5, $black);
}

//Paint the edges
foreach ($edges as $line) {
	$coords = $line->getCoords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
	       	$black );
}

imagepng($image);
imagedestroy($image);
?>

