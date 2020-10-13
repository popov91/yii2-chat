<?php

namespace app\models;

use Carbon\Carbon;
use Yii;
use yii\base\Model;

class PostForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'trim'],
            ['text', 'string', 'max' => 1000],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $post             = new Post;
        $post->user_id    = Yii::$app->user->id;
        $post->text       = htmlspecialchars($this->text);
        $post->is_admin   = User::checkAdminRole();
        $post->incorrect  = Post::CORRECT;
        $post->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $post->save();

        return true;
    }
}