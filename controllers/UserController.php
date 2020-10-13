<?php

namespace app\controllers;

use app\models\RolesForm;
use app\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class UserController extends Controller
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
        $form     = new UserSearch();
        $provider = $form->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'form'     => $form,
            'provider' => $provider,
        ]);
    }

    public function actionRoles($id)
    {
        $form = new RolesForm($id);

        return $this->render('roles', [
            'form' => $form,
        ]);
    }

    public function actionSaveRoles($id)
    {
        $model = new RolesForm($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', 'Роль успешно изменена.');
        } else {
            $errors = implode($model->errors['text']);
            Yii::$app->session->setFlash('error', $errors);
        }

        return $this->redirect('index');
    }
}
