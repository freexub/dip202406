<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserBillsCategoryTransactions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-bills-form">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => 'create'
            ]); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Создание нового счёта</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
                        <?= $form->field($model, 'title')->textInput()?>
                        <?= $form->field($model, 'amount')->textInput(['type'=>'number', 'value'=>0])->label('Сумма на балансе') ?>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>




</div>
