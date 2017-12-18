<?php

class Model_listas extends Orm\Model
{
	protected static $_table_name = 'listas';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', 
        'lista' => array(
            'data_type' => 'varchar'   
        ),
        'id_usuarios' => array(
            'data_type' => 'int'   
        )
    );
        
    protected static $_many_many = array(
        'canciones' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_canciones', 
            'table_through' => 'agregar', 
            'key_through_to' => 'id_listas', 
            'model_to' => 'Model_Canciones',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
            )
    );
    protected static $_belongs_to = array(
        'post' => array(
            'key_from' => 'id_usuarios',
            'model_to' => 'Model_Usuarios',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}