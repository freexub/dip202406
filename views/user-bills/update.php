<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserBills $model */

$this->title = 'Update User Bills: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'User Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-bills-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
