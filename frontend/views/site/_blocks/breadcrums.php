<?php
/**
 * @var $category string
 * @var $page string
 * @var $url string
 * @var $id string
 */
?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only" <?php echo (empty($id)) ? '' : 'id="'.$id . '"'  ?>>
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active"><?= $category ?></li>
                <li>&rarr;</li>
                <li><a href="<?= $url ?>"><?= $page ?></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->