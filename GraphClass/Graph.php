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
		foreach ($this->vertices as &$vertex) {
			// "Lowest" vertex has LARGEST y-coordinate value
			if ( $vertex->coords()["y"] > $min_y->coords()["y"] ) {
				$min_y = $vertex;
			}
		}
		return $min_y;
	}

	//Counter-clockwise radial sorting for use with Gift-Wrapping Hull procedure
	public function sortRadially() {
		$lowestVertex = $this->getLowestVertex();
		$pivotVertex = $this->vertices[0];
		$lower = array();
		$upper = array();
		foreach ($this->vertices as $vertex) {
			//TODO here
		}
	}

	public function addHull() {
	}

} ?>

