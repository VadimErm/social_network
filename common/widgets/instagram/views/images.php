<?php
/**
 * @var $items array
 */

?>

<div class="inst-widget">
    <?php foreach ($items as $item) : ?>
        <div class="col s4 m4 l4">
            <a href="<?= $item['url'] ?>"><img src="<?= $item['src'] ?>" alt="instagram"></a>
        </div>
    <?php endforeach; ?>
</div>