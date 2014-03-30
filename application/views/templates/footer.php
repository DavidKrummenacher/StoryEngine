
	</section>
	
	<script src="<?php echo base_url(); ?>js/jquery-2.1.0.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    
    <?php if($this->router->class == "page" && $this->router->method == "edit") { ?>
    <!-- Iconpicker stuff -->
       	<script src="<?php echo base_url(); ?>js/iconselect/iconselect.js"></script>

       	<script src="<?php echo base_url(); ?>js/iconselect/iscroll.js"></script>
		<script src="<?php echo base_url(); ?>js/edit_page-handler.js"></script>
    
    <?php } ?>
	
    <?php if($this->router->class == "story" && $this->router->method == "overview") { ?>
    <!-- Arbor.JS Stuff -->
   	<script src="<?php echo base_url(); ?>js/arbor.js"></script>
   	<script src="<?php echo base_url(); ?>js/arbor-tween.js"></script>
   	<script src="<?php echo base_url(); ?>js/overview-handler.js"></script>
    <?php } ?>
</body>
</html>