<?php

include_once "GraphClass/Graph.php";

class Dijkstras {

	public static function addShortestPath(Graph $graph, 
		Vertex $origin, Vertex $destination) {

 		//WILL TAKE SAME KEYS AS VERTICES
		$visited = array();
		$distance = array();
		$previous = array();

		$vertices = $graph->getVertices();
		foreach ($vertices as $vertex) {
			$distance[$vertex->__toString()] = INF; 
			$previous[$vertex->__toString()] = NULL;
		}

		$distance[$origin->__toString()] = 0;

		while ( count($vertices) > 0 ) {
			$min = INF;
			foreach($vertices as $vertex) {
				$d = $distance[$vertex->__toString()];
				if ($d < $min) {
					$min_vertex = $vertex;
					$min = $d;
				}
			}
			unset($vertices[$min_vertex->__toString()]);
			$vertices = array_filter($vertices);
			if ($distance[$min_vertex->__tostring()] == INF) {
				break;
			}

			foreach ($min_vertex->getNeighbors() as $neighbor) {
				$route = $distance[$min_vertex->__toString()] 
					+ $min_vertex->distance($neighbor);
				if ($route < $distance[$neighbor->__toString()]) {
					$distance[$neighbor->__toString()] = $route;
					$previous[$neighbor->__toString()] = $min_vertex;
					//decrease-key
				}
			}
		}

		return $graph;
	}
}

?>
