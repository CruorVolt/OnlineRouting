<?php 
session_start();

include_once 'Vertex.php';
include_once 'Edge.php';

class Graph {
	
	private $edges = array();
	private $vertices = array();

	public function __construct($vertex_array, $edges_array) {
		$this->edges = $edges_array;
		$this->vertices = $vertex_array;
	}

	public function addEdge($edge) {
		$this->edges[] = $edge;
	}

	public function addVertex($vertex) {
		$this->vertices[] = $vertex;
	}

	public function getEdges() {
		return $this->edges;
	}

	public function getVertices() {
		return $this->vertices;
	}

	public function getLowestVertex() {
		$min_y = $this->vertices[0];
		foreach ($this->vertices as $vertex) {
			$min_coords = $min_y->coords();
			// "Lowest" vertex has LARGEST y-coordinate value
			$coords = $vertex->coords();
			// Prioritize left-vertex when y-coordinates match
			if ( ( $coords["y"] > $min_coords["y"] ) || 
				(($coords["y"] == $min_coords["y"]) && 
				($coords["x"] <= $min_coords["x"])) ) {
					$min_y = $vertex;
			}
		}
		return $min_y;
	}

	//Return next counter-clockwise radial vertex from input vertex
	public function getNextRadialVertex(Vertex $current, $last_angle) {
		$min_angle_vertex = $this->vertices[0];
		$min_angle = 2*pi();
		$current_x = $current->coords()["x"];
		$current_y = $current->coords()["y"];
		$epsilon = .001;
		foreach ($this->vertices as $vertex) {
			if ($vertex != $current) {
				$vertex_x = $vertex->coords()["x"];
				$vertex_y = $vertex->coords()["y"];
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

	public function addHull() {
		$lowest = $this->getLowestVertex();
		$current = $lowest;
		$angle = 0;
		$check = 0;
		do {
			$next = $this->getNextRadialVertex($current, $angle);
			$next_vertex = $next["vertex"];
			$next_angle = $next["angle"];
			$this->addEdge(new Edge($current, $next_vertex));
			$current = $next_vertex;
			$angle = $next_angle;
			$check++;
		} while ( ($current != $lowest) && ($check < 200) );
	}

} ?>

