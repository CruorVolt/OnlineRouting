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
	}

	public function addVertex($vertex) {
		$this->vertices[] = $vertex;
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

	public function resetEdges() {
		$this->edges = array();
	}

	public function resetVertices() {
		$this->vertices = array();
	}

	public function removeDuplicateVertices() {
		$this->vertices = array_unique($this->vertices);
	}
} 
?>
