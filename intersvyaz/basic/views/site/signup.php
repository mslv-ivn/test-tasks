<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SignupForm $model */
/** @var yii\bootstrap5\ActiveForm $form */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('signupSuccessful')): ?>

        <div class="alert alert-success">
            Регистрация прошла успешно.
        </div>

    <?php else: ?>

        <p>Пожалуйста, заполните следующие поля, чтобы зарегистрироваться:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'signup-form',
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>

    <?php endif; ?>

</div><!-- site-signup -->
