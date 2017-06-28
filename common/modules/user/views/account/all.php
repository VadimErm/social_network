<table>
    <thead>
    <td>login</td>
    <td>link</td>
    </thead>
    <tbody>
<?php foreach ($profiles as $profile) : ?>
    <tr>
        <td><?= $profile->username ?></td>
        <td><a href="<?= \yii\helpers\Url::to(['/user/account/view', 'id' => $profile->id]) ?>">Link</a></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>