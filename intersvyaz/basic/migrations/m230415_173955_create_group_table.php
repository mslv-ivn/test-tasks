<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 */
class m230415_173955_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notnull(),
            'name' => $this->string(20),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-group-user_id',
            'group',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-group-user_id',
            'group',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-group-user_id',
            'group'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-group-user_id',
            'group'
        );

        $this->dropTable('{{%group}}');
    }
}
