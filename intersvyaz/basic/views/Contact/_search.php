<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ContactSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="contact-search mb-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<!--    --><?php //echo $form->field($model, 'id') ?>

<!--    --><?php //echo $form->field($model, 'user_id') ?>

<!--    --><?php //echo $form->field($model, 'phone_number') ?>

<!--    --><?php //echo $form->field($model, 'name') ?>

<!--    --><?php //echo $form->field($model, 'group_id') ?>

<!--    --><?php //echo $form->field($model, 'group.name') ?>

    <?php echo $form->field($model, 'search_field') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Сбросить', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
