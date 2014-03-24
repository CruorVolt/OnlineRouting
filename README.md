OnlineRouting
=============

Graph Storage:
Graph.php is a class that stores an array of vertices and an array of edges. The postGraph() function stores 
the necessary graph data in the $_SESSION variables and then outputs an image HTML tag, so to add a graph 
to a page you just call $graph->postGraph(); at the correct location.

As a test of the data types Graph.php also includes a function for adding a convex hull (addHull()) using
the Gift Wrapping procedure.

Image Display:
Display.php paints a graph as an image file using the $_SESSION['vertices'] and $_SESSION['edges'] variables.

Notes:
The current implementation can only store one graph in $_SESSION at a time.
