<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class MyRbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        // Создаем роли
        $admin = $auth->createRole('admin');
        $admin->description = 'Роль admin';

        $user = $auth->createRole('user');
        $user->description = 'Роль user';

        $guest = $auth->createRole('guest');
        $guest->description = 'Роль guest';

        // Сохраняем их в БД
        $auth->add($admin);
        $auth->add($user);
        $auth->add($guest);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Создаем разрешения
        $readPosts = $auth->createPermission('readPosts');
        $readPosts->description = 'Чтение сообщений';
        $auth->add($readPosts);

        $createPosts = $auth->createPermission('createPosts');
        $createPosts->description = 'Создание сообщений';
        $auth->add($createPosts);

        $viewUserList = $auth->createPermission('viewUserList');
        $viewUserList->description = 'Просмотр списка пользователей';
        $auth->add($viewUserList);

        $flagMessage = $auth->createPermission('flagMessage');
        $flagMessage->description = 'Пометка некорректных сообщений';
        $auth->add($flagMessage);

        $readIncorrectMessage = $auth->createPermission('readIncorrectMessage');
        $readIncorrectMessage->description = 'Просмотр страницы некорректных сообщений';
        $auth->add($readIncorrectMessage);

        // Даем гостю необходимые разрешения
        $auth->addChild($guest ,$readPosts);

        // Даем пользователю необходимые разрешения
        $auth->addChild($user ,$readPosts);
        $auth->addChild($user, $createPosts);

        // Наследуем все разрешения роли "user" для роли "admin"
        $auth->addChild($admin, $user);

        // Даем для роли "admin" нужные ему разрешения
        $auth->addChild($admin, $viewUserList);
        $auth->addChild($admin, $flagMessage);
        $auth->addChild($admin, $readIncorrectMessage);
    }
}