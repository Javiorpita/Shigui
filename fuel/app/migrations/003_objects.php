<?php
namespace Fuel\Migrations;

class objects
{

    function up()
    {
        \DBUtil::create_table('objects',array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'description' => array('constraint' => 50, 'type' => 'varchar'),
            'price' => array('constraint' => 11, 'type' => 'int'),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('objects');
    }
}