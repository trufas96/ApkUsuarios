<?php
use \Firebase\JWT\JWT;
 
class Controller_usuarios extends Controller_Rest
{
   private $key = 'klafdlblbldfihbdvijbfsavliljkdfijlbadfilaslfvñkjafdvkñjnfvñ';

    public function post_create()
    {
        try {
            
            if (!isset($_POST['name']) || !isset($_POST['password']) || !isset($_POST['email']))
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name'
                    ));

                return $json;
            }

            $input = $_POST;
            $user = new Model_usuarios();
            $user->name = $input['name'];
            $user->password = $input['password'];
            $user->email = $input['email'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['name']
            ));

            return $json;

        } 
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        }

        
    }

    public function get_usuarios()
    {
    	$users = Model_usuarios::find('all');

    	return $this->response(Arr::reindex($users));
    }

    public function post_delete()
    {
        $user = Model_usuarios::find($_POST['id']);
        $userName = $user->name;
        $userName = $user->password;
        $userName = $user->email;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $userName,
        ));

        return $json;

    }
    public function post_edit() {
        

            $input = $_POST;
            $query = DB::update('usuarios');

            $query->where('id', '=', $input['id']);
            $query->value('password', $input['password']);
            $query->execute();
            $response = $this->response(array(
                'code' => 200,
                'message' => 'Contraseña cambiada',
                'data' => ''
            ));
            /*}
            else
            {   
        
            $response = $this->response(array(
                'code' => 400,
                'message' => 'El usuario debe loguearse primero',
                'data' => ''
            ));
            return $response;
            }*/
    }
    public function get_validate()
    {
        $input = $_GET;
        $users = Model_usuarios::find('all', array(
            'where' => array(
                array('name',$input['name'] ),
                array('password',$input['password'],
                array('email',$input['email'] )
            )
            )
        )
    );
        if (empty($users)){
            $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto',
                    ));
            return $json;
        } 
        else 
        {
            $name = $input['name'];
            $password = $input['password'];
            $email = $input['email'];
            foreach ($users as $key => $user) {
                $user = array('name' => $name,
                            'password' => $password,
                            'email' => $email);
            }
            $data = JWT::encode($user,$this->$key);
            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario encontrado',
                'name' => $data
        ));  
            return $json; 
        }
    }
}
