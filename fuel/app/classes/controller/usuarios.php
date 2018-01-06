<?php
use \Firebase\JWT\JWT;
 
class Controller_usuarios extends Controller_Rest
{
   private $key = 'klafdlblbldfihbdvijbfsavliljkdfijlbadfilaslfvñkjafdvkñjnfvñ';

    public function post_create()
    {
            try
        {

            if(!isset($_POST['name']) || 
                !isset($_POST['password']) || 
                !isset($_POST['email'])) 
            {

                $response = $this->response(array(
                    'code' => 400,
                    'message' => 'Debes rellenar todos los campos',
                    'data' => ''
                ));
                return $response;

            }

            $input = $_POST;
            $usersName = Model_Users::find('all', array(
                'where' => array(
                    array('name', $input['name'])
                ),
            ));
            $usersEmail = Model_Users::find('all', array(
                'where' => array(
                    array('email', $input['email'])
                ),
            ));

            if(!empty($usersName) || !empty($usersEmail))
            {

                $response = $this->response(array(
                    'code' => 400,
                    'message' => 'Usuario o email ya registrados',
                    'data' => ''
                ));
                return $response;
            
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
                'name' => $input['name'],
                'data' => ''
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

        $autenticado= self::peticionAut();
            if($autenticado == true)
            {
                $lista = Model_Users::find('all');

                foreach ($lista as $key => $user)
                {
                    $users[] = $user->name;
                }


                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuarios obtenidos',
                    'data' => $users
                ));
                return $json;

            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'El usuario debe loguearse primero',
                    'data' => ''
                ));
                return $json;
            }


    	/*$users = Model_usuarios::find('all');

    	return $this->response(Arr::reindex($users));*/
    }
    //hasta aqui ya esta

    public function post_delete()
    {
        autenticado = self::peticionAut();

        if($autenticado == true)
        {
            $info = self::obtenerInfo();

            $input = $_POST;

            if($info['id'] == $info['id'])
            {
                $user = Model_usuarios::find['id']);
                $user->delete();

                $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario borrado',
                'name' => $userName,
                ));

                return $json;
            
            }
            else 
            {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto',
                ));
            return $json;
            }

        }
        else
        {   
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto',
                ));
            return $json;     
        }

        /*$user = Model_usuarios::find($_POST['id']);
        $userName = $user->name;
        $userName = $user->password;
        $userName = $user->email;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $userName,
        ));

        return $json;*/

    }
    public function post_edit() {
        
        $autenticado = self::peticionAut();

        if($autenticado == true){


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

            }
            else
            {   
        
            $response = $this->response(array(
                'code' => 400,
                'message' => 'El usuario debe loguearse primero',
                'data' => ''
            ));
            return $response;
            }
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
        ));

        if (empty($users))
        {

            $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto',
                    ));
            return $json;

        }
        $data = self::obtenerDatos($users);
        $token = self::obtenerDatos($data);
    
        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario encontrado',
            'name' => $data
        ));  
            return $json; 
    }
    
}
