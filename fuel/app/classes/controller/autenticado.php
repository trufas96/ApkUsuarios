<?php 
use \Firebase\JWT\JWT;
class Controller_Base extends Controller_Rest
{
    private $key = "ixjdpfbhgksjdfhglkadfghlkasd";
    protected function obtenerDatos($users)
    {
        foreach ($users as $key => $user)
        {
            $userInfo = array(
	            "name" => $user->name,
	            "pass" => $user->pass,
	            "email" => $user->email,
	            "id" => $user->id
        	);
        }
        return $userInfo;
    }
    protected function encodeInfo($data)
    {
    	$token = JWT::encode($data, $this->key);
    	return $token;
    }
    protected function decodeInfo($token)
    {
	    $decodedInfo = JWT::decode($token, $this->key, array('HS256')); 
	    $arrayInfo = (array) $decodedInfo;
	    return $arrayInfo;
    }
    protected function obtenerInfo()
    {
        $header = apache_request_headers();
        $token = $header['Authorization'];
        $info = $this->decodeInfo($token);
        return $info;
    }
    protected function peticionAut()
    {
    	try 
    	{
	        $header = apache_request_headers();
	        if(isset($header['Authorization']))
	        {
	            $info = $this->decodeInfo($header['Authorization']);
	            $QueryUsuarios = Model_Users::find('all', array(
	                'where' => array(
	                    array('name', $info['name']),
	                    array('password', $info['password']),
	                ),
	            ));
	            
	            if($QueryUsuarios != null){
	                return true;
	            }else{
	                return false;
	            }
	        }
	        else
	        {
	            return false;
	        }
    	} 
    	catch (Exception $e)
    	{
    		return false;
    	}
    }
}