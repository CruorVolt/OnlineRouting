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
			$distance[$vertex->key()] = INF; 
			$previous[$vertex->key()] = NULL;
		}

		$distance[$origin->key()] = 0;

		while ( count($vertices) > 0 ) {
			$min = INF;
			foreach($vertices as $vertex) {
				$d = $distance[$vertex->key()];
				if ($d < $min) {
					$min_vertex = $vertex;
					$min = $d;
				}
			}
			unset($vertices[$min_vertex->key()]);
			$vertices = array_filter($vertices);
			if ($distance[$min_vertex->key()] == INF) {
				break;
			}

			foreach ($min_vertex->getNeighbors() as $neighbor) {
				$route = $distance[$min_vertex->key()] 
					+ $min_vertex->distance($neighbor);
				if ($route < $distance[$neighbor->key()]) {
					$distance[$neighbor->key()] = $route;
					$previous[$neighbor->key()] = $min_vertex;
					//decrease-key TODO: WHAT?
				}
			}
		}
		//Here distance and previous are correct for all nodes
		$path = array();
		$current = $destination;
		while ($previous[$current->key()] != NULL) {
			$path_edge = new Edge($current, $previous[$current->key()]);
			$graph->addPathEdge($path_edge);
			$current = $previous[$current->key()];
		}
		
		return $graph;
	}
}

?>
