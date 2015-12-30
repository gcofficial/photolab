<?php
if(count($widgets) > 0 && $columns > 0)
{
	for($i = 0; $i < count($widgets); $i+=$columns)
	{
		?>
		<div class="row">
		<?php
		for ($x=0; $x < $columns; $x++) 
		{ 
			if(array_key_exists($i + $x, $widgets))
			{
				printf(
					'<div class="%s">%s</div>', 
					$css, 
					$widgets[$i + $x]
				);
			}
		}
		?>
		</div>
		<?php
	}
}