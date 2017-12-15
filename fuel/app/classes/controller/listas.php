<?php
 
class Controller_listas extends Controller_Rest
{
    public function post_create()
    {
        try {
            
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
            $list->name = $input['lista'];
            $list->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['lista']
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
    	$lists = Model_usuarios::find('all');

    	return $this->response(Arr::reindex($lists));
    }

    public function post_delete()
    {
        $list = Model_usuarios::find($_POST['id']);
        $listName = $list->name;
        $listName = $list->password;
        $list->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $listName,
        ));

        return $json;
    }
    
}
