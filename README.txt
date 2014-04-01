OnlineRouting
=============

MAIN.PHP:
Simple landing page. The two variables are POSTed to results.php to randomly generate a graph with the specified number of vertices and no edges. We can use this to generate test-data and then add edges with our algorithms.

RESULTS.PHP:
This is where the Graph objects are created and modified. Right now it creates one randomized graph from the info POSTed from main.php. We can compute whatever algorithms we implement here and then output the graphs to the browser. The convex-hull example algorithm is currently called from here.

GRAPH.PHP:
Data structures for the network graph. Current version is just an unrelated series of Vertex objects and Edge objects. I suspect we may need some additional complexity for the algorithms, perhaps a Triangle object that keeps track of three edges and three vertices, and perhaps a connection between the Vertex objects and the Edges associated with them.

To display the graph on the page call the display() function, which automatically serializes the Graph object and inserts an HTML image tag that links to the image script.

IMAGE.PHP:
The script that generates an image based on the Graph object in $_SESSION['graph']. You shouldn't have to modify this to get anything to display, though the color values are hardcoded in here if you want to change them.

The primary limitation right now is that image.php will only display one graph at a time. I can work on a method for calling multiple image scripts, but I think the simplest solution will be to just make copies of this file for each graph we want to display in the final version.
