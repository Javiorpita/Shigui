<?php
namespace Fuel\Migrations;

class valoraciones
{

    function up()
    {
        \DBUtil::create_table('valoraciones',array(
        'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
        'comentario' => array('constraint' => 50, 'type' => 'varchar'),
        'valor' => array('constraint' => 11, 'type' => 'int'),
        'id_usuario' => array('constraint' => 11, 'type' => 'int'),
        'id_lugar' => array('constraint' => 11, 'type' => 'int'),
    ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
    array(
        array(
            'constraint' => 'claveAjenaUsuarios',
            'key' => 'id_usuario',
            'reference' => array(
                'table' => 'usuarios',
                'column' => 'id',
            ),
            'on_update' => 'CASCADE',
            'on_delete' => 'CASCADE'
            
        ), 
        array(
                'constraint' => 'claveAjenaLugar',
                'key' => 'id_lugar',
                'reference' => array(
                    'table' => 'lugares',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'RESTRICT'
            )
        )
    );
    }


    function down()
    {
       \DBUtil::drop_table('valoraciones');
    }
}