<?php

require_once 'GraphClass/Graph.php';

class Deluanay {

	public static function triangulate(Graph $graph) {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$graph->resetEdges();
		$graph->resetTriangles();
		$graph->resetPath();
		$vertices = $graph->getVertices();
		$gridsize = $graph->size;
		
		// Outlier vertices for starting triangulation
		$outlier_1 = new Vertex($gridsize/2, -($gridsize * 10000));
		$outlier_2 = new Vertex( -($gridsize * 10000), $gridsize * 10000);
		$outlier_3 = new Vertex( $gridsize * 10000, $gridsize * 10000);
		$super = new Triangle($outlier_1, $outlier_2, $outlier_3);

		$triangle_buffer = array();
		// Initial super-triangle
		$triangle_buffer[] = $super;

		foreach ($vertices as $vertex) {
			$edge_buffer = array();
			foreach ($triangle_buffer as $key => &$triangle) {
				// Check for circumcirlce overlap
				if (isset($triangle_buffer[$key]) && $triangle->isInCircle($vertex)) {
					// Found overlap: Add to edgebuffer
					$t_edges = $triangle->getEdges();
					foreach ($t_edges as $t_edge) {
						$edge_buffer[] = $t_edge;
					}
					// Remove triangle from future consideration
					unset($triangle_buffer[$key]);
				}
			}
			$triangle_buffer = array_filter($triangle_buffer); //Remove unset triangles

			// Reduce edgebuffer to enclosing polygon only
			$n_edges = count($edge_buffer);
			for ($i = 0; $i < $n_edges; $i++) {
				for ($j = $i; $j < $n_edges; $j++) {
					if ( isset($edge_buffer[$i]) && isset($edge_buffer[$j])
						&&($edge_buffer[$i]->isEqual($edge_buffer[$j]))
						&& ($i != $j) ) {
						unset($edge_buffer[$i]);
						unset($edge_buffer[$j]);
					} 
				}
				
			}
			$edge_buffer = array_filter($edge_buffer);

			// Triangulate enclosing polygon with new point
			foreach ($edge_buffer as $new_edge) {
				//echo $new_edge . "</br>";
				$edge_points = $new_edge->getVertices();
				$new_triangle = new Triangle($vertex,
					$edge_points["v1"], $edge_points["v2"]);
				$triangle_buffer[] = $new_triangle;
			}
		}
		// Remove triangles connected to supertriangle
		foreach ($triangle_buffer as $triangle) {
			$t_vertices = $triangle->getVertices();
			$t_edges = $triangle->getEdges();
			if ( !( in_array($outlier_1, $t_vertices) ||
				in_array($outlier_2, $t_vertices) ||
				in_array($outlier_3, $t_vertices) ) ) {

				$graph->addTriangle($triangle);

				foreach ($t_edges as $edge) {
					if (!($graph->hasEdge($edge))) {
						$graph->addEdge($edge);
					}
				}
			
			}
		}
	}
}
?>
