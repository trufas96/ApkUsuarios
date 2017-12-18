<?php

class Model_canciones extends Orm\Model
{
	protected static $_table_name = 'listas';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', 
        'titulo' => array(
            'data_type' => 'varchar'   
        ),
        'artista' => array(
            'data_type' => 'varchar'   
        ),
        'url' => array(
            'data_type' => 'varchar'   
        ),
        'id_usuarios' => array(
            'data_type' => 'int'   
        )
    );
    protected static $_many_many = array(
    'listas' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_listas', 
        'table_through' => 'agregar', 
        'key_through_to' => 'id_cancion',
        'model_to' => 'Model_Listas',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
);
} 