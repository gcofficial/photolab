<div class="flexslider">
    <?php if(count($posts)): ?>
    <ul class="slides">
        <?php foreach($posts as $p): ?>
        <li>
        	<a href="<?php echo get_permalink($p->ID); ?>">
        		<img src="<?php echo $p->image; ?>" alt="<?php echo esc_attr( $p->post_title ); ?>" />
        	</a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>