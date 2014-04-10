<?php
	include_once 'GraphClass/Graph.php';
	include_once 'GraphClass/Triangle.php';
	include_once 'Algorithms/Deluanay.php';
	include_once 'Algorithms/ConvexHull.php';
	include_once 'Algorithms/Dijkstras.php';

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

	for ($i = 1; $i <= $n; $i++) {
		$x = rand(2, $imagesize-2);
		$y = rand(2, $imagesize-2);
		$graph->addVertex( new Vertex($x, $y) );
	}
	$graph->removeDuplicateVertices();

	//Compute the algorithm in $_POST['algorithm'], alternatively triangulates
	$algorithm = isset($_POST['algorithm']) ? $_POST['algorithm'] : "deluanay";
	switch($algorithm) {
		case "deluanay":
			$graph = Deluanay::triangulate($graph);
			break;
		case "convex":
			$graph = ConvexHull::addHull($graph);
			break;
		case "dijkstras":
			$graph = Deluanay::triangulate($graph);
			
			$pathVertices = $graph->getPathVertices();
			$graph = Dijkstras::addShortestPath($graph, 
				$pathVertices["source"], $pathVertices["dest"]);
			
			// COST OUTPUT ----------------------------------------------------------
			$path = $graph->getPath();
			$cost = 0;
			foreach ($path as $p) {
				$v = $p->getVertices();
				$dist = $v["v1"]->distance($v["v2"]);
				$cost += $dist;
			}
			echo "SP Cost = " . number_format($cost) . "</br>";

			$st = $graph->getPathVertices();
			$dist = $st["source"]->distance($st["dest"]);
			echo "Euclidian distance = " . number_format($dist) . "</br>";
			// COST OUTPUT ----------------------------------------------------------
			break;
		case "none":
			break;
	}

	$graph->display();

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
	<input type="hidden" name="algorithm" value=<?php echo $algorithm ?> >
	<input class="button" value="RE-GENERATE" type="submit">
</form>

<form name="back" action="main.php" method="post">
	<input class="button" value="BACK TO FORM" type="submit">
</form>

</body>
