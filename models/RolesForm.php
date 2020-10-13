<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RolesForm extends Model
{
    /** @var string Идентификатор пользователя. */
    public $id;

    /** @var string Роль. */
    public $role;

    public function __construct(string $id, $config = [])
    {
        $this->id = $id;
        $this->role = User::getUserRoleById($id);

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['role', 'required'],
            ['role', 'in', 'range' => array_keys($this->gerRolesVariants())],
        ];
    }

    public static function gerRolesVariants()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();

        $names = [];
        $descriptions = [];

        foreach ($roles as $role) {
            $names[] = $role->name;
            $descriptions[] = $role->description;
        }

        return array_combine($names, $descriptions);
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        // Удаляем прошлую роль
        $auth = Yii::$app->authManager;
        $roleName = User::getUserRoleById($this->id);
        $role = $auth->getRole($roleName);
        $auth->revoke($role, $this->id);

        // Добавляем новую роль
        $newRole = $auth->getRole($this->role);
        $auth->assign($newRole, $this->id);

        return true;
    }
}