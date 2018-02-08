<?php
namespace Fuel\Migrations;

class users
{

    function up()
    {
        \DBUtil::create_table('users', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 100),
            'email' => array('type' => 'varchar', 'constraint' => 100),
            'password' => array('type' => 'varchar', 'constraint' => 500),
            'picture' => array('type' => 'varchar', 'constraint' => 500
        ),
            'coins' => array('type' => 'int', 'constraint' => 11),
            //'registered' => array('type' => 'int', 'constraint' => 1),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('users');
    }
}