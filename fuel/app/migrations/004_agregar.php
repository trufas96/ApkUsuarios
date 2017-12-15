<?php

namespace Fuel\Migrations;

class Agregar
{

    function up()
    {
        \DBUtil::create_table('agregar', array(
            'id_listas' => array('constraint' => 11, 'type' => 'int'),
            'id_canciones' => array('constraint' => 11, 'type' => 'int')
            ),array('id_listas', 'id_canciones'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
        	array(
        		'constraint' => 'claveAjenaAgregarAListas',
        		'key' => 'id_listas',
        		'reference' => array(
        			'table' => 'listas',
        			'column' => 'id',
        		),
        		'on_update' => 'CASCADE',
        		'on_delete' => 'RESTRICT'
        	),
        	array(
        		'constraint' => 'claveAjenaCancionesAAgregar',
        		'key' => 'id_canciones',
        		'reference' => array(
        			'table' => 'canciones',
        			'column' => 'id',
        		),
        		'on_update' => 'CASCADE',
        		'on_delete' => 'RESTRICT'
        	)
       	)
	);
    }

    function down()
    {
       \DBUtil::drop_table('agregar');
    }
}