<?php
use \Firebase\JWT\JWT;
 
class Controller_usuarios extends Controller_Rest
{
   private $key = "klafdlblbldfihbdvijbfsavliljkdfijlbadfilaslfvñkjafdvkñjnfvñ";

    public function post_create()
    {
        try {
            
            if (!isset($_POST['name']) || !isset($_POST['password'])) 
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
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $userName,
        ));

        return $json;
    }
    public function get_validate()
    {
        $input = $_GET;
        $users = Model_usuarios::find('all', array(
            'where' => array(
                array('name',$input['name'] ),
                array('password',$input['password'] )
            )
        ));
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
            $token = array('name' => $name,
                            'password' => $password);
            $jwt = JWT::encode($token,$this->$key);
            $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario encontrado',
            'name' => $decode
        ));  
            return $json; 
        }
        /*foreach ($users as $key => $user) {
            $user = array('name' => $user -> name,
                            'password' => $user -> password);
        }*/
            
        
        //$decode = JWT::encode($user,$this->$key,array('HS256'));

            
          
         

    }
}
