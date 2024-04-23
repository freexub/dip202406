<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля, чтобы зарегистрироваться:</p>
    <?= Html::errorSummary($model)?>
    <div class="row">
        <div class="col-lg-5 alert alert-success">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->label('Логин') ?>
                <?= $form->field($model, 'email')->label('Ваш e-mail') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('Ваш пароль') ?>
                <?= $form->field($model, 'retypePassword')->passwordInput()->label('Повторите пароль') ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
