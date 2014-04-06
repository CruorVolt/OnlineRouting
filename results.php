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

	/*
	//------------------------------------------------------
	//------TEST DELUANAY TRIANGULATION---------------------
	$graph_test = new Graph(500);

	$v_0 = new Vertex(439,250);
	$v_1 = new Vertex(284,323);
	$v_2 = new Vertex(195,89);
	$v_3 = new Vertex(38,364);
	$v_4 = new Vertex(445,418);
	$v_5 = new Vertex(412,32);
	$v_6 = new Vertex(110,73);
	$v_7 = new Vertex(257,294);
	$v_8 = new Vertex(477,65);
	$v_9 = new Vertex(420,170);

	$graph_test->addVertex($v_0);
	$graph_test->addVertex($v_1);
	$graph_test->addVertex($v_2);
	$graph_test->addVertex($v_3);
	$graph_test->addVertex($v_4);
	$graph_test->addVertex($v_5);
	$graph_test->addVertex($v_6);
	$graph_test->addVertex($v_7);
	$graph_test->addVertex($v_8);
	$graph_test->addVertex($v_9);

	$graph_test->addEdge(new Edge($v_3, $v_4));
	$graph_test->addEdge(new Edge($v_3, $v_1));
	$graph_test->addEdge(new Edge($v_3, $v_7));
	$graph_test->addEdge(new Edge($v_3, $v_6));
	$graph_test->addEdge(new Edge($v_6, $v_7));
	$graph_test->addEdge(new Edge($v_6, $v_2));
	$graph_test->addEdge(new Edge($v_6, $v_5));
	$graph_test->addEdge(new Edge($v_2, $v_7));
	$graph_test->addEdge(new Edge($v_2, $v_9));
	$graph_test->addEdge(new Edge($v_2, $v_5));
	$graph_test->addEdge(new Edge($v_7, $v_1));
	$graph_test->addEdge(new Edge($v_7, $v_0));
	$graph_test->addEdge(new Edge($v_7, $v_9));
	$graph_test->addEdge(new Edge($v_1, $v_4));
	$graph_test->addEdge(new Edge($v_1, $v_0));
	$graph_test->addEdge(new Edge($v_5, $v_9));
	$graph_test->addEdge(new Edge($v_5, $v_8));
	$graph_test->addEdge(new Edge($v_9, $v_0));
	$graph_test->addEdge(new Edge($v_9, $v_8));
	$graph_test->addEdge(new Edge($v_0, $v_4));
	$graph_test->addEdge(new Edge($v_0, $v_8));
	$graph_test->addEdge(new Edge($v_8, $v_4));

	$graph_test->display();
	//------------------------------------------------------
	//------------------------------------------------------
	*/

	$graph->display();

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
