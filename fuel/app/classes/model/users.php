<?php 

class Model_Users extends Orm\Model
{
    protected static $_table_name = 'users';

    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'name' => array(
            'data_type' => 'varchar'   
        ),
        'password' => array(
            'data_type' => 'varchar'   
        ),
        'email' => array(
            'data_type' => 'varchar'   
        ),
        'coins' => array(
            'data_type' => 'int'   
        )


    );
}