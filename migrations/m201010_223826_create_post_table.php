<?php

use yii\db\Migration;

/**
 * Создаем миграцию для таблицы сообщений
 */
class m201010_223826_create_post_table extends Migration
{
    const TABLE_NAME = 'post';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id'           => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'user_id'      => $this->integer()->notNull(),
            'text'         => $this->text()->notNull(),
            'is_admin'     => $this->boolean()->defaultValue(false),
            'incorrect'    => $this->boolean()->defaultValue(false),
            'created_at'   => $this->datetime()->notNull(),
        ]);

        // Создаем индекс для колонки 'user_id'
        $this->createIndex(
            'idx-post-user_id',
            'post',
            'user_id'
        );

        // Добавляем внешний ключ для таблицы `user`
        $this->addForeignKey(
            'fk-post-user_id',
            'post',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);

        $this->dropForeignKey(
            'fk-post-user_id',
            'post'
        );

        $this->dropIndex(
            'idx-post-user_id',
            'post'
        );
    }
}
