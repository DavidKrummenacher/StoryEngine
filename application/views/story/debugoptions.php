<h1>Options Debug</h1>

<table class="table table-condensed">
	<tr>
		<th>Id</th>
		<th>Option Label</th>
		<th>Source Page</th>
		<th>Target Page</th>
	</tr>
	<?php foreach ($options as $option) { ?>
		<tr <?php if(!$option['target_page']) { echo 'class="warning"'; }?>>
			<td><?php echo $option['option_id']; ?></td>
			<td><?php echo $option['option_text']; ?></td>
			<td><?php echo $option['option_source']; ?></td>
			<td><?php if($option['target_page']) { 
			
			echo $option['target_page']; 
			} else {
			 echo '<div class="btn-group">';
			 echo anchor('option/edit/'.$option['option_id']."#targets", '<span class="glyphicon glyphicon-pencil"></span>','class="btn btn-default btn-xs"'); 
			 echo '</div>';
			}
			?>
            </td>
		</tr>
	<?php } ?>
</table>