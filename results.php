<?php
	include_once 'GraphClass/Graph.php';
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

	//------------------------------------------------------
	//------Compute algorithms/add edges to graph here------
	$graph->addHull();
	//------------------------------------------------------
	//------------------------------------------------------

	$graph->display();

?>

</br>

<form name="regenerate" action="results.php" method="post">
	<input type="hidden" name="maxsize" value=<?php echo $imagesize ?> >
	<input type="hidden" name="points" value=<?php echo $n ?> >
	<input class="button" value="RE-GENERATE" type="submit">
</form>

<form name="back" action="main.php" method="post">
	<input class="button" value="BACK TO FORM" type="submit">
</form>

</body>
