<?php if(count($posts)): ?>
    <div class="accordion">
    <?php foreach ($posts as $p): ?>
        <h3><?php echo $p->post_title; ?></h3>
        <div style="display: none;"><?php echo $p->post_content; ?></div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>