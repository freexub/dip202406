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

            <?php $form = ActiveForm::begin(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Внести сумму</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
                        <?= $form->field($model, 'user_bills_id')->hiddenInput(['value' => $id])->label(false) ?>
                        <?= $form->field($model, 'amount')->textInput(['type' => 'number']) ?>
                        <?php $i=0; foreach ($categories as $category) : ?>
                            <input type="radio" class="btn-check" name="UserBillsCategoryTransactions[category_id]" value="<?=$category->id?>" id="option<?=$category->id?>" autocomplete="off" <?=($category->active<1)?:'checked'?>>
                            <label class="btn btn-outline-success mb-2" for="option<?=$category->id?>"><?=$category->name?></label>
                        <?php $i++; endforeach;?>
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
