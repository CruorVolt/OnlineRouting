OnlineRouting
=============

RESULTS.PHP:
This is where the Graph objects are created and modified. It creates one randomized graph from the info POSTed from main.php. We can compute whatever algorithms we implement here and then output the graphs to the browser.

Right now it calls the Bowyer-Watson algorithm and adds Triangle objects to the graph with optional circumcircles.

GRAPH.PHP:
Data structures for the network graph. Current version is just an unrelated series of Vertex objects, Edge objects and Triangle objects. Looking at the routing algorithms I think we'll need a way to efficiently get the edges associated with a given vertex.

Build graphs by making a new Graph() object then calling addVertex(), addEdge() and addTriangle() to add features. All the constructor arguments are optional. The coordinates of Edge and Vertex objects can be accessed with their respective coords() functions.

To display the graph on the page call the display() function, which automatically serializes the Graph object and inserts an HTML image tag that links to the image script. I'm working on a way to display multiple graphs at once.

IMAGE.PHP:
The script that generates an image based on the Graph object in $_SESSION['graph']. You shouldn't have to modify this to get anything to display, though the color values are hardcoded in here if you want to change them. $_SESSION['circles'] is a tag that tells the file to paint the circumcircles of the graph's triangles.

TO DO NEXT:
I'm working on (hopefully) simple Dijkstras so we can compare the routing algorithms to the shortest path.
