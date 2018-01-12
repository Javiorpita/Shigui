<?php
namespace Fuel\Migrations;

class lugares
{

    function up()
    {
        \DBUtil::create_table('lugares',array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'coordenadas_X' => array('constraint' => 50, 'type' => 'float'),
            'coordenadas_Y' => array('constraint' => 50, 'type' => 'float'),
            'nombre' => array('constraint' => 50, 'type' => 'varchar'),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('lugares');
    }
}