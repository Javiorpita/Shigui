<?php
    namespace Fuel\Migrations;

    class favorites
    {

        function up()
        {
            \DBUtil::create_table('favorites',
                array(
            'id_user' => array('constraint' => 11, 'type' => 'int'),
            'id_place' => array('constraint' => 11, 'type' => 'int'),
        ), array('id_user','id_place'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
            array(
                'constraint' => 'foreingKeyFavoriteAUsers',
                'key' => 'id_user',
                'reference' => array(
                    'table' => 'users',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'CASCADE'
            ),
            array(
                'constraint' => 'foreingKeyFavoriteAPlaces',
                'key' => 'id_place',
                'reference' => array(
                    'table' => 'places',
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
           \DBUtil::drop_table('favorite');
        }
    }