<?php if((int) $page_id > 0): ?>
	<script src="https://apis.google.com/js/platform.js" async defer>
	  {lang: 'ru'}
	</script>
	<div class="g-person" data-href="//plus.google.com/u/0/<?php echo $page_id; ?>" data-rel="author"></div>
<?php else: ?>
	<span class="none">Page id not found!</span>
<?php endif; ?>