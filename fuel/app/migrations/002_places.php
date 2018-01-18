<?php
namespace Fuel\Migrations;

class places
{

    function up()
    {
        \DBUtil::create_table('places',array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'coordinates_X' => array('constraint' => 50, 'type' => 'float'),
            'coordinates_Y' => array('constraint' => 50, 'type' => 'float'),
            'name' => array('constraint' => 50, 'type' => 'varchar'),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('places');
    }
}