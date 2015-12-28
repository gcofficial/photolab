<select <?php echo Tools::join($attributes); ?>>
	<?php
	foreach ($values as $key => $value) 
	{
		?>
		<option value="<?php echo $key; ?>" <?php selected($attributes['value'], $key) ?>><?php echo $value; ?></option>
		<?php
	}
	?>
</select>