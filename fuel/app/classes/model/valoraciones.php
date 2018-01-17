<?php 

class Model_Valoraciones extends Orm\Model
{
    protected static $_table_name = 'valoraciones';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'comentario' => array(
            'data_type' => 'varchar'   
        ),
        'valor' => array(
            'data_type' => 'int'   
        ),
        'id_usuario' => array(
            'data_type' => 'int'   
        ),
         'id_lugar' => array(
            'data_type' => 'int'   
        ),
    );
}