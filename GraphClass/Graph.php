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

	private function storeGraph() {
		$_SESSION['vertices'] = $this->vertices;
		$_SESSION['edges'] = $this->edges;
	}

	public function postGraph() {
		$this->storeGraph();
		echo "<img src='display.php' alt='graph'>";
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
		print_r($min_y->coords());
		return $min_y;
	}

	//Return next counter-clockwise radial vertex from input vertex
	public function getNextRadialVertex(Vertex $current, $last_angle) {
		$min_angle_vertex = $this->vertices[0];
		$min_angle = 2*pi();
		$current_x = $current->coords()["x"];
		$current_y = $current->coords()["y"];
		$epsilon = .001;
		//echo "STARTING THETA: ".$min_angle."</br>";
		//echo "STARTING X: ".$current_x."</br>";
		//echo "STARTING Y: ".$current_y."</br> </br>";
		foreach ($this->vertices as $vertex) {
			if ($vertex != $current) {
				$vertex_x = $vertex->coords()["x"];
				$vertex_y = $vertex->coords()["y"];
				$diff_x = abs($current_x - $vertex_x);
				$diff_y = abs($current_y - $vertex_y);
				$hypotenuse = sqrt( pow($diff_x, 2) + pow($diff_y, 2) );

				//echo "this x: " . $vertex_x . "</br>";
				//echo "this y: " . $vertex_y . "</br>";
				//echo "LENGTH: " . $diff_x . "</br>";
				//echo "HEIGHT: " . $diff_y . "</br>";
				//echo "HYPOTENUSE: " . $hypotenuse . "</br>";

				if ( ($vertex_x>$current_x) && ($vertex_y<=$current_y) ) {
					$theta = asin($diff_y/$hypotenuse);
				} else if ( ($vertex_x<=$current_x) && ($vertex_y<$current_y) ) {
					$theta = asin($diff_x/$hypotenuse) + pi()/2;
				} else if ( ($vertex_x<$current_x) && ($vertex_y>=$current_y) ) {
					$theta = asin($diff_y/$hypotenuse) + pi();
				} else if ( ($vertex_x>=$current_x) && ($vertex_y>$current_y) ) {
					$theta = asin($diff_x/$hypotenuse) + ((3/2) * pi());
				}

				//echo "ANGLE: " . $theta . "</br>";
				//echo "Last-angle: " .$last_angle . "</br>";
				//echo "min-angle: " .$min_angle . "</br>";
				if (($theta < $min_angle) && ($theta >= $last_angle)) {
					$min_angle_vertex = $vertex;
					$min_angle = $theta;
					//echo "new min angle at (".$vertex_x.", ".$vertex_y.")";
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
			//echo "Next Vertex is: (". $next_vertex->coords()["x"] . ", " . $next_vertex->coords()["y"] . ") </br>";
			$next_angle = $next["angle"];
			$this->addEdge(new Edge($current, $next_vertex));
			$current = $next_vertex;
			$angle = $next_angle;
			$check++;
		} while ( ($current != $lowest) && ($check < 200) );
		echo "</br>check = ".$check."</br>";
	}

} ?>

