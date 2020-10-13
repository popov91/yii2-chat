<?php

use app\models\RolesForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $htmlForm ActiveForm */
/* @var $form RolesForm */

?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Список ролей</div>
                <div class="panel-body">
                    <?php $htmlForm = ActiveForm::begin([
                        'id' => 'form',
                        'action' => 'save-roles?id=' . $form->id,
                        'method'=>'post',
                    ]); ?>

                    <?= $htmlForm->field($form, 'role')->radioList(RolesForm::gerRolesVariants(), ['separator'=>'<br/>'])->label(false) ?>
                    <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>



</div>
