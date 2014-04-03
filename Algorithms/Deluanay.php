<?php

require_once 'GraphClass/Graph.php';

class Deluanay {
	
	public static function triangulate(Graph $graph) {
		$graph->resetEdges();
		$vertices = $graph->getVertices();
		$gridsize = $graph->size;
		
		// Outlier vertices for starting triangulation
		$outlier_1 = new Vertex(0, 0);
		$outlier_2 = new Vertex(0, $gridsize* 2);
		$outlier_3 = new Vertex($gridsize * 2, 0);
		$super = new Triangle($outlier_1, $outlier_2, $outlier_3);
		$graph->addTriangle($super);

		/*
		// TESTING CIRCUMCIRCLES ---------------------------------------------
		//--------------------------------------------------------------------
		$triangle = new Triangle($vertices[0], $vertices[1], $vertices[2]);
		echo "Triangle corners: "
			. $vertices[0] . ", " 
			. $vertices[1] . ", "
			. $vertices[2] . "</br>";
		echo "Radius = " . $triangle->c_radius . "</br>";
		$graph->addTriangle($triangle);
		$graph->resetVertices();
		$center = new Vertex($gridsize/2, $gridsize/2);
		echo "Center Vertex: " . $center . "</br>";
		$graph->addVertex($center);
		if ($triangle->isInCircle($center)) {
			echo "INSIDE CIRCLE";
		} else {
			echo "OUTSIDE CIRCLE";
		}
		echo "</br>";
		//--------------------------------------------------------------------
		//--------------------------------------------------------------------
		*/

		//Initialize triangle lise
		$triangle_buffer = array();
   		//add supertriangle vertices to the end of the vertex list
		array_push($vertices, $outlier_1, $outlier_2, $outlier_3);
   		//add the supertriangle to the triangle list
		$triangle_buffer[] = $super;
		//for each sample point in the vertex list
		foreach ($vertices as $vertex) {
		  	//initialize the edge buffer
			$edge_buffer = array();
		  	//for each triangle currently in the triangle list
			$t = count($triangle_buffer);
			for ($i = 0; $i < $t; $i++) {
				 //calculate the triangle circumcircle center and radius
				 //if the point lies in the triangle circumcircle then
				if ($triangle_buffer[$i]->isInCircle($vertex)) {
				    //add the three triangle edges to the edge buffer
					$t_edges = $triangle_buffer[$i]->getEdges();
					foreach ($t_edges as $t_edge) {
						$edge_buffer[] = $t_edge;
					}
				    	//remove the triangle from the triangle list
					//array_splice($triangle_buffer, $i, 1);
					//$i--;
				} //endif
			} //endfor
		      //delete all doubly specified edges from the edge buffer
			 //this leaves the edges of the enclosing polygon only
		      //add to the triangle list all triangles formed between the point 
			 //and the edges of the enclosing polygon
		} //endfor
		   //remove any triangles from the triangle list that use the supertriangle vertices
		   //remove the supertriangle vertices from the vertex list
		//end

		return $graph;
	}

	public static function circumcircle(Triangle $triangle) {
	}
}
?>
