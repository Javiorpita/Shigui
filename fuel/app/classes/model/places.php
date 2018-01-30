<?php 

class Model_Places extends Orm\Model
{
    protected static $_table_name = 'places';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'coins' => array(
            'data_type' => 'int'   
        ),
         'coordinates_X' => array(
            'data_type' => 'double'   
        ),
          'coordinates_Y' => array(
            'data_type' => 'double'   
        ),
          'name' => array(
            'data_type' => 'varchar'   
        )  
    );
}