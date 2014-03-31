<?php 

include_once 'Vertex.php';

class Edge {
	private $v1;
	private $v2;

	public function __construct($vertex_1, $vertex_2) {
		$this->v1 = $vertex_1;
		$this->v2 = $vertex_2;
	}

	public function coords() {
		return array( "v1" => $this->v1->coords(),
			      "v2" => $this->v2->coords() );
	}

	public function __toString() {
		return "Edge between points ".$this->v1." and ".$this->v2.".";
	}
}
