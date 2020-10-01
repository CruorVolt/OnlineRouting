=============================================
===== ONLINE ROUTING VISUALIZATION TOOL =====
=============================================
======= Anders Lundgren, Agata Gruza ========
=============================================

A web application for comparing online routing algorithms on Delaunay triangulations in PHP.

Built for CSCI 532 - Algorithms at Montana State University, Spring 2014

Landing pages use HTML5 input types, may display strangely on browsers without support.

================================
==== Operational Overview: ===== 
================================

RESULTS.PHP:
This is where the Graph objects are created and modified. It creates one or two randomized graphs from the info POSTed from main.php. Re-generating the graphs retains their size and number of vertices and runs the currently selected algorithms again.

GRAPH CLASES:
Graph objects are made up of arrays containing Vertex, Edge and Triangle objects. A path array allows algorithms to overlay highlighted edges. 

Build graphs by making a new Graph() object then calling addVertex(), addEdge() and addTriangle() to add features. All constructor arguments are optional. The coordinates of Edge and Vertex objects can be accessed with their respective coords() functions.

The Graph::display_a() and Graph::display_b() functions send a graph object to the associated image output stream in image_a.php and image_b.php. The call serializes the Graph object to $_SESSION[] and outputs an HTML image tag that links to the image script.

IMAGE OUTPUT:
image_a.php and image_b.php scripts read from two seperate $_SESSION variables and unserialze them into drawable graphs. Triangle edges are not drawn, the scripts will only use Triangle objects to display circumcircles if the option is set in main.php.

ALGORITHMS:
All algorithms modify Graph objects via void-type static methods. Apart from Deluanay::triangulate(), all methods add edges to Graph->path array for highlighted display. Deluanay::triangulate() adds both computed triangles and each triangle's associated edges.

Running a graph object through multiple algorithms will reset the graph's path, edge array and/or triangle array as necessary to display the last procedure correctly.

Midpoint.php, ApexAngle.php and TwoStep.php implement the online routing algorithms described in:

New Memoryless Online Routing Algorithms for Deluanay Triangulations; Weisheng Si, Albert Y. Zomaya; IEEE Transactions on Parallel and Distributed Systems; Vol. 23, No. 8.

Deluanay.php implements the Bowyer-Watson algorithm described independently in:

Computing Dirichlet Tessellations; Bowyer, Adrian; The Computer Journal; Vol. 24, No. 2, 1981

Computing the N-Dimensional Deluanay Tessellation with Application to Voronoi Polytopes; Watson, David F; The Computer Journal; Vol. 24, No. 2, 1981
