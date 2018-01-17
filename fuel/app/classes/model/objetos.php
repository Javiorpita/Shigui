<?php 

class Model_Objetos extends Orm\Model
{
    protected static $_table_name = 'objetos';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'descrpcion' => array(
            'data_type' => 'varchar'   
        ),
        'precio' => array(
            'data_type' => 'int'   
        )


    );
}