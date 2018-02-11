<?php 

class Model_Search extends Orm\Model
{
    protected static $_table_name = 'find';

    protected static $_primary_key = array('id_user','id_place');
    protected static $_properties = array(
        'id_user',
        'id_place',
        'place' => array(
            'data_type' => 'varchar'   
        ),
        'date' => array(
            'data_type' => 'varchar'   
        ),
        'search_count' => array(
            'data_type' => 'varchar'   
        ),// both validation & typing observers will ignore the PK
    );
  
   protected static $_has_many = array(
        'places' => array(
            'key_from' => 'id_place',
            'model_to' => 'Model_Places',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
        'users' => array(
            'key_from' => 'id_user',
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
}