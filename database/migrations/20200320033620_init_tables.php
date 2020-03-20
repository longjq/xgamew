<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class InitTables extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
     
        $account = $this->table('game_account_base' ,  ['comment'=>'用户基础表']);
        $account->addColumn('nickname', 'string', ['limit' => 50, 'comment'=>'用户名称'])
                ->addColumn('username', 'string', ['limit' => 50, 'comment'=>'账号'])
              ->addColumn('password', 'string', array('limit' => 40, 'comment'=>'密码'))
              ->addColumn('password_salt', 'string', array('limit' => 40, 'comment'=>'密码盐值'))
              ->addColumn('mobile', 'string', array('limit' => 20, 'comment'=>'手机号'))
              ->addColumn('created_at' , 'timestamp', ['default'=>'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at' , 'timestamp', ['default'=>'CURRENT_TIMESTAMP','update'=>'CURRENT_TIMESTAMP'])
              ->addIndex(array('username', 'mobile'), array('unique' => true))
              ->create();

        $accountProfile = $this->table('game_account', ['comment'=>'用户详情表']);
        $accountSetting = $this->table('game_account_setting', ['comment'=>'用户配置表']);
        $accountBag = $this->table('game_account_bag', ['comment'=>'用户背包表']);

        $agent = $this->table('game_agent', ['comment' => '代理表']);

        $bag = $this->table('game_magic', ['comment'=>'道具表']);
        $bag->addColumn('enabled', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'default' => 1,'comment'=>'1=开启，0=关闭'])
            ->addColumn('name', 'string', ['limit'=>50])
            ->addColumn('description', 'string', ['limit'=>255])
            ->addColumn('label', 'string', ['limit'=>50])
            ->addColumn('created_at' , 'timestamp', ['default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at' , 'timestamp', ['default'=>'CURRENT_TIMESTAMP','update'=>'CURRENT_TIMESTAMP'])
            ->addIndex(['name'], ['unique' => true])
            ->create();

        $sysAdmin = $this->table('sys_admin', ['comment'=>'后台账号']);
        $sysAdmin->addColumn('enabled', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'default' => 1,'comment'=>'1=开启，0=关闭'])
                ->addColumn('nickname', 'integer', ['comment'=> '名称'])
                ->addColumn('username', 'integer', ['comment'=> '登录名'])
                ->addColumn('password', 'string', array('limit' => 40, 'comment'=>'密码'))
                ->addColumn('password_salt', 'string', array('limit' => 40, 'comment'=>'密码盐值'))
                ->addColumn('last_login_ip', 'string', ['limit'=>15, 'comment'=>'最后登录IP'])
                ->addColumn('last_login_time', 'timestamp', ['comment'=>'最后登录时间'])
                ->addColumn('created_at' , 'timestamp', ['default'=>'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at' , 'timestamp', ['default'=>'CURRENT_TIMESTAMP','update'=>'CURRENT_TIMESTAMP'])
                ->addIndex(['nickname','username'], ['unique' => true])
                ->create();
    }

    public function up(){
   
    }
}
