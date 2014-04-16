<?php
	include_once 'GraphClass/Graph.php';
	include_once 'GraphClass/Triangle.php';
	include_once 'Algorithms/Deluanay.php';
	include_once 'Algorithms/ConvexHull.php';
	include_once 'Algorithms/Dijkstras.php';
	include_once 'Algorithms/Midpoint.php';

	if (isset($_POST['circles']) && $_POST['circles'] == 1) {
		if (session_id() == "") { //There is no active session
			session_start();
		}
		$_SESSION['circles'] = $circles = 1;
	} else {
		$_SESSION['circles'] = $circles = 0;
	}
?>

<head>
	<link type="text/css" rel="stylesheet" href="CSS/topstyle.css" />
</head>

<body>
<?php
	$imagesize = isset($_POST['maxsize']) ? $_POST['maxsize'] : 500;
	$n = isset($_POST['points']) ? $_POST['points'] : 50;

	$graph = new Graph($imagesize);
	$graph2 = new Graph($imagesize);

	for ($i = 1; $i <= $n; $i++) {
		$x = rand(2, $imagesize-2);
		$y = rand(2, $imagesize-2);
		$graph->addVertex( new Vertex($x, $y) );
		$graph2->addVertex( new Vertex($x, $y) );
	}
	$graph->removeDuplicateVertices();
	$graph2->removeDuplicateVertices();

	Deluanay::triangulate($graph);
	$graph2 = clone $graph;

	echo " 	<table> <tr> <td width=" . $imagesize . ">";
	echo "<font color='yellow'>";

	//Compute the algorithm in $_POST['algorithm_1'], alternatively triangulates
	$algorithm_1 = isset($_POST['algorithm_1']) ? $_POST['algorithm_1'] : "deluanay";
	switch($algorithm_1) {
		case "deluanay":
			echo "Triangles:   " . count($graph->getTriangles());
			break;
		case "convex":
			$graph->resetEdges();
			$graph->resetTriangles();
			ConvexHull::addHull($graph);
			echo "Hull Vertices:   " . count($graph->getPath());
			break;
		case "dijkstras":
			$pathVertices = $graph->getPathVertices();
			Dijkstras::addShortestPath($graph, 
				$pathVertices["source"], $pathVertices["dest"]);
			
			$path = $graph->getPath();
			$cost = 0;
			foreach ($path as $p) {
				$v = $p->getVertices();
				$dist = $v["v1"]->distance($v["v2"]);
				$cost += $dist;
			}
			echo "DIJKSTRAS Path Cost:   " . number_format($cost) . "</br>";
			echo "Internal Nodes Visited:   " . (count($path) - 1);
			break;
		case "midpoint":
			$pathVertices = $graph->getPathVertices();
			Midpoint::addPath($graph,
				$pathVertices["source"], $pathVertices["dest"]);
			$path = $graph->getPath();
			$cost = 0;
			foreach ($path as $p) {
				$v = $p->getVertices();
				$dist = $v["v1"]->distance($v["v2"]);
				$cost += $dist;
			}
			echo "MIDPOINT Path Cost:   " . number_format($cost) . "</br>";
			echo "Internal Nodes Visited:   " . (count($path) - 1);
			break;
		case "none":
			$graph->resetEdges();
			$graph->resetPath();
			$graph->resetTriangles();
			echo "Unique Nodes:  " . (count($graph->getVertices()));
			break;
	}

	echo "</font>";
	echo "</td> <td width=" . $imagesize . ">";
	echo "<font color='red'>";

	//Compute the algorithm in $_POST['algorithm_2'], alternatively triangulates
	$algorithm_2 = isset($_POST['algorithm_2']) ? $_POST['algorithm_2'] : "deluanay";
	switch($algorithm_2) {
		case "off":
			break;
		case "deluanay":
			echo "Triangles:   " . count($graph2->getTriangles());
			break;
		case "convex":
			$graph2->resetEdges();
			$graph2->resetTriangles();
			ConvexHull::addHull($graph2);
			echo "Hull Vertices:   " . count($graph2->getPath());
			break;
		case "dijkstras":
			$pathVertices = $graph2->getPathVertices();
			Dijkstras::addShortestPath($graph2, 
				$pathVertices["source"], $pathVertices["dest"]);
			
			$path = $graph2->getPath();
			$cost = 0;
			foreach ($path as $p) {
				$v = $p->getVertices();
				$dist = $v["v1"]->distance($v["v2"]);
				$cost += $dist;
			}
			echo "DIJKSTRAS Path Cost:   " . number_format($cost) . "</br>";
			echo "Internal Nodes Visited:   " . (count($path) - 1);
			break;
		case "midpoint":
			$pathVertices = $graph2->getPathVertices();
			Midpoint::addPath($graph2,
				$pathVertices["source"], $pathVertices["dest"]);
			$path = $graph2->getPath();
			$cost = 0;
			foreach ($path as $p) {
				$v = $p->getVertices();
				$dist = $v["v1"]->distance($v["v2"]);
				$cost += $dist;
			}
			echo "MIDPOINT Path Cost:   " . number_format($cost) . "</br>";
			echo "Internal Nodes Visited:   " . (count($path) - 1);
			break;
		case "none":
			$graph2->resetEdges();
			$graph2->resetPath();
			$graph2->resetTriangles();
			echo "Unique Nodes:  " . (count($graph2->getVertices()));
			break;
	}

	echo "</font>";
	echo "</tr> <tr> <td width=" . $imagesize . ">";
	$graph->display_a();
	if ($algorithm_2 != "off") {
		echo "</td> <td width=" . $imagesize . ">";
		$graph2->display_b();
	}
	echo "</td></tr> </table>";

	/*
	// TESTING --------------------------------------------------------
	echo "</br> EDGES: " . count($graph->getEdges()) . "</br>";
	echo "TRIANGLES: " . count($graph->getTriangles()) . "</br>";
	echo "VERTICES: " . count($graph->getVertices()) . "</br>";
	foreach ($graph->getVertices() as $v) {
		foreach ($v->getNeighbors() as $nb) {
			echo $v . " connected to " . $nb . "</br>";
		}
	}
	// TESTING --------------------------------------------------------
	*/
?>

</br>

<form name="regenerate" action="results.php" method="post">
	<input type="hidden" name="maxsize" value=<?php echo $imagesize ?> >
	<input type="hidden" name="points" value=<?php echo $n ?> >
	<input type="hidden" name="circles" value=<?php echo $circles ?> >
	<input type="hidden" name="algorithm_1" value=<?php echo $algorithm_1 ?> >
	<input type="hidden" name="algorithm_2" value=<?php echo $algorithm_2 ?> >
	<input class="button" value="RE-GENERATE" type="submit">
</form>

<form name="back" action="main.php" method="post">
	<input class="button" value="BACK TO FORM" type="submit">
</form>

</body>
