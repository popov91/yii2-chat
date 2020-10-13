<?php

use app\models\Post;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostForm */
/* @var $form ActiveForm */

$this->title = 'My Yii Chat';
$this->registerJsFile(
    '@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<div class="container">
    <div class="body-content">
        <div class="panel panel-default">
            <div class="panel-heading">Чат</div>
            <div style="padding: 5px;">
                <?php if (Yii::$app->user->can('readPosts')): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="panel panel-default" style="padding: 5px;
                        <?= ($post->incorrect === Post::INCORRECT && !Yii::$app->user->can('readIncorrectMessage')) ?
                            'display:none' : '' ?>
                                " id="post-<?= $post->id ?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $post->created_at ?>
                                    <br>
                                    <span style=" <?= (User::getUserRoleById($post->user_id) === 'admin') ? 'color: red' : '' ?>">
                                        <?= $post->user->username ?>
                                    </span>
                                    <br>

                                    <span id="message-<?= $post->id ?>" style="display: <?= ($post->incorrect === Post::INCORRECT) ? 'block' : 'none'?>">
                                        СООБЩЕНИЕ НЕКОРРЕКТНО</span>
                                    <?php if (Yii::$app->user->can('flagMessage') && $post->incorrect !== Post::INCORRECT): ?>
                                    <br>
                                    <button id="button-<?= $post->id ?>" class="btn btn-primary incorrect" value="<?= $post->id ?>">
                                        Пометить сообщение некорректным
                                    </button>
                                    <?php endif ?>
                                </div>
                                <div class="col-md-8">
                                    <?= Html::encode($post->text) ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach ?>
                <?php endif ?>
                <?php if (Yii::$app->user->can('createPosts')): ?>
                    <hr>
                    <?php $form = ActiveForm::begin([
                        'id' => 'form',
                        'action' => 'save-form',
                        'method' => 'post',
                    ]); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($model, 'text')->label(false) ?>
                        </div>
                        <div class="col-md-3">
                            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
