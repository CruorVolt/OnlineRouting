<?php

require_once 'GraphClass/Graph.php';

class Deluanay {
	
	public static function triangulate(Graph $graph) {
		$graph->resetEdges();
		$vertices = $graph->getVertices();
		$gridsize = $graph->size;
		
		// Outlier vertices for starting triangulation
		//$outlier_1 = new Vertex(0, 0);
		//$outlier_2 = new Vertex(0, $gridsize* 2);
		//$outlier_3 = new Vertex($gridsize * 2, 0);
		//$super = new Triangle($outlier_1, $outlier_2, $outlier_3);
		//$graph->addTriangle($super);

		$triangle = new Triangle($vertices[0], $vertices[1], $vertices[2]);
		$graph->addTriangle($triangle);
		$graph->resetVertices();
		$center = new Vertex($gridsize/2, $gridsize/2);
		$graph->addVertex($center);
		if ($triangle->isInCircle($center)) {
			echo "INSIDE CIRCLE";
		} else {
			echo "OUTSIDE CIRCLE";
		}
		echo "</br>";

		return $graph;
	}

	public static function circumcircle(Triangle $triangle) {
	}
}
?>
