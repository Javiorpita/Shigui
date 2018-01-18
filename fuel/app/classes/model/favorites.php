<?php 

class Model_Favorites extends Orm\Model
{
    protected static $_table_name = 'favorites';

    protected static $_primary_key = array('id_user','id_place');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'id_user' => array(
            'data_type' => 'int'   
        ),
        'id_place' => array(
            'data_type' => 'int'   
        )


    );
}