<?php

require_once 'GraphClass/Graph.php';

class TwoStep{
	
	public static function addPath(Graph $graph, Vertex $vertex_start, Vertex $vertex_finish) {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$vertices = $graph->getVertices();
		$gridsize = $graph->size;
		
		$neighbors = $vertex_start->getNeighbors();
		$start_distance = $vertex_start->distance($vertex_finish);
		$min_distance  = INF;
		$min_vertex = null;
		foreach ($neighbors as $neighbor) {
			if ($neighbor->isEqual($vertex_finish)) {
				$graph->addPathEdge( new Edge($vertex_start, $neighbor) );
				return;
			} else {
				$distance = $neighbor->distance($vertex_finish);
				if($distance < $start_distance){
					$sum = $distance + $neighbor->distance($vertex_start);
					if ( $sum < $min_distance){
						$min_distance = $sum;
						$min_vertex = $neighbor;
					}
				}
			}
		}
		$graph->addPathEdge( new Edge($vertex_start, $min_vertex) );
		TwoStep::addPath($graph, $min_vertex, $vertex_finish);
	}

}
?>
