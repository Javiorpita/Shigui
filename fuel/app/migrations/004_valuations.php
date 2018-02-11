<?php
namespace Fuel\Migrations;

class valuations
{

    function up()
    {
        \DBUtil::create_table('valuations',array(
        
        'comentary' => array('constraint' => 1000, 'type' => 'varchar'),
        'value' => array('constraint' => 11, 'type' => 'int'),
        'date' => array('constraint' => 20, 'type' => 'varchar'),
        'id_users' => array('constraint' => 11, 'type' => 'int'),
        'id_place' => array('constraint' => 11, 'type' => 'int'),
        'user' => array('constraint' => 100, 'type' => 'varchar'),
        'place' => array('constraint' => 100, 'type' => 'varchar'),
    ), array('id_users','id_place'), false, 'InnoDB', 'utf8_unicode_ci',
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
       \DBUtil::drop_table('valuations');
    }
}