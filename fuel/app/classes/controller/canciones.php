<?php
 
class Controller_canciones extends Controller_Rest
{
    public function post_create()
    {
        try {
            
            if (!isset($_POST['cancion'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame cancion'
                ));

                return $json;
            }

            $input = $_POST;
            $song = new Model_listas();
            $song->name = $input['cancion'];
            $song->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['cancion']
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

    public function get_canciones()
    {
    	$songs = Model_usuarios::find('all');

    	return $this->response(Arr::reindex($songs));
    }

    public function post_delete()
    {
        $song = Model_usuarios::find($_POST['id']);
        $songName = $song->name;
        $song->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $songName,
        ));

        return $json;
    }
    
}
