<?php

require_once 'GraphClass/Graph.php';

class ApexAngle {

	// Apex-Angle routes to destination for all DTs
	public static function addPath(Graph $graph, Vertex $source, Vertex $destination) {
		$current = $source;
		while ( !($current->isEqual($destination)) ) {
			foreach ($current->getNeighbors() as $neighbor) { 
				if ("nieghbor has a larger <vwt than previous ones") {
					$next = $neighbor;
				}
			}
		}
	}

	private static function compareAngles(Vertex $s, Vertex $t) {
	}

}

?>
