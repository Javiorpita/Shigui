<?php 

class Model_Buy extends Orm\Model
{
    protected static $_table_name = 'buy';

    protected static $_primary_key = array('id_user','id_object');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'id_user' => array(
            'data_type' => 'int'   
        ),
        'id_object' => array(
            'data_type' => 'int'   
        )
    );
}