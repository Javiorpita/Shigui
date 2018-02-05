<?php
    namespace Fuel\Migrations;

    class search
    {

        function up()
        {
            \DBUtil::create_table('search',
                array(
            'id_user' => array('constraint' => 11, 'type' => 'int'),
            'id_maps_place' => array('constraint' => 255, 'type' => 'varchar'),
        ), array('id_user','id_maps_place'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
            array(
                'constraint' => 'foreingKeySearchToUsers',
                'key' => 'id_user',
                'reference' => array(
                    'table' => 'users',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'CASCADE'
            ),
            array(
                'constraint' => 'foreingKeySearchToPlaces',
                'key' => 'id_maps_place',
                'reference' => array(
                    'table' => 'places',
                    'column' => 'id_maps',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'RESTRICT'
                    )
                )
            );
        }

        function down()
        {
           \DBUtil::drop_table('search');
        }
    }