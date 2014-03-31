<?php 

session_start();

include_once 'Vertex.php';
include_once 'Edge.php';
include_once 'Graph.php';

class GraphImage {

	private $image;
	private $back;
	private $red;
	private $blue;

	public function __construct(Graph $graph, $image) {
		ini_set ("display_errors", "1");
		error_reporting(E_ALL);
		header('content-type: image/png');

		//Image
		$size = 200;
		$this->image = imagecreate($size, $size);

		//Colors
		$this->back = imagecolorallocate($this->image, 0, 34, 43);
		$this->red = imagecolorallocate($this->image, 255, 0, 0);
		$this->blue = imagecolorallocate($this->image, 128, 229, 255);
	}

	public static function display() {
		 
		imagesetthickness($image, 2);
		 
		//Graph Data
		$vertices = $this->graph->getVertices();
		$edges = $this->graph->getEdges();

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
			ImageFilledEllipse($image, $point->coords()["x"], 
				$point->coords()["y"], 6, 6, $blue);
		}

		//border
		//imageLine($image,0,0,0,$size, $red);
		//imageLine($image,0,0,$size,0, $red);
		//imageLine($image,$size-1,$size-1,0,$size-1, $red);
		//imageLine($image,$size-1,$size-1,$size-1,0, $red);

		imagepng($image);
		imagedestroy($image);

	}
} ?>
