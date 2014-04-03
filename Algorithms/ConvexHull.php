<?php
class ConvexHull {

	/* Get a starging vertex for convex-hull procedure */
	private static function getLowestVertex(Graph $graph) {
		$vertices = $graph->getVertices();
		$min_y = $vertices[0];
		foreach ($vertices as $vertex) {
			$min_coords = $min_y->coords();
			/* "Lowest" vertex has LARGEST y-coordinate value */
			$coords = $vertex->coords();
			/* Prioritize left-vertex when y-coordinates match */
			if ( ( $coords["y"] > $min_coords["y"] ) || 
				(($coords["y"] == $min_coords["y"]) && 
				($coords["x"] <= $min_coords["x"])) ) {
					$min_y = $vertex;
			}
		}
		return $min_y;
	}

	/* Return next counter-clockwise radial vertex from input vertex */
	private static function getNextRadialVertex(Graph $graph, Vertex $current, $last_angle) {
		$vertices = $graph->getVertices();
		$min_angle_vertex = $vertices[0];
		$min_angle = 2*pi();
		$c_coords = $current->coords();
		$current_x = $c_coords["x"];
		$current_y = $c_coords["y"];
		$epsilon = .001;
		foreach ($vertices as $vertex) {
			if ($vertex != $current) {
				$v_coords = $vertex->coords();
				$vertex_x = $v_coords["x"];
				$vertex_y = $v_coords["y"];
				$diff_x = abs($current_x - $vertex_x);
				$diff_y = abs($current_y - $vertex_y);
				$hypotenuse = sqrt( pow($diff_x, 2) + pow($diff_y, 2) );
				if ( ($vertex_x>$current_x) && ($vertex_y<=$current_y) ) {
					$theta = asin($diff_y/$hypotenuse);
				} else if ( ($vertex_x<=$current_x) && ($vertex_y<$current_y) ) {
					$theta = asin($diff_x/$hypotenuse) + pi()/2;
				} else if ( ($vertex_x<$current_x) && ($vertex_y>=$current_y) ) {
					$theta = asin($diff_y/$hypotenuse) + pi();
				} else if ( ($vertex_x>=$current_x) && ($vertex_y>$current_y) ) {
					$theta = asin($diff_x/$hypotenuse) + ((3/2) * pi());
				}

				if (($theta < $min_angle) && ($theta >= $last_angle)) {
					$min_angle_vertex = $vertex;
					$min_angle = $theta;
				}
			}
		}
		return array("vertex"=>$min_angle_vertex, "angle"=>$min_angle);
	}

	/* Add a convex-hull to the graph */
	public static function addHull(Graph $graph) {
		$lowest = ConvexHull::getLowestVertex($graph);
		$current = $lowest;
		$angle = 0;
		$check = 0;
		do {
			$next = ConvexHull::getNextRadialVertex($graph, $current, $angle);
			$next_vertex = $next["vertex"];
			$next_angle = $next["angle"];
			$graph->addEdge(new Edge($current, $next_vertex));
			$current = $next_vertex;
			$angle = $next_angle;
			$check++;
		} while ( ($current != $lowest) && ($check < 200) );
	return $graph;
	}
}
?>
