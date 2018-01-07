<?php
 
class Controller_canciones extends Controller_Rest
{
    public function post_create()
    {
        $autenticado = self::peticionAut();
        if ($autenticado == true)
        {
        try 
        {
            
            if (!isset($_POST['titulo']) || !isset($_POST['artista'])||!isset($_POST['url'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame cancion'
                ));

                return $json;
            }
            $input = $_POST;

                if(array_key_exists('url', $input))
                {
                    $urlCanciones = Model_Songs::find('all', array(
                        'where' => array(
                            array('url', $input['url'])
                        ),
                    ));

                    if(!empty($urlCanciones))
                    {
                        $json = $this->response(array(
                            'code' => 400,
                            'message' => 'Url metida ya',
                            'name' => ''
                        ));
                        return $json;
                    }

                    $song = new Model_Songs();
                    $song->titulo = $input['titulo'];
                    $song->artista = $input['artista'];
                    $song->url = $input['url'];
                    $song->save();
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'Cancion creada',
                        'name' => ''
                    ));

                    return $json;
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'Error',
                        'name' => ''
                    ));
                    return $json;
                }  
            }
            /*$input = $_POST;
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

        }*/
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        } 
    }
    else
    {
        $json = $this->response(array(
            'code' => 400,
            'message' => 'parametro incorrecto, se necesita que el parametro se llame cancion'
            ));

        return $json;  
    }
    }

    public function get_canciones()
    {
        $autenticado = self::peticionAut();
        if($autenticado == true)
        {
            $usuarioSongs = Model_Canciones::find('all');
            foreach ($usuarioSongs as $key => $song)
            {
                $songs[] = $song->title;
            }
            $json = $this->response(array(
                'code' => 200,
                'message' => 'Canciones obtenidas',
                'name' => $songs
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'El usuario debe loguearse primero',
                'name' => ''
            ));
            return $json;
        }
    	/*$songs = Model_canciones::find('all');

    	return $this->response(Arr::reindex($songs));*/
    }

    public function post_delete()
    {
        $autenticado = self::peticionAut();

        if($autenticado == true)
        {
            $input = $_POST;
            if(array_key_exists('id', $input))
            {
                $song = Model_Songs::find($input['id']);
                if(!empty($song))
                {
                    $song->delete();
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'Cancion borrada',
                        'name' => ''
                    ));
                    return $json;
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
            else
            {
                $json = $this->response(array(
                'code' => 400,
                'message' => 'Indice erroneo',
                'name' => ''
                ));
                return $json;
            }   
        }
        else
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'El usuario debe loguearse primero',
                'name' => ''
            ));
            return $json;
        }
        /*$song = Model_canciones::find($_POST['id']);
        $songName = $song->titulo;
        $song->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $songName,
        ));

        return $json;*/
    }
    
    public function post_edit()
    {
        $input = $_POST;
            $song = Model_canciones::find($input['id']);
            if(!empty($song))
            {
                $query = DB::update('canciones');

                $query->where('id', '=', $input['id']);

                if(array_key_exists('name', $input))
                {
                    $query->value('name', $input['titulo']);
                }

                if(array_key_exists('artista', $input))
                {
                    $query->value('artista', $input['artista']);
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
