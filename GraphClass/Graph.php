<?php 

include_once 'Vertex.php';
include_once 'Triangle.php';
include_once 'Edge.php';

class Graph {
	
	private $edges = array();
	private $vertices = array();
	private $triangles = array();

	public $size;

	public function __construct($gridsize = 550, 
				$vertex_array = array(), 
				$edges_array = array() ) {
		$this->edges = $edges_array;
		$this->vertices = $vertex_array;
		$this->size=$gridsize;
	}

	public function spit() {
		echo "Vertices: " . count($this->vertices) . "</br>";
		echo "Raw Edges: " . count($this->edges) . "</br>";
		echo "Triangles: " . count($this->triangles) . "</br>";
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

		$vertices = $edge->getVertices();
		$v1 = $vertices["v1"];
		$v2 = $vertices["v2"];
		$v1_key = $v1->__toString();
		$v2_key = $v2->__toString();

		$this->vertices[$v1_key]->addNeighbor($v2);
		$this->vertices[$v2_key]->addNeighbor($v1);
	}

	public function addVertex($vertex) {
		// Array key is string representation of vertex
		$this->vertices[$vertex->__toString()] = $vertex; 
		//$this->vertices[] = $vertex;
	}

	public function addTriangle($triangle) {
		$this->triangles[] = $triangle;
	}

	public function getEdges() {
		return $this->edges;
	}

	public function getVertices() {
		return $this->vertices;
	}

	public function getTriangles() {
		return $this->triangles;
	}

	public function getPathVertices() {
		$min_sum = $this->size * 2;
		$max_sum = 0;
		foreach ($this->vertices as $vertex) {
			$coords = $vertex->coords();
			$sum = $coords["x"] + $coords["y"];
			if ($sum > $max_sum) {
				$max_vertex = $vertex;
				$max_sum = $sum;
			} else if ($sum < $min_sum) {
				$min_vertex = $vertex;
				$min_sum = $sum;
			}
		}
		return array("source"=>$min_vertex, "dest"=>$max_vertex);
	}

	public function resetEdges() {
		$this->edges = array();
	}

	public function resetVertices() {
		$this->vertices = array();
	}

	public function hasEdge(Edge $new) {
		foreach ($this->edges as $edge) {
			if ($edge->isEqual($new)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function removeDuplicateVertices() {
		$this->vertices = array_unique($this->vertices);
	}
} 
?>
