//
//  overview-handler.js
//
//  
//

(function($){

  var Renderer = function(canvas){
    var canvas = $(canvas).get(0)
    var ctx = canvas.getContext("2d");
    var particleSystem

    var that = {
      init:function(system){
        //
        // the particle system will call the init function once, right before the
        // first frame is to be drawn. it's a good place to set up the canvas and
        // to pass the canvas size to the particle system
        //
        // save a reference to the particle system for use in the .redraw() loop
        particleSystem = system

        // inform the system of the screen dimensions so it can map coords for us.
        // if the canvas is ever resized, screenSize should be called again with
        // the new dimensions
		//Comment out for auto-handling of size
        particleSystem.screenSize(canvas.width, canvas.height) 

        //particleSystem.screenSize(900, 600) 

        particleSystem.screenPadding(20) // leave an extra 80px of whitespace per side
        
        // set up some event handlers to allow for node-dragging
        that.initMouseHandling()
      },
      
      redraw:function(){
        // 
        // redraw will be called repeatedly during the run whenever the node positions
        // change. the new positions for the nodes can be accessed by looking at the
        // .p attribute of a given node. however the p.x & p.y values are in the coordinates
        // of the particle system rather than the screen. you can either map them to
        // the screen yourself, or use the convenience iterators .eachNode (and .eachEdge)
        // which allow you to step through the actual node objects but also pass an
        // x,y point in the screen's coordinate system
        // 
        ctx.fillStyle = "white"
       
	   //Comment out for auto-handling of size
	    ctx.fillRect(0,0, canvas.width, canvas.height)
	  // ctx.fillRect(0,0, 900, 600)
        
        particleSystem.eachEdge(function(edge, pt1, pt2){
          // edge: {source:Node, target:Node, length:#, data:{}}
          // pt1:  {x:#, y:#}  source position in screen coords
          // pt2:  {x:#, y:#}  target position in screen coords

          // draw a line from pt1 to pt2
          ctx.strokeStyle = edge.data.color
          ctx.lineWidth = 4
          ctx.beginPath()
          ctx.moveTo(pt1.x, pt1.y)
          ctx.lineTo(pt2.x, pt2.y)
          ctx.stroke()
		 
		  if(edge.data.direction == 1) {
			  var headlen = 50;   // length of head in pixels
  			  var angle = Math.atan2(pt2.y-pt1.y,pt2.x-pt1.x);
			  
			  
			  var originX = pt2.x-20*Math.cos(angle);
			  var originY = pt2.y-20*Math.sin(angle);
			  
			ctx.strokeStyle = "rgba(0,0,0,1)";
        	ctx.lineWidth = 2;
		  
		  	//Manual triangle
			
			
			
			ctx.moveTo(originX, originY);
			ctx.lineTo(pt2.x-headlen*Math.cos(angle+Math.PI/8),pt2.y-headlen*Math.sin(angle+Math.PI/8));
			ctx.lineTo(pt2.x-headlen*Math.cos(angle-Math.PI/8),pt2.y-headlen*Math.sin(angle-Math.PI/8));
			
			ctx.moveTo(pt2.x-headlen*Math.cos(angle-Math.PI/8),pt2.y-headlen*Math.sin(angle-Math.PI/8));
			ctx.lineTo(pt2.x-headlen*Math.cos(angle+Math.PI/8),pt2.y-headlen*Math.sin(angle+Math.PI/8));
		    
			ctx.fillStyle = edge.data.color

			ctx.fill();
			
		
		  }
			  
		/*	ctx.fillStyle = "black";
			ctx.font = 'italic 13px sans-serif';
			ctx.fillText (edge.data.direction, (pt1.x + pt2.x) / 2, (pt1.y + pt2.y) / 2);
		*/
        })

        particleSystem.eachNode(function(node, pt){
          // node: {mass:#, p:{x,y}, name:"", data:{}}
          // pt:   {x:#, y:#}  node position in screen coords

          // draw a rectangle centered at pt
          var w = 20
          
		  /*RECT
		  ctx.fillStyle = node.data.color;	
          ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w)
			*/
			  ctx.beginPath();
			  ctx.arc(pt.x, pt.y, w, 0, 2 * Math.PI, false);
			  ctx.fillStyle = node.data.color;
			  ctx.fill();
			  
		  

			 //Write label 
			ctx.font = "italic small-caps bold 4vw sans-serif"
			
			
			ctx.strokeStyle = 'white';
			ctx.lineWidth = 8;
			ctx.strokeText(node.data.label, pt.x+32, pt.y);

			
			ctx.fillStyle = 'black';
			ctx.fillText(node.data.label, pt.x+32, pt.y);
			
        })    			
      },
      
      initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        var dragged = null;

        // set up a handler object that will initially listen for mousedowns then
        // for moves and mouseups while dragging
        var handler = {
          clicked:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            dragged = particleSystem.nearest(_mouseP);

            if (dragged && dragged.node !== null){
              // while we're dragging, don't let physics move the node
              dragged.node.fixed = false
            }

            $(canvas).bind('mousemove', handler.dragged)
            $(window).bind('mouseup', handler.dropped)

            return false
          },
          dragged:function(e){
            var pos = $(canvas).offset();
            var s = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)

            if (dragged && dragged.node !== null){
              var p = particleSystem.fromScreen(s)
              dragged.node.p = p
            }

            return false
          },

          dropped:function(e){
            if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) dragged.node.fixed = false
            dragged.node.tempMass = 2000
            dragged = null
            $(canvas).unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            _mouseP = null
            return false
          }
        }
        
        // start listening
        $(canvas).mousedown(handler.clicked);

      },
      
    }
    return that
  } 
     
 
	
  $(document).ready(function(){
    var sys = arbor.ParticleSystem(1000, 800, 0.99) // create the system with sensible repulsion/stiffness/friction
    sys.parameters({gravity:true}) // use center-gravity to make the graph settle nicely (ymmv)
    sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...
	
	//Placeholder Array for color implementation
	//TODO: Implement color...somehow in a smart way would be nice...
	var ColorArr = new Array("blue","cyan","green","yellow","orange","purple");
	
	var SingleNode = new Array($('#graph-data ul').children('li').length);
	
	var NodeColor = "#000000";
	
	
	//*Parsing description*//
	// TARGET = $(this).text();
	// SOURCE = $(this).attr('name');
	// LABEL = $(this).attr('title');
	
	//iterate through nodes (every node only ONCE)
	$('#graph-data ul').children('li').each(function(index, element) {
		
		var source = $(this).attr('name');
		var target = $(this).text();
		
		
		var ColorInt = index % ColorArr.length;
		if(target == 1) { NodeColor = "#ff0000";} else {NodeColor = ColorArr[ColorInt]}
		
    	if($.inArray(target,SingleNode) == -1) {
			sys.addNode(target,{color:NodeColor,label:$(this).attr('title')});
			SingleNode[index] = target;
		}
		
		

    });
	
	$('#graph-data ul').children('li').each(function(index, element) {
		var source = $(this).attr('name');
		var target = $(this).text();
		
		sys.addEdge(source,target,{direction:1,color:sys.getNode(source).data.color});
	});

	

  })
  

})(this.jQuery)