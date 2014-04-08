<?php class Vertex {
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

	public function coords() {
		return array( "x" => $this->x, "y" => $this->y );
	}

	public function distance(Vertex $destination) {
		$d_coords = $destination->coords();
		$dx = $d_coords["x"];
		$dy = $d_coords["y"];
		return sqrt( pow(($this->x - $dx),2) + pow(($this->y - $dy),2) );
	}
} ?>
