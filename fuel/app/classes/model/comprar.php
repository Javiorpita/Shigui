<?php 

class Model_Comprar extends Orm\Model
{
    protected static $_table_name = 'comprar';

    protected static $_primary_key = array('id_usuario','id_objeto');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'id_usuario' => array(
            'data_type' => 'int'   
        ),
        'id_objeto' => array(
            'data_type' => 'int'   
        )
    );
}