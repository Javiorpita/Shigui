<?php 

class Model_Lugares extends Orm\Model
{
    protected static $_table_name = 'lugares';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'monedas' => array(
            'data_type' => 'int'   
        ),
         'coordenadas_X' => array(
            'data_type' => 'double'   
        ),
          'coordenadas_Y' => array(
            'data_type' => 'double'   
        ),
          'nombre' => array(
            'data_type' => 'varchar'   
        )  
    );
}