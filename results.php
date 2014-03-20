<?
	include_once 'Graph.php';
	include_once 'Vertex.php';
	session_start();
?>

<head>
	<link type="text/css" rel="stylesheet" href="CSS/topstyle.css" />
</head>

<?
	$imagesize = isset($_POST['maxsize']) ? $_POST['maxsize'] : 500;
	$n = isset($_POST['points']) ? $_POST['points'] : 50;
	$_SESSION['imagesize'] = $imagesize;

	$graph = new Graph(array(), array());

	for ($i = 1; $i <= $n; $i++) {
		$x = rand(1, $imagesize-1);
		$y = rand(1, $imagesize-1);
		$graph->addVertex( new Vertex($x, $y) );
	}

	$graph->postGraph();
?>

<?="</br>END RESULTS"?>
</br>
<a href="main.php"> BACK TO FORM </a>
