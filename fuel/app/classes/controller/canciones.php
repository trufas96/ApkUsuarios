<?php
 
class Controller_canciones extends Controller_Rest
{
    public function post_create()
    {
        try {
            
            if (!isset($_POST['titulo']) || !isset($_POST['artista'])||!isset($_POST['url'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame cancion'
                ));

                return $json;
            }

            $input = $_POST;
            $song = new Model_canciones();
            $song->titulo = $input['titulo'];
            $song->artista = $input['artista'];
            $song->url = $input['url'];
            $song->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['titulo']
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
    	$songs = Model_canciones::find('all');

    	return $this->response(Arr::reindex($songs));
    }

    public function post_delete()
    {
        $song = Model_canciones::find($_POST['id']);
        $songName = $song->titulo;
        $song->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $songName,
        ));

        return $json;
    }
    
    public function post_edit()
    {
        $input = $_POST;
            $song = Model_Songs::find($input['id']);
            if(!empty($song))
            {
                $query = DB::update('songs');

                $query->where('id', '=', $input['id']);

                if(array_key_exists('name', $input))
                {
                    $query->value('name', $input['titulo']);
                }

                if(array_key_exists('artist', $input))
                {
                    $query->value('artist', $input['artista']);
                }

                if(array_key_exists('url', $input))
                {
                    $query->value('url', $input['url']);
                }
                
                $query->execute();
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Cancion editada con exito',
                    'name' => ''
                ));

            }
            else
            {
                $json = $this->response(array(
                'code' => 400,
                'message' => 'Esa cancion no existe',
                'name' => ''
                ));
                return $json;
            }
        }
}

}
