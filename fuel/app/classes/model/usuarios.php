<?php 

class Model_usuarios extends Orm\Model
{
	protected static $_table_name = 'usuarios';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', 
        'name' => array(
            'data_type' => 'varchar'   
        ),
        'password' => array(
            'data_type' => 'varchar'   
        )
    );
    protected static $_has_many = array(
    'comments' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Listas',
        'key_to' => 'id_usuarios',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
);

}
