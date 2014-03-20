<?php

include_once 'GraphClass/Vertex.php';
include_once 'GraphClass/Edge.php';

ini_set ("display_errors", "1");
error_reporting(E_ALL);
header('content-type: image/png');
session_start();
 
//Image
$size = isset($_SESSION['imagesize']) ? $_SESSION['imagesize'] : 500;
$image = imagecreate($size, $size);
 
//Colors
$back = imagecolorallocate($image, 0, 34, 43);
$red = imagecolorallocate($image, 255, 0, 0);
$blue = imagecolorallocate($image, 128, 229, 255);

//border
imageLine($image,0,0,0,$size, $red);
imageLine($image,0,0,$size,0, $red);
imageLine($image,$size-1,$size-1,0,$size-1, $red);
imageLine($image,$size-1,$size-1,$size-1,0, $red);

//Graph Data
if (isset($_SESSION['vertices'])) { $vertices = $_SESSION['vertices']; }
	else { $vertices = array(); }
if (isset($_SESSION['edges'])) { $edges = $_SESSION['edges']; }
	else { $edges = array(); }

//Paint the points
foreach ($vertices as $point) {
	ImageFilledEllipse($image, $point->coords()["x"], 
		$point->coords()["y"], 5, 5, $blue);
}

//Paint the edges
foreach ($edges as $line) {
	$coords = $line->getCoords();
	ImageLine( $image, 
		$coords["v1"]["x"], $coords["v1"]["y"],
		$coords["v2"]["x"], $coords["v2"]["y"],
	       	$red );
}

imagepng($image);
imagedestroy($image);
?>

