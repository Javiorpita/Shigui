<?php
    namespace Fuel\Migrations;

    class hacerfavorito
    {

        function up()
        {
            \DBUtil::create_table('hacerfavorito',
                array(
            'id_usuario' => array('constraint' => 11, 'type' => 'int'),
            'id_lugar' => array('constraint' => 11, 'type' => 'int'),
        ), array('id_usuario','id_lugar'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
            array(
                'constraint' => 'claveAjenaHacerfavoritoAUsuario',
                'key' => 'id_usuario',
                'reference' => array(
                    'table' => 'usuarios',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'CASCADE'
            ),
            array(
                'constraint' => 'claveAjenaHacerfavoritoALugar',
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
           \DBUtil::drop_table('hacerfavorito');
        }
    }