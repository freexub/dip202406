<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\UserBillsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class=" alert alert-secondary">

    <?php $form = ActiveForm::begin([
        'action' => ['view'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col">
            <input type="hidden" value=<?=$model->id?> name="id">
            <?php echo DatePicker::widget([
                'name' => 'fdate',
                'value' => $fdate,
                'type' => DatePicker::TYPE_RANGE,
                'separator' => 'До',
                'name2' => 'ldate',
                'value2' => $ldate,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy'
                ]
            ]);?></div>
        <div class="col-md-auto">
            <div class="d-grid gap-2 d-md-block">
                <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>
