<?php

class Model_agregar extends Orm\Model
{
	protected static $_table_name = 'agregar';
    protected static $_properties = array(
        'id_canciones' => array(
            'data_type' => 'int'   
        ),
        'id_listas' => array(
            'data_type' => 'int'   
        )
    );
}