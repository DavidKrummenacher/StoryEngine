
	</section>
	
	<script src="<?php echo base_url(); ?>js/jquery-2.1.0.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    
    <?php if($this->router->class == "page" && $this->router->method == "edit") { ?>
    <!-- Iconpicker stuff -->
    <script src="<?php echo base_url(); ?>js/iconselect/iconselect.js"></script>

    <script src="<?php echo base_url(); ?>js/iconselect/iscroll.js"></script>
	<script src="<?php echo base_url(); ?>js/edit_page-handler.js"></script>
    
    <?php } ?>
    
    <?php if($this->router->class == "option" || $this->router->class == "page" || $this->router->class == "story") { ?>
    <script src="<?php echo base_url(); ?>js/image-picker.min.js"></script> 
    <script src="<?php echo base_url(); ?>js/imagepicker-handler.js"></script>
       
    <?php } ?>
	
    <?php if($this->router->class == "story" && $this->router->method == "overview") { ?>
    
<!-- START SIGMA IMPORTS -->
<script src="<?php echo base_url(); ?>js/sigmajs/sigma.core.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/conrad.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/utils/sigma.utils.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/utils/sigma.polyfills.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/sigma.settings.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/classes/sigma.classes.dispatcher.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/classes/sigma.classes.configurable.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/classes/sigma.classes.graph.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/classes/sigma.classes.camera.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/classes/sigma.classes.quad.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/captors/sigma.captors.mouse.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/captors/sigma.captors.touch.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/sigma.renderers.canvas.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/sigma.renderers.webgl.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/sigma.renderers.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/webgl/sigma.webgl.nodes.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/webgl/sigma.webgl.nodes.fast.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/webgl/sigma.webgl.edges.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/webgl/sigma.webgl.edges.fast.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/webgl/sigma.webgl.edges.arrow.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.labels.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.hovers.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.nodes.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.edges.def.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.edges.curve.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.edges.arrow.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/renderers/canvas/sigma.canvas.edges.curvedArrow.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/middlewares/sigma.middlewares.rescale.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/middlewares/sigma.middlewares.copy.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/misc/sigma.misc.animation.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/misc/sigma.misc.bindEvents.js"></script>
<script src="<?php echo base_url(); ?>js/sigmajs/misc/sigma.misc.drawHovers.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/sigmajs/plugins/sigma.parsers.json/sigma.parsers.json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/sigmajs/plugins/sigma.plugins.dragNodes/sigma.plugins.dragNodes.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/sigmajs/plugins/sigma.layout.forceAtlas2/sigma.layout.forceAtlas2.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>js/sigma-handler.js"></script>


    <?php } ?>
    
    <?php if($this->router->class == "option") { ?>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>js/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/searchable-handler.js"></script>
    
    <?php } ?>
    
 </body>
</html>