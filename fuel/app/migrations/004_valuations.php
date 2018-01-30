<?php
namespace Fuel\Migrations;

class valuations
{

    function up()
    {
        \DBUtil::create_table('valuations',array(
        'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
        'comentary' => array('constraint' => 50, 'type' => 'varchar'),
        'value' => array('constraint' => 11, 'type' => 'int'),
        'id_users' => array('constraint' => 11, 'type' => 'int'),
        'id_places' => array('constraint' => 11, 'type' => 'int'),
    ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
    array(
        array(
            'constraint' => 'foreingKeyusers',
            'key' => 'id_users',
            'reference' => array(
                'table' => 'users',
                'column' => 'id',
            ),
            'on_update' => 'CASCADE',
            'on_delete' => 'CASCADE'
            
        ), 
        array(
                'constraint' => 'foreingKeyplaces',
                'key' => 'id_places',
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
       \DBUtil::drop_table('valuations');
    }
}