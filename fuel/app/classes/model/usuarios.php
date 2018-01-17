<?php 

class Model_Usuarios extends Orm\Model
{
    protected static $_table_name = 'usuarios';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'nombre' => array(
            'data_type' => 'varchar'   
        ),
        'password' => array(
            'data_type' => 'varchar'   
        ),
        'email' => array(
            'data_type' => 'varchar'   
        ),
        'monedas' => array(
            'data_type' => 'int'   
        )


    );
}