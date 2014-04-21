<?php

require_once 'GraphClass/Graph.php';

class ApexAngle {

	// Apex-Angle routes to destination for all DTs
	public static function addPath(Graph $graph, Vertex $source, Vertex $destination) {
		$current = $source;
		while ( !($current->isEqual($destination)) ) {
			$st_angle = ApexAngle::getAngle($current, $destination);
			$min_difference = 2 * pi();
			foreach ($current->getNeighbors() as $neighbor) { 
				$neighbor_angle = ApexAngle::getAngle($current, $neighbor);
				$difference = abs( $st_angle - $neighbor_angle );
				if ($difference > pi() ) { //Difference crosses 0/2pi line
					$difference = abs( (2 * pi()) + $neighbor_angle);
				}
				if ( $difference < $min_difference) {
					$min_difference = $difference;
					$next = $neighbor;
				}
			}
			$path = new Edge($current, $next);
			$graph->addPathEdge($path);
			$current = $next;
		}
	}

	public static function getAngle(Vertex $source, Vertex $dest) {
		$s_coords = $source->coords();
		$t_coords = $dest->coords();

		$s_x = $s_coords["x"];
		$s_y = $s_coords["y"];
		$t_x = $t_coords["x"];
		$t_y = $t_coords["y"];

		$diff_x = abs($s_x - $t_x);
		$diff_y = abs($s_y - $t_y);
		$hypotenuse = sqrt( pow($diff_x, 2) + pow($diff_y, 2) );

		if ( ($t_x>$s_x) && ($t_y<=$s_y) ) {
			$theta = asin($diff_y/$hypotenuse);
		} else if ( ($t_x<=$s_x) && ($t_y<$s_y) ) {
			$theta = asin($diff_x/$hypotenuse) + pi()/2;
		} else if ( ($t_x<$s_x) && ($t_y>=$s_y) ) {
			$theta = asin($diff_y/$hypotenuse) + pi();
		} else if ( ($t_x>=$s_x) && ($t_y>$s_y) ) {
			$theta = asin($diff_x/$hypotenuse) + ((3/2) * pi());
		}
		return $theta;
	}


}

?>
