<?php
/* @var $this yii\web\View */

use app\models\User;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
?>

<div class="container">
    <?= GridView::widget([
        'dataProvider' => $provider,
        'filterModel'  => $form,

        'columns' => [
            [
                'attribute' => 'id',
                'value'     => 'id',
            ],
            [
                'attribute' => 'username',
                'value'     => 'username',
            ],
            [
                'attribute' => 'email',
                'value'     => 'email',
            ],
            [
                'attribute' => 'roles',
                'label'     => 'Роли',
                'value'     => function(User $user){
                    return User::getUserRoleByUsername($user->username);
                }
            ],
            [
                'class'    => ActionColumn::class,
                'template' => '{roles}',
                'buttons'  => [
                    'roles' => function($url){
                        $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-user']);

                        return Html::a($icon, $url, [
                            'title'  => Yii::t('yii', 'Изменить роли пользователя'),
                            'target' => '_blank',
                        ]);
                    }
                ]
            ]
        ]
    ])?>

</div>

