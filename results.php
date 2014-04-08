<?php
	include_once 'GraphClass/Graph.php';
	include_once 'GraphClass/Triangle.php';
	include_once 'Algorithms/Deluanay.php';
	include_once 'Algorithms/ConvexHull.php';

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

	$graph = Deluanay::triangulate($graph);

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
	<input class="button" value="RE-GENERATE" type="submit">
</form>

<form name="back" action="main.php" method="post">
	<input class="button" value="BACK TO FORM" type="submit">
</form>

</body>
