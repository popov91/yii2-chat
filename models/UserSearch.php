<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends Model
{
    /** @var string Идентификатор. */
    public $id;

    /** @var string Имя пользователя. */
    public $username;

    /** @var string Почтовый адрес. */
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'trim'],
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * @param array $params Параметры поиска
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = User::find()
            ->where(['!=', 'id', User::ADMIN_ID]);

        $provider = new ActiveDataProvider(['query' => $query]);

        if (false === ($this->load($params) && $this->validate())) {
            return $provider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['username' => $this->username]);
        $query->andFilterWhere(['email' => $this->email]);

        return $provider;
    }
}