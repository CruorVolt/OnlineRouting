<?php

include_once 'Edge.php';
include_once 'Vertex.php';

class Triangle {

	private $edge_1, $edge_2, $edge_3;
	private $vertex_a, $vertex_b, $vertex_c;
	public $c_circumcenter;
	public $c_radius;
	
	public function __construct($v1, $v2, $v3) {
		$this->vertex_a = $v1; 
		$this->vertex_b = $v2; 
		$this->vertex_c = $v3; 
		$this->edge_1 = new Edge($v1, $v2);
		$this->edge_2 = new Edge($v2, $v3);
		$this->edge_3 = new Edge($v3, $v1);
		$this->constructCircumcircle();
	}

	public function __toString() {
		return "Triangle: " . $this->vertex_a . ", " . 
			$this->vertex_b . ", " . $this->vertex_c;
	}

	public function getEdges() {
		return array($this->edge_1, $this->edge_2, $this->edge_3);
	}

	public function getVertices() {
		return array($this->vertex_a, $this->vertex_b, $this->vertex_c);
	}

	public function isInCircle(Vertex $vertex) {
		$in = FALSE;
		$center_coords = $this->c_circumcenter->coords();
		$vertex_coords = $vertex->coords();
		$distance_from_center = 
			sqrt( pow(($vertex_coords["x"] - $center_coords["x"]),2) 
			+ pow(($vertex_coords["y"] - $center_coords["y"]),2) );
		if ($distance_from_center < $this->c_radius) {
			$in = TRUE;
		}
		return $in;
	}

	private function constructCircumcircle() {
		$a_coords = $this->vertex_a->coords();
		$b_coords = $this->vertex_b->coords();
		$c_coords = $this->vertex_c->coords();

		$ax = $a_coords["x"];
		$ay = $a_coords["y"];
		$bx = $b_coords["x"];
		$by = $b_coords["y"];
		$cx = $c_coords["x"];
		$cy = $c_coords["y"];
		
		//CALCULATE CIRCUMCENTER VERTEX
		$d = 2 * ( $ax * ($by - $cy) + $bx * ($cy - $ay) + $cx * ($ay - $by) );
		
		if ($d != 0) {
			$center_x = ( (pow($ax,2) + pow($ay,2)) * ($by - $cy) 
				+ (pow($bx,2) + pow($by,2)) * ($cy - $ay) 
				+ (pow($cx,2) + pow($cy,2)) * ($ay - $by) ) / $d;

			$center_y = ( (pow($ax,2) + pow($ay,2)) * ($cx - $bx) 
				+ (pow($bx,2) + pow($by,2)) * ($ax - $cx) 
				+ (pow($cx,2) + pow($cy,2)) * ($bx - $ax) ) / $d;
		} else { 
			echo "3 COLINEAR POINTS! WHAT SHOULD I DO? </br>";
		}

		$this->c_circumcenter = new Vertex($center_x, $center_y);

		//CALCULATE CIRCUMCIRCLE RADIUS
		$this->c_radius = sqrt( pow(($ax-$center_x),2) + pow(($ay-$center_y),2) );
	}
}

?>
