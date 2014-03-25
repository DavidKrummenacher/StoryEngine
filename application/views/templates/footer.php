
	</section>
	
	<script src="<?php echo base_url(); ?>js/jquery-2.1.0.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
	
    <?php if($this->router->class == "page" && $this->router->method == "overview") { ?>
    <!-- Arbor.JS Stuff -->
   	<script src="<?php echo base_url(); ?>js/arbor.js"></script>
   	<script src="<?php echo base_url(); ?>js/arbor-tween.js"></script>
   	<script src="<?php echo base_url(); ?>js/overview-handler.js"></script>
    <?php } ?>
</body>
</html>