<?php
 
class Controller_listas extends Controller_Rest
{
    public function post_create()
    {
        
        $authenticado = self::requestAuthenticate();

        if($authenticado == true)
        {
            try
            {
                $info = self::obtenerInfo();

                if(!isset($_POST['name']))
                {

                    $response = $this->response(array(
                        'code' => 400,
                        'message' => 'Debes rellenar los campos',
                        'data' => ''
                    ));
                    return $response;
                }

                $input = $_POST;

                $list = new Model_Listas();
                $list->name = $input['name'];
                $list->id_user = $info['id'];
                $list->save();

                $response = $this->response(array(
                    'code' => 200,
                    'message' => 'lista creada',
                    'data' => ''
                ));

                return $response;

            }
            catch (Exception $e)
            {
                $response = $this->response(array(
                    'code' => 500,
                    'message' => 'Error del servidor',
                    'data' => ''
                    ));

                return $response;
            }

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
        /*try {
            
            if (!isset($_POST['lista'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame lista'
                ));

                return $json;

            }

            $input = $_POST;
            $list = new Model_listas();
            $list->lista = $input['lista'];
            $list->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'lista' => $input['lista']
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
        }*/ 
    }

    public function get_listas()
    {
        $autenticado = self::requestAuthenticate();
        if($autenticado == true)
        {
            $info = self::getUserInfo();
            $lista = Model_Lists::find('all', array(
                'where' => array(
                    array('id_usuario', $info['id']),
                ),
            ));
            if(!empty($listaUsuarios))
            {
                foreach ($listaUsuarios as $key => $list)
                {
                    $lists[] = $list->name;
                }
                $response = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas obtenidas',
                    'name' => $lists
                ));
                return $response;
            }
            else
            {
                $response = $this->response(array(
                    'code' => 400,
                    'message' => 'No existen listas asociadas a esta cuenta',
                    'name' => ''
                ));
                return $response;
            }
        }
        else
        {
            $response = $this->response(array(
                'code' => 400,
                'message' => 'El usuario debe loguearse primero',
                'name' => ''
            ));
            return $response;
        }
    	/*$lists = Model_listas::find('all');

    	return $this->response(Arr::reindex($lists));*/
    }
    public function post_edit() 
    {
        $autenticado = self::requestAuthenticate();
        if($autenticado == true)
        {
            $info = self::obtenerInfo();
            $input = $_POST;
            $listaUsuarios = Model_Lists::find('all', array(
                'where' => array(
                    array('id_usuario', $info['id']),
                    array('id', $input['id']),
                ),
            ));
            if(!empty($listaUsuarios))
            {
                $query = DB::update('listas');
                $query->where('id', '=', $input['id']);
                $query->value('name', $input['name']);
                $query->execute();

                $response = $this->response(array(
                    'code' => 200,
                    'message' => 'Nombre cambiado',
                    'name' => ''
                ));
            }
            else
            {
                $response = $this->response(array(
                'code' => 400,
                'message' => 'Esa lista no existe',
                'name' => ''
                ));
                return $response;
            }
        }
        else
        {
            $response = $this->response(array(
                'code' => 400,
                'message' => 'El usuario debe loguearse primero',
                'name' => ''
            ));
            return $response;
        }
        /*$input = $_POST;
        $lists = Model_listas::find('all', array(
                'where' => array(
                    array('id_usuario', $info['id']),
                    array('id', $input['id']),
                ),
            ));
        if(!empty($lists))
        {
            $query = DB::update('listas');
            $query->where('id', '=', $input['id']);
            $query->value('name', $input['name']);
            $query->execute();
            $json = $this->response(array(
            'code' => 200,
            'message' => 'Nombre cambiado',
            'name' => ''
        ));
        }
        else
        {
            $json = $this->response(array(
            'code' => 400,
            'message' => 'La lista no existe',
            'name' => ''
            ));
            return $json;
        }*/
        
    }
    public function post_delete()
    {
        $autenticado = self::peticionAut();
        if($autenticado == true)
        {
            $info = self::getUserInfo();
            $input = $_POST;
            
            $userLists = Model_Listas::find('all', array(
                'where' => array(
                    array('id_user', $info['id']),
                    array('id', $input['id']),
                ),
            ));
            if(!empty($userLists))
            {
                $userLists[$input['id']]->delete();
                $response = $this->response(array(
                    'code' => 200,
                    'message' => 'Lista borrada',
                    'data' => ''
                ));
                return $response;
            }
            else
            {
                $response = $this->response(array(
                'code' => 400,
                'message' => 'Esa lista no existe',
                'data' => ''
                ));
                return $response;
            }
            
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
        /*$list = Model_listas::find($_POST['id']);
        $listName = $list->name;
        $list->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $listName,
        ));

        return $json;
    }*/
    
}
