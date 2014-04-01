<h1>Batch upload page images</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open_multipart(uri_string(), 'class="form-horizontal" role="form"');?>
<?php echo form_close();?>