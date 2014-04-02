<?php

require_once 'GraphClass/Graph.php';

class Deluanay {
	
	public static function triangulate(Graph $graph) {
		$graph->resetEdges();
		
		$vertices = $graph->getVertices();
		$last_vertex = $vertices[0];
		foreach ($vertices as $vertex) {
			$edge = new Edge($last_vertex, $vertex);
			$graph->addEdge($edge);
			$last_vertex = $vertex;
		}
		return $graph;
	}
}
?>
