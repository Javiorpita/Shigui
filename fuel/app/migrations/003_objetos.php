<?php
namespace Fuel\Migrations;

class objetos
{

    function up()
    {
        \DBUtil::create_table('objetos',array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'descripcion' => array('constraint' => 50, 'type' => 'varchar'),
            'precio' => array('constraint' => 11, 'type' => 'int'),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('objetos');
    }
}