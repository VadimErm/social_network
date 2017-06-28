<?php
/**
 * @var $this \yii\web\View
 */
use common\modules\garage\widgets\journals\Journals;
use common\helpers\TemplateHelper;
?>
<!-- wrapper -->
<div class="section car-journal-wrap">
    <div class="container">

        <?= $this->render('_entry_form'); ?>
        <div class="row">
            <div class="col s12">
                <?= Journals::widget([
                    'items' => []
                ]) ?>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->
<?= TemplateHelper::deliver($this, 'journal-tpl', 'templates/test_template'); ?>