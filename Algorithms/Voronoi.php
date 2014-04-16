<?php

class Voronoi {

	//Assumes valid Deluanay triangulation as input
	public static function addCells(Graph $graph) {
		$triangles = $graph->getTriangles();
		foreach ($triangles as $triangle) {
			foreach ($triangles as $neighbor) {
				if ($triangle->sharesEdge($neighbor) ) {
					$cell_edge = new Edge($triangle->c_circumcenter, $neighbor->c_circumcenter);
					$graph->addPathEdge($cell_edge);
					ECHO "Cell edge added: " . $cell_edge . "</br>";
				}
			}
		}
	}
}
