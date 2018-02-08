<?php
namespace Fuel\Migrations;

class places
{

    function up()
    {
        \DBUtil::create_table('places',array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'id_maps' => array('constraint' => 255, 'type' => 'varchar'),
            'picture' => array('constraint' => 255, 'type' => 'varchar'),
            'coordinates_X' => array('constraint' => 18, 'type' => 'float'),
            'coordinates_Y' => array('constraint' => 18, 'type' => 'float'),
            'name' => array('constraint' => 100, 'type' => 'varchar'),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('places');
    }
}