<?php
	session_start();
	$_SESSION['circles'] = 0;

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
<?php
	echo "</br> </br> </br> </br>";
	echo "<h2>ONLINE ROUTING</h2>";
?>


<form action="results.php" method="post">
	<table>
	  <tr>
	    <td>
		Graph Size (Pixels):
	    </td> <td>
		<input type="range" name="maxsize" min="100" max="1000" step="10"
			onchange="displaySize(this.value)">
	    </td> <td>
		<span id="sizedisplay">550</span>
	    </td>
	  </tr> <tr>
	    <td>
		Vertices:
	    </td> <td>
		<input type="range" name="points" min="5" max="100" step="5"
			onchange="displayPoints(this.value)">
	    </td> <td>
		<span id="numberofpoints">55</span>
	    </td>
	  </tr> <tr>
	    <td>
		Algorithm 1:
	    </td> <td>
	      <div class="customSelect">
	      <select name="algorithm_1">
	        <option value="dijkstras">Dijkstras</option>
		<option value="midpoint">Midpoint Routing</option>
		<option value="twostep">Two Step Routing</option>
		<option value="apex_angle">Apex Angle Routing</option>
	        <option selected value="deluanay">Deluanay: Bowyer-Watson</option>
	        <option value="convex">Hull: Jarvis March</option>
	        <option value="voronoi_overlay">Voronoi: Overlay</option>
	        <option value="voronoi_only">Voronoi: Cells Only </option>
	        <option value="none">None (Points Only)</option>
	      </select>
	      </div>
	  </tr> <tr>
	    <td>
		Algorithm 2:
	    </td> <td>
	      <div class="customSelect">
	      <select name="algorithm_2">
	        <option selected value="off">Off</option>
	        <option value="dijkstras">Dijkstras</option>
		<option value="midpoint">Midpoint Routing</option>
		<option value="twostep">Two Step Routing</option>
		<option value="apex_angle">Apex Angle Routing</option>
	        <option value="deluanay">Deluanay: Bowyer-Watson</option>
	        <option value="convex">Hull: Jarvis March</option>
	        <option value="voronoi_overlay">Voronoi: Overlay</option>
	        <option value="voronoi_only">Voronoi: Cells Only </option>
	        <option value="none">None (Points Only)</option>
	      </select>
	      </div>
	  </tr> <tr>
	    </td> <td align="center" style="font-weight: normal;">
		<input type="checkbox" name="circles" value=1>
		Show Circumcircles
	    </td>
	</table>

	<input class="button" type="submit" value="PROCESS GRAPH">
	
</form>


</br>
</br>
</body
</html>

<?php
?>
