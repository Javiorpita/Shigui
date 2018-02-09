<?php 

class Model_Search extends Orm\Model
{
    protected static $_table_name = 'find';

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
    protected static $_has_many = array(
        'users' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Places',
            'key_to' => 'id_maps',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
}