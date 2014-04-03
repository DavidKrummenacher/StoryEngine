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
		  if(edge.target.data.type == "option") {
				lineW = 1;
			} else {
				lineW = 4;
			}
			
		switch(edge.data.type) {
			
			case "page_to_option":
			lineW = 4;
			break;
			
			case "option_to_page":
			lineW = 4;
			break;
			
			case "option_to_check":
			lineW = 1;
			break;
			
			case "option_to_condition":
			lineW = 1;
			break;
			
			case "option_to_consequences":
			lineW = 1;
			break;
			
			default:
			lineW = 2;
			break;
			}
			
          ctx.strokeStyle = edge.data.color
          ctx.lineWidth = lineW
          ctx.beginPath()
          ctx.moveTo(pt1.x, pt1.y)
          ctx.lineTo(pt2.x, pt2.y)
          ctx.stroke()
		  
		/*ctx.fillStyle = "black";
        ctx.font = 'italic 2vw sans-serif';
        ctx.fillText (edge.data.label, (pt1.x + pt2.x) / 2, (pt1.y + pt2.y) / 2);
*/
		 
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
			
			ctx.beginPath();

			
		 var TxtOffset = 0;	
         var isundefiend = false;
			  switch(node.data.type) {
				  
				  case "highlighted":
				  	w = 40;
					fontW = 4;
					TxtOffset = 250;	
					ctx.arc(pt.x, pt.y, w, 0, 2 * Math.PI, false);
					ctx.fillStyle = "#ff0000";
					ctx.fill();
				  break;
				  
				  case "page":
					w = 20;
					fontW = 3;
					TxtOffset = 150;	
					ctx.arc(pt.x, pt.y, w, 0, 2 * Math.PI, false);
					ctx.fillStyle = node.data.color;
					ctx.fill();
				  break;
				  
				  case "option":
					w = 30;
					fontW = 2;
					TxtOffset = 100;	
					ctx.fillStyle = node.data.color;	
         			ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w);
	
				  break;
				  
				  case "check":
					w = 20;
					fontW = 2;
					TxtOffset = 30;	
					ctx.fillStyle = node.data.color;	
         			ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w);
				  break;
				  
				  case "condition":
					w = 20;
					fontW = 2;
					TxtOffset = 30;
					ctx.fillStyle = node.data.color;	
         			ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w);
				  break;
				  
				  case "consequence":
					w = 20;
					fontW = 2;
					TxtOffset = 30;
					ctx.fillStyle = node.data.color;	
         			ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w);
				  break;
				  
				  default:
					w = 100;
					fontW = 3;
					TxtOffset = 50;
					ctx.arc(pt.x, pt.y, w, 0, 2 * Math.PI, false);
					ctx.fillStyle = node.data.color;
					ctx.fill();	
					
					isundefiend = true
				  break;
				  }
			
			/*
			ctx.strokeStyle = "rgba(0,0,0,1)";
        	ctx.lineWidth = 2;
			ctx.moveTo(pt.x, pt.y);
			ctx.lineTo(pt.x+150,pt.y);
			*/
			
			if(node.data.highlighted)
			{
				w = 50;
				fontW = 4;
				TxtOffset = 250;	
				ctx.arc(pt.x, pt.y, w, 0, 2 * Math.PI, false);
				ctx.fillStyle = "#C4C4C4";
				ctx.fill();	
			}
		  

			 //Write label 
			ctx.font = "italic small-caps bold "+fontW+"vw sans-serif"
			
			
			lineW = 5;
			if(isundefiend != true) {
			ctx.strokeStyle = 'white';

			ctx.lineWidth = lineW;
			ctx.strokeText(node.data.label, pt.x+TxtOffset, pt.y+10);

			
			ctx.fillStyle = 'black';
			ctx.fillText(node.data.label, pt.x+TxtOffset, pt.y+10);
			} else {
				//Display Error
		
		    ctx.textAlign = 'center';
			ctx.fillStyle = 'red';
			ctx.fillText("ERROR", pt.x, pt.y);
			}
			
        })   			
      } ,
      
     initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        var dragged = null;
		var highlighted = "";
        // set up a handler object that will initially listen for mousedowns then
        // for moves and mouseups while dragging
        var handler = {
          clicked:function(e){
             var pos = $('canvas').offset();
				var Wi = $('canvas').width();
				var ratio = 2000/Wi;
				//alert((e.pageX-pos.left)*ratio+" - "+(e.pageY-pos.top)*ratio)
	 		    _mouseP = arbor.Point((e.pageX-pos.left)*ratio, (e.pageY-pos.top)*ratio);
				dragged = particleSystem.nearest(_mouseP);

            if (dragged && dragged.node !== null){
              // while we're dragging, don't let physics move the node
              dragged.node.fixed = true
            }

            $('canvas').bind('mousemove', handler.dragged)
            $(window).bind('mouseup', handler.dropped)

            return false
          },
          dragged:function(e){
             var pos = $('canvas').offset();
				var Wi = $('canvas').width();
				var ratio = 2000/Wi;
				//alert((e.pageX-pos.left)*ratio+" - "+(e.pageY-pos.top)*ratio)
	 		    s = arbor.Point((e.pageX-pos.left)*ratio, (e.pageY-pos.top)*ratio);
				

            if (dragged && dragged.node !== null){
              var p = particleSystem.fromScreen(s)
              dragged.node.p = p
            }

            return false
          },

          dropped:function(e){
            if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) dragged.node.fixed = false
            dragged.node.tempMass = 1000
            dragged = null
            $('canvas').unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            _mouseP = null
            return false
          },

          move:function(e){
           /*
		    if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) dragged.node.fixed = false
            dragged.node.tempMass = 1000
            dragged = null
            $('canvas').unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            _mouseP = null
			*/
			var pos = $('canvas').offset();
			var Wi = $('canvas').width();
			var ratio = 2000/Wi;
			_mouseP = arbor.Point((e.pageX-pos.left)*ratio, (e.pageY-pos.top)*ratio);
			move = particleSystem.nearest(_mouseP);
			
			
				
		
				
			if(move && move.distance < 200 && highlighted != move.node)
			{	
				if(highlighted != "") {
				var n = particleSystem.getNode(highlighted);
				n.data.highlighted = false;
				}
				
				move.node.data.highlighted = true;
				highlighted = move.node.name;
				//particleSystem.tweenNode(move.node, 1, {color:"cyan", radius:4});
			} /*else {
				particleSystem.tweenNode(move.node, 1, {color:iniCol, radius:4})
			}*/
            return false
          }
        }
        
        // start listening
        $('canvas').mousedown(handler.clicked);
		$('canvas').mousemove(handler.move);

      },
      
    }
    return that
  }      
    /* 
  $('canvas').addEventListener("mouseover", OverviewMouseOver, false);
	
	function OverviewMouseOver(e) {
				_mouseP = arbor.Point(e.pageX, e.pageY)
				nearest = sys.nearest(_mouseP);

		}*/
  $(document).ready(function(){
	  
	  //arbor.ParticleSystem(repulsion, stiffness, friction, gravity, fps, dt, precision) 
    var sys = arbor.ParticleSystem(50, 1000, 0,false,30,0.02,0.6) // create the system with sensible repulsion/stiffness/friction
    sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...
	
	//Placeholder Array for color implementation
	//TODO: Implement color...somehow in a smart way would be nice...
	//var ColorArr = new Array("blue","cyan","green","yellow","orange","purple");
	var ColorArr = new Array("black");
	
	var SingleNode = new Array($('#graph-data ul').children('li').length);
	
	var NodeColor = "#000000";
	
	
	//*Parsing description*//
	// TARGET = $(this).text();
	// SOURCE = $(this).attr('name');
	// LABEL = $(this).attr('title');
	
	//iterate through nodes (every node only ONCE)
	
	//Ini 1st Node, because 1st Node doesnt have to be a target
	//sys.addNode(1,{color:"#00FF00",label:"1. Start"});
			//SingleNode[index] = target;
	
	//Parse PageNodes
	$('#graph-data ul').children('li').each(function(index, element) {
		var suffix = "page_";
		var nodeName = $(this).text();		

		if(nodeName == 1) { 
		    	sys.addNode(suffix+nodeName,{mass:50,fixed:true,color:"#FF0000",label:nodeName +". "+ $(this).attr('title'),type:"page"});
		} else { 
		    	sys.addNode(suffix+nodeName,{mass:20,color:"#000000",label:nodeName +". "+ $(this).attr('title'),type:"page"});
		}
    });
	
	//Parse Optionnodes
	$('#graph-data-options ul').children('li').each(function(index, element) {
		var suffix = "option_";
		var source = $(this).attr('name');
		var nodeName = $(this).text();
		var NodeColor = "#000000";	
    	sys.addNode(suffix+nodeName,{color:NodeColor,label:$(this).attr('title'),type:"option"});
    });
	
	//Parse Optionchecks
	$('#graph-data-optionchecks ul').children('li').each(function(index, element) {
		var suffix = "check_";
		var source = $(this).attr('name');
		var nodeName = $(this).text();
		var NodeColor = "#c83dca";	
    	sys.addNode(suffix+nodeName,{color:NodeColor,label:$(this).attr('title'),type:"check"});
    });
	
	//Parse Optionconditions
	$('#graph-data-optionconditions ul').children('li').each(function(index, element) {
		var suffix = "condition_";
		var source = $(this).attr('name');
		var nodeName = $(this).text();
		var NodeColor = "#5bca3d";	
    	sys.addNode(suffix+nodeName,{color:NodeColor,label:$(this).attr('title'),type:"condition"});
    });
	
	//Parse Optionconsequences
	$('#graph-data-optionconsequences ul').children('li').each(function(index, element) {
		var suffix = "consequence_";
		var source = $(this).attr('name');
		var nodeName = $(this).text();
		var NodeColor = "#3d68ca";	
    	sys.addNode(suffix+nodeName,{color:NodeColor,label:$(this).attr('title'),type:"consequence"});
    });
	
	
	//ADD EDGES-------------------------------------------------	
	
	$('#graph-data-options ul').children('li').each(function(index, element) {
		var source = "page_"+$(this).attr('name');
		var target = "option_"+$(this).text();
		var color = "#000000";
		
		if(sys.getNode(target).data.color == "#ff0000") {color = "#ff0000"; status = "Error";} else {color = sys.getNode(source).data.color; status = "i.O.";}
		sys.addEdge(source,target,{length:0.2,direction:1,color:color,label:status,type:"page_to_option"});
		
		});
		
	
	$('#graph-data-optiontargets ul').children('li').each(function(index, element) {
			var target = "page_"+$(this).text();
			var source = "option_"+$(this).attr('name');
			var NodeColor = sys.getNode(source).data.color;

			sys.addEdge(source,target,{direction:1,color:NodeColor,type:"option_to_page"});
	});
	
	$('#graph-data-optionchecks ul').children('li').each(function(index, element) {
			var target = "check_"+$(this).text();
			var source = "option_"+$(this).attr('name');
			var NodeColor = sys.getNode(source).data.color;
			sys.addEdge(source,target,{length:0.1,direction:0,color:NodeColor,type:"option_to_check"});
	});
	
	$('#graph-data-optionconditions ul').children('li').each(function(index, element) {
			var target = "condition_"+$(this).text();
			var source = "option_"+$(this).attr('name');
			var NodeColor = sys.getNode(source).data.color;
			sys.addEdge(source,target,{length:0.1,direction:0,color:NodeColor,type:"option_to_condition"});
	});
	
	$('#graph-data-optionconsequences ul').children('li').each(function(index, element) {
			var target = "consequence_"+$(this).text();
			var source = "option_"+$(this).attr('name');
			var NodeColor = sys.getNode(source).data.color;
			sys.addEdge(source,target,{length:0.1,direction:0,color:NodeColor,type:"option_to_consequences"});
	});
	

	
	
	

	})
  

})(this.jQuery)