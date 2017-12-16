<?php

namespace Fuel\Migrations;

class Listas
{

    function up()
    {
        \DBUtil::create_table('listas', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'lista' => array('type' => 'varchar', 'constraint' => 100),
            'id_usuarios' => array('constraint' => 11, 'type' => 'int'),
            ), 
        array('id'), false, 'InnoDB', 'utf8_unicode_ci',
        array(
        	array(
        		'constraint' => 'claveAjenaListasAUsuarios',
        		'key' => 'id_usuarios',
        		'reference' => array(
        			'table' => 'usuarios',
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
       \DBUtil::drop_table('listas');
    }
}