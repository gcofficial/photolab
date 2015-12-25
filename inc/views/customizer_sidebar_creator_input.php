<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?> sidebar-creator">
	<label>
		<span class="customize-control-title"><?php echo $label; ?></span>
		<input type="hidden" class="main-input" value="<?php echo $value; ?>" <?php echo $link; ?>>
	</label>
	<div class="custom-sidebars">
		<div class="custom-sidebars-inputs <?php echo esc_attr( $id ); ?>-inputs"></div>
		<button class="button button-primary add-sidebar" data-id="<?php echo esc_attr( $id ); ?>">Add new sidebar</button>
	</div>
	<script type="text/template" id="custom-sidebar-input-template">
		<div class="custom-sidebar-row">
			<input type="text" class="sidebars-input" value="<%= value %>">
			<button type="button" class="remove button">-</button>
		</div>
	</script>
</li>