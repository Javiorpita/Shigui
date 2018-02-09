<?php 

class Model_Places extends Orm\Model
{
    protected static $_table_name = 'places';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', 
        'id_maps' => array(
            'data_type' => 'varchar'   
        ),// both validation & typing observers will ignore the PK
        'picture' => array(
            'data_type' => 'varchar'   
        ),
         'coordinates_X' => array(
            'data_type' => 'float'   
        ),
          'coordinates_Y' => array(
            'data_type' => 'float'   
        ),
          'name' => array(
            'data_type' => 'varchar'   
        )  
    );
}