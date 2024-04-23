<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

/** @var yii\web\View $this */
/** @var app\models\UserBills $model */
/** @var app\models\UserBillsCategoryTransactions $modelTransaction */
/** @var app\models\Category $categories */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Мои счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('modal', [
    'model' => $modelTransaction,
    'categories' => $categories,
    'id' => $model->id,
]) ?>
<div class="user-bills-view">
    <h1><?=$this->title?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-auto alert alert-secondary">
                <div class="d-grid gap-4 d-md-block">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Внести
                    </button>
                </div>
            </div>
            <div class="col">
                <?= $this->render('_search', [
                    'model' => $model,
                    'fdate' => $fdate,
                    'ldate' => $ldate,
                ]) ?>
            </div>
        </div>
    </div>

    <?php echo Highcharts::widget([
        'scripts' => [
            'modules/exporting',
            'themes/grid-dark',
        ],
        'options' => [
            'title' => [
                'text' => 'Расходы за период с '.$fdate.' по '.$ldate,
            ],

            'series' => [
                [
                    'type' => 'pie',
                    'name' => 'Расход',
                    'data' => $model->getDataChart($fdate,$ldate),
                    'size' => 200,
                    'showInLegend' => true,
                    'dataLabels' => [
                        'enabled' => true,
                    ],
                ],
            ],
        ]
    ]);?>


    <div class="row">
            <?php foreach ($dataProvider->models as $item) : ?>
                <div class="col col-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">

                                <a href="delete-transaction?id=<?=$item->id?>" class="btn btn-outline-secondary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                                <?=$item->categories->name?> <span class="float-md-end badge bg-<?=($item->categories->active == 0)? 'info':'success'?>"><?=($item->categories->active == 0)? '-':''?> <?=$item->amount?></span>
                            </h5>
                            <h7 class="card-subtitle mb-2 text-muted text-small"><?=Yii::$app->formatter->asDate($item->date_create, 'dd.MM.Y');?></h7>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
</div>
