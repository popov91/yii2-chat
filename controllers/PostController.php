<?php

namespace app\controllers;

use app\models\Post;
use Yii;
use yii\filters\AccessControl;

class PostController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $posts = Post::find()
            ->where(['incorrect' => Post::INCORRECT])
            ->all();

        return $this->render('index',[
            'posts' => $posts,
        ]);
    }

    public function actionCorrectMessage()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
            $postId = Yii::$app->request->post('id');
            $model = Post::findOne(['id' => $postId]);
            if (!is_null($model)) {
                $model->incorrect = Post::CORRECT;
                $model->save();
            } else {
                return false;
            }

            return 'ok';
        }

        return false;
    }
}
