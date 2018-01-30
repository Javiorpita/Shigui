<?php 

class Model_Objects extends Orm\Model
{
    protected static $_table_name = 'objects';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'description' => array(
            'data_type' => 'varchar'   
        ),
        'price' => array(
            'data_type' => 'int'   
        )


    );
}