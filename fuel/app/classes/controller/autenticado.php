<?php 
use \Firebase\JWT\JWT;
class Controller_Base extends Controller_Rest
{
    private $key = "fnap3se2ghseo35g53ha7sopghseufhr378562387itgri6odfgou83";
    protected function obtainData($users)
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
	    $info_array = (array) $decodedInfo;
	    return $info_array;
    }
    protected function getUserInfo()
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];
        $info = $this->decodeInfo($token);
        return $info;
    }
    protected function requestAuthenticate()
    {
    	try 
    	{
	        $headers = apache_request_headers();
	        if(isset($headers['Authorization']))
	        {
	            $info = $this->decodeInfo($headers['Authorization']);
	            $userQuery = Model_Users::find('all', array(
	                'where' => array(
	                    array('name', $info['name']),
	                    array('pass', $info['pass']),
	                ),
	            ));
	            
	            if($userQuery != null){
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