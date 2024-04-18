<?php

use app\models\UserBills;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserBillsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-bills-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <?php foreach ($dataProvider->models as $model) : ?>
        <div class="col col-12 mb-4">
            <a href="view?id=<?=$model->id?>" style="text-decoration: none;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?=$model->title?> <span class="float-md-end">5 950 000 т</span></h5>
                        <h6 class="card-subtitle mb-2 text-muted text-small"><?=Yii::$app->formatter->asDate($model->date_create, 'dd.MM.Y');?></h6>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach;?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
            'title',
            'date_create',
//            'active',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UserBills $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
