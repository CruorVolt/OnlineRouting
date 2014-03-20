<? 
	session_start();

	include_once 'Vertex.php';
	include_once'Edge.php';
	include_once'Graph.php';
?>

<html>
	<script type="text/javascript">
	function displaySize(val) {
		document.getElementById("sizedisplay").innerHTML=val;
	}
	function displayPoints(val) {
		document.getElementById("numberofpoints").innerHTML=val;
	}
	</script>

<head>
	<link type="text/css" rel="stylesheet" href="CSS/topstyle.css" />
</head>


<body>
<?
	echo "<h1>LANDING PAGE</h1>"
?>


<form>
	<!-- Image Size -->
	Graph Display Size (in pixels):
	<input type="range" name="maxsize" min="100" max="1000" step="10"
		onchange="displaySize(this.value)">
	<span id="sizedisplay">600</span>

	</br>

	<!-- Graph Size -->
	Number of Vertices:
	<input type="range" name="points" min="5" max="100" step="5"
		onchange="displayPoints(this.value)">
	<span id="numberofpoints">55</span>
	
</form>


</br>
<a href = "results.php"> PROCESS GRAPH </a>
</br>
</body
</html>

<?php
?>
