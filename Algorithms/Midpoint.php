<?php

require_once 'GraphClass/Graph.php';

class Midpoint {

	//Midpoint algorithm reaches destination for all DTs
	public static function addPath(Graph $graph, Vertex $source, Vertex $destination) {
		$current = $source;
		while ( !($current->isEqual($destination)) ) {
			$midpoint = Midpoint::getMidpoint($current, $destination);
			$neighbors = $current->getNeighbors();
			$min_distance = INF;
			$next = $current;
			foreach ( $neighbors as $neighbor ) {
				if ($neighbor->isEqual($destination)) {
					$graph->addPathEdge( new Edge($current, $neighbor) );
					return;
				}
				$distance = $neighbor->distance($midpoint);
				if ($distance < $min_distance) {
					$next = $neighbor;
					$min_distance = $distance;
				}
			}
			$graph->addPathEdge( new Edge($current, $next) );
			$current = $next;
		}
	}

	private static function getMidpoint(Vertex $s, Vertex $t) {
		$s_coords = $s->coords();
		$t_coords = $t->coords();
		$x = ( $s_coords["x"] + $t_coords["x"] ) / 2;
		$y = ( $s_coords["y"] + $t_coords["y"] ) / 2;
		return new Vertex($x, $y);
	}

}

?>
