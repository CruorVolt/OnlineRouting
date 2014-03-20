<?php class Vertex {
	private $x = 0;
	private $y = 0;

	public function __construct($x_coord, $y_coord) {
		$this->x = $x_coord;
		$this->y = $y_coord;
	}

	public function __toString() {
		return "(".$this->x.", ".$this->y.")";
	}

	public function coords() {
		return array( "x" => $this->x, "y" => $this->y );
	}
} ?>
