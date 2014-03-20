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
		return $this->vertices();
	}

	private function storeGraph() {
		$_SESSION['vertices'] = $this->vertices;
		$_SESSION['edges'] = $this->edges;
	}

	public function postGraph() {
		$this->storeGraph();
		echo "<img src='display.php' alt='graph'>";
	}

} ?>

