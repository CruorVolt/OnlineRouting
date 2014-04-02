<?php 

include_once 'Vertex.php';
include_once 'Edge.php';

class Graph {
	
	private $edges = array();
	private $vertices = array();

	public $size;

	public function __construct($gridsize = 550, 
				$vertex_array = array(), 
				$edges_array = array() ) {
		$this->edges = $edges_array;
		$this->vertices = $vertex_array;
		$this->size=$gridsize;
	}

	public function display() {
		if (session_id() == "") { //There is no active session
			session_start();
		}
		$stored_graph = serialize($this);
		$_SESSION['graph'] = $stored_graph;
		echo "<img src='../image.php' alt='graph'>";
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

	public function resetEdges() {
		$this->edges = array();
	}

	/* Get a starging vertex for convex-hull procedure */
	public function getLowestVertex() {
		$min_y = $this->vertices[0];
		foreach ($this->vertices as $vertex) {
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
	public function getNextRadialVertex(Vertex $current, $last_angle) {
		$min_angle_vertex = $this->vertices[0];
		$min_angle = 2*pi();
		$c_coords = $current->coords();
		$current_x = $c_coords["x"];
		$current_y = $c_coords["y"];
		$epsilon = .001;
		foreach ($this->vertices as $vertex) {
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
} 
?>
