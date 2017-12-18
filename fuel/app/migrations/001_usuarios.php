<?php

namespace Fuel\Migrations;

class Usuarios
{

    function up()
    {
        \DBUtil::create_table('usuarios', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 100),
            'password' => array('type' => 'varchar', 'constraint' => 100),
            'email' => array('type' => 'varchar', 'constraint' => 100),
            ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('usuarios');
    }
}