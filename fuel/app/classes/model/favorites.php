<?php 

class Model_Favorites extends Orm\Model
{
    protected static $_table_name = 'favorites';

    protected static $_primary_key = array('id_user','id_place');
    protected static $_properties = array(
        'id'
        


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