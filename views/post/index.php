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
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="container">
    <div class="body-content">
        <div class="panel panel-default">
            <div class="panel-heading">Чат</div>
            <div style="padding: 5px;">
                <?php foreach ($posts as $post): ?>
                    <div class="panel panel-default" style="padding: 5px;" id="post-<?= $post->id ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <?= $post->created_at ?>
                                <br>
                                <span style=" <?= (User::getUserRoleById($post->user_id) === 'admin') ? 'color: red' : '' ?>">
                                        <?= $post->user->username ?>
                                    </span>
                                <br>
                                <br>
                                <button id="button-<?= $post->id ?>" class="btn btn-primary correct"
                                        value="<?= $post->id ?>">
                                    Пометить сообщение корректным
                                </button>
                            </div>
                            <div class="col-md-8">
                                <?= $post->text ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
