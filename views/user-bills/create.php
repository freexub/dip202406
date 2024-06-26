<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserBills $model */

$this->title = 'Create User Bills';
$this->params['breadcrumbs'][] = ['label' => 'User Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-bills-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
