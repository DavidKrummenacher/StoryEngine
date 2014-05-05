<h1>Attribute Debug</h1>

<table class="table table-condensed">
	<tr>
		<th>Id</th>
		<th>Attribute name</th>
		<th>Default value</th>
		<th>Current user value</th>
	</tr>
	<?php foreach ($attributes as $attribute) { ?>
		<tr>
			<td><?php echo $attribute['id']; ?></td>
			<td><?php echo $attribute['name']; ?></td>
			<td><?php echo $attribute['value']; ?></td>
			<td>
			<?php
				$user_value = null;
				foreach ($user_attributes as $user_attribute) {
					if ($user_attribute['id'] == $attribute['id'])
						$user_value = $user_attribute['value'];
				}
				echo ($user_value != null) ? $user_value : 'NOT SET';
			?>
			</td>
		</tr>
	<?php } ?>
</table>