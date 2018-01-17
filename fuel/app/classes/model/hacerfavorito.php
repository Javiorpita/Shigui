<?php 

class Model_Hacerfavorito extends Orm\Model
{
    protected static $_table_name = 'hacerfavorito';

    protected static $_primary_key = array('id_usuario','id_lugar');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'id_usuario' => array(
            'data_type' => 'int'   
        ),
        'id_lugar' => array(
            'data_type' => 'int'   
        )


    );
}