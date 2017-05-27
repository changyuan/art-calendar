<?php

//// yii migrate/create create_ac_user_table --fields="openid:string(100),nickname:string(50),avatar:string(150),authKey:string(50),accessToken:string(50),is_admin:smallInteger(3),create_time:dateTime"


use yii\db\Migration;

/**
 * Handles the creation of table `ac_user`.
 */
class m170518_085836_create_ac_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ac_user', [
            'id' => $this->primaryKey(),
            'openid' => $this->string(100),
            'nickname' => $this->string(50),
            'avatar' => $this->string(150),
            'authKey' => $this->string(50),
            'accessToken' => $this->string(50),
            'is_admin' => $this->smallInteger(3),
            'create_time' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ac_user');
    }
}
