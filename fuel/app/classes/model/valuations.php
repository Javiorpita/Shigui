<?php 

class Model_Valuations extends Orm\Model
{
    protected static $_table_name = 'valuations';

    protected static $_primary_key = array('id_users','id_place');
    protected static $_properties = array(
        'id_users',
        'id_place',// both validation & typing observers will ignore the PK
        'comentary' => array(
            'data_type' => 'varchar'   
        ),
        'value' => array(
            'data_type' => 'int'   
        ),
        'date' => array(
            'data_type' => 'varchar'   
        ),
      
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
            'key_from' => 'id_users',
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
}