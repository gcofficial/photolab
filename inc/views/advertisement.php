<?php if(trim($image) != ''): ?>
	<img src="<?php echo $image; ?>" alt="image">
<?php else: ?>
	<span class="none">Image not found!</span>
<?php endif; ?>