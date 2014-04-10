<?php 

class Vertex {
	private $x = 0;
	private $y = 0;
	private $neighbors;

	public function __construct($x_coord, $y_coord) {
		$this->x = $x_coord;
		$this->y = $y_coord;
		$this->neighbors = array();
	}

	public function __toString() {
		return "(".$this->x.", ".$this->y.")";
	}

	public function key() {
		return $this->__toString();
	}

	public function coords() {
		return array( "x" => $this->x, "y" => $this->y );
	}

	// Graph->addEdge() calls this function
	public function addNeighbor(Vertex $neighbor) {
		$this->neighbors[] = $neighbor;
	}

	public function distance(Vertex $destination) {
		$d_coords = $destination->coords();
		$dx = $d_coords["x"];
		$dy = $d_coords["y"];
		return sqrt( pow(($this->x - $dx),2) + pow(($this->y - $dy),2) );
	}
	
	public function getNeighbors() {
		return $this->neighbors;
	}

	public function isEqual(Vertex $v) {
		$equal = FALSE;
		if ( ($this->x == $v->x) && ($this->y == $v->y) ) {
			$equal = TRUE;
		}
		return $equal;
	}
} ?>
