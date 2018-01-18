<?php
    namespace Fuel\Migrations;

    class buy
    {

        function up()
        {
            \DBUtil::create_table('buy',
                array(
            'id_user' => array('constraint' => 11, 'type' => 'int'),
            'id_object' => array('constraint' => 11, 'type' => 'int'),
        ), array('id_user','id_object'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
            array(
                'constraint' => 'foreingKeyBuyToUsers',
                'key' => 'id_user',
                'reference' => array(
                    'table' => 'users',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'CASCADE'
            ),
            array(
                'constraint' => 'foreingKeyToObjects',
                'key' => 'id_object',
                'reference' => array(
                    'table' => 'objects',
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
           \DBUtil::drop_table('buy');
        }
    }