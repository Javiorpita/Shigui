<?php 

class Model_Valuations extends Orm\Model
{
    protected static $_table_name = 'valuations';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'comentary' => array(
            'data_type' => 'varchar'   
        ),
        'value' => array(
            'data_type' => 'int'   
        ),
        'id_user' => array(
            'data_type' => 'int'   
        ),
         'id_place' => array(
            'data_type' => 'int'   
        ),
    );
}