<?php if(array_key_exists('data', $images) && is_array($images['data']) && count($images['data']) > 0): ?>
	<ul class="instagram-images">
		<?php foreach ($images['data'] as $image): ?>
			<li>
				<a href="<?php echo $image['link']; ?>">
					<img src="<?php echo $image['images']['thumbnail']['url']; ?>" alt="<?php echo $image['id']; ?>">
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<span class="none">Photos not found!</span>
<?php endif; ?>