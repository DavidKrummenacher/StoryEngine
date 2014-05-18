$( document ).ready(function() {
	

var datasources = new Array();

datasources[0] = '../story/page_nodes_only';
datasources[1] = '../story/pages_and_options';	
	


currentdatasource = datasources[0];
	
sigma.classes.graph.addMethod('neighbors', function(nodeId) {
    var k,
        neighbors = {},
        index = this.allNeighborsIndex[nodeId] || {};

    for (k in index)
      neighbors[k] = this.nodesIndex[k];

    return neighbors;
  });
  
 sigma.classes.graph.addMethod('path', function(nodeId) {
    var k,
        path = {},
        index = this.allNeighborsIndex[nodeId] || {};
		
		
    for (k in index)
      path[k] = this.allNeighborsIndex[k] || {};
	
    return path;
  });

  sigma.parsers.json(
    currentdatasource,
    {
      container: 'graph-container'
    },
    function(s) {
      // We first need to save the original colors of our
      // nodes and edges, like this:
	  var firstnode = 0;
      s.graph.nodes().forEach(function(n) {
		  if(firstnode != 0) {
        	n.originalColor = n.color;
		  } else {
			  firstnode = 1;
			  n.color = "rgb(200,0,0)";
			  n.originalColor = n.color;

		  }
      });
      s.graph.edges().forEach(function(e) {
        e.originalColor = e.color;
      });

      // When a node is clicked, we check for each node
      // if it is a neighbor of the clicked one. If not,
      // we set its color as grey, and else, it takes its
      // original color.
      // We do the same for the edges, and we only keep
      // edges that have both extremities colored.
	  	
      s.bind('clickNode', function(e) {
		  s.startForceAtlas2();

        var nodeId = e.data.node.id,
            toKeep = s.graph.path(nodeId);
        toKeep[nodeId] = e.data.node;

        s.graph.nodes().forEach(function(n) {
          if (toKeep[n.id])
            n.color = n.originalColor;
          else
            n.color = '#AAA';
        });

        s.graph.edges().forEach(function(e) {
          if (toKeep[e.source] && toKeep[e.target])
            e.color = e.originalColor;
          else
            e.color = '#AAA';
        });

        // Since the data has been modified, we need to
        // call the refresh method to make the colors
        // update effective.
        s.refresh();
      });



		$('button#show_pages').click(function() {
			sigma.parsers.json(
				  datasources[0],
				  s,
				  function() {
					s.refresh();
				  }
				);
	});
	
$('button#show_options').click(function() {
		sigma.parsers.json(
				  datasources[1],
				  s,
				  function() {
					s.refresh();
				  }
				);
	});
	
      // When the stage is clicked, we just color each
      // node and edge with its original color.
      s.bind('clickStage', function(e) {
        s.graph.nodes().forEach(function(n) {
          n.color = n.originalColor;
		  s.stopForceAtlas2();
        });

        s.graph.edges().forEach(function(e) {
          e.color = e.originalColor;
        });

        // Same as in the previous event:

		s.refresh();
		

      });
    }
	
  );
  
  
  
  });