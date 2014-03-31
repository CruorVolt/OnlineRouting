<?php
	include_once 'GraphClass/Graph.php';
	include_once 'GraphClass/GraphImage.php';
	session_start();
?>

<head>
	<link type="text/css" rel="stylesheet" href="CSS/topstyle.css" />
</head>

<?php
	$imagesize = isset($_POST['maxsize']) ? $_POST['maxsize'] : 500;
	$n = isset($_POST['points']) ? $_POST['points'] : 50;
	$_SESSION['imagesize'] = $imagesize;

	$graph = new Graph(array(), array());

	for ($i = 1; $i <= $n; $i++) {
		$x = rand(2, $imagesize-2);
		$y = rand(2, $imagesize-2);
		$graph->addVertex( new Vertex($x, $y) );
	}

	$graph->addHull();

?>

</br>

<form action="results.php" method="post">
<input type="hidden" name="maxsize" value="<?php= $imagesize ?>" >
<input type="hidden" name="points" value="<?php= $n ?>" >
<input class="button" value="RE-GENERATE" type="submit">
</form>

<form action="main.php" method="post">
<input class="button" value="BACK TO FORM" type="submit">
</form>
