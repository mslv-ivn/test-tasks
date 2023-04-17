<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m230415_174157_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notnull(),
            'phone_number' => $this->string(20)->notnull(),
            'name' => $this->string(60),
            'group_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-contact-user_id',
            'contact',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-contact-user_id',
            'contact',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `group_id`
        $this->createIndex(
            'idx-contact-group_id',
            'contact',
            'group_id'
        );

        // add foreign key for table `group`
        $this->addForeignKey(
            'fk-contact-group_id',
            'contact',
            'group_id',
            'group',
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

        // drops foreign key for table `group`
        $this->dropForeignKey(
            'fk-group-group_id',
            'group'
        );

        // drops index for column `group_id`
        $this->dropIndex(
            'idx-group-group_id',
            'group'
        );

        $this->dropTable('{{%contact}}');
    }
}
