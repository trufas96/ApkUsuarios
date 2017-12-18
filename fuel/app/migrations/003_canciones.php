<?php

namespace Fuel\Migrations;

class Canciones
{

    function up()
    {
        \DBUtil::create_table('canciones', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'titulo' => array('type' => 'varchar', 'constraint' => 100),
            'artista' => array('type' => 'varchar', 'constraint' => 100),
            'url' => array('type' => 'varchar', 'constraint' => 100),
            'id_usuarios' => array('constraint' => 11, 'type' => 'int'),
            ), 
        array('id')
        , false, 'InnoDB', 'utf8_unicode_ci',
        array(
            array(
                'constraint' => 'claveAjenaCancionesAUsuarios',
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
       \DBUtil::drop_table('canciones');
    }
}