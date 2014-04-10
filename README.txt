OnlineRouting
=============

RESULTS.PHP:
This is where the Graph objects are created and modified. It creates one randomized graph from the info POSTed from main.php. We can compute whatever algorithms we implement here and then output the graphs to the browser.

Right now it calls the Bowyer-Watson algorithm and adds Triangle objects to the graph with optional circumcircles, then computes the Dijkstras-shortest path between two vertices.

GRAPH.PHP:
Data structures for the network graph. Vertexes now have neighbors that are added whenever the addEdge() method is called. There is currently no method for dissociating neighbors so all the algorithms compute all edges then add all edges.

Graph objects now have a $path array that holds edges on whatever path we want to show. I assume they'll need a collectoin of paths for the final version. Algorithms (see Dijkstras for example) can use the addPathEdge() method to add new information. 

Build graphs by making a new Graph() object then calling addVertex(), addEdge() and addTriangle() to add features. All the constructor arguments are optional. The coordinates of Edge and Vertex objects can be accessed with their respective coords() functions.

To display the graph on the page call the display() function, which automatically serializes the Graph object and inserts an HTML image tag that links to the image script. I'm working on a way to display multiple graphs at once.

IMAGE.PHP:
The script that generates an image based on the Graph object in $_SESSION['graph']. You shouldn't have to modify this to get anything to display, though the color values are hardcoded in here if you want to change them. $_SESSION['circles'] is a tag that tells the file to paint the circumcircles of the graph's triangles. Currently only paints edges associated with Graph->edges, not the edges in Graph->triangles.

TO DO NEXT:
Dijkstras does not halt early when the destination is reached and does not use a min-priority queue. Those fixes should speed it up considerably. Also thinkning of ways to fix edge cases where Deluanay.php will not triangulate points that only share triangles with the supertriangle.
