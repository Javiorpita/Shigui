<?php
namespace Fuel\Migrations;

class users
{

    function up()
    {
        \DBUtil::create_table('users', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 50),
            'email' => array('type' => 'varchar', 'constraint' => 50),
            'password' => array('type' => 'varchar', 'constraint' => 50),
            'picture' => array('type' => 'varchar', 'constraint' => 50),
            'coins' => array('type' => 'int', 'constraint' => 11),
            //'registered' => array('type' => 'int', 'constraint' => 1),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('users');
    }
}