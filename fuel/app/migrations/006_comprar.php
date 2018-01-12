    <?php
    namespace Fuel\Migrations;

    class comprar
    {

        function up()
        {
            \DBUtil::create_table('comprar',
                array(
            'id_usuario' => array('constraint' => 11, 'type' => 'int'),
            'id_objeto' => array('constraint' => 11, 'type' => 'int'),
        ), array('id_usuario','id_objeto'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
            array(
                'constraint' => 'claveAjenaComprarAUsuarios',
                'key' => 'id_usuario',
                'reference' => array(
                    'table' => 'usuarios',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'CASCADE'
            ),
            array(
                'constraint' => 'claveAjenaObjetos',
                'key' => 'id_objeto',
                'reference' => array(
                    'table' => 'objetos',
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
           \DBUtil::drop_table('comprar');
        }
    }