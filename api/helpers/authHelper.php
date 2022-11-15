<?php

class AuthHelper {

    private $clave;

    function __construct(){
        $this->clave = 'admin1';
    }


    function authToken(){
        $auth = $this->getHeader(); // Bearer header.payload.signature
        $auth = explode(" ", $auth);
        if($auth[0]!="Bearer" || count($auth) != 2){
            return array();
        }
        $token = explode(".", $auth[1]);
        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];

        $new_signature = hash_hmac('SHA256', "$header.$payload", $this->clave , true);
        $new_signature = base64url_encode($new_signature);


        if($signature!=$new_signature)
            return array();
        
        $payload = json_decode(base64_decode($payload));
        if(!isset($payload->exp) || $payload->exp<time())
            return array();
       
        return $payload;
    }

    function crearToken($user = null){

        $user = json_decode(json_encode($user), true);

        $header = array(
            'alg' => 'HS256',
            'typ' => 'JWT'
        );
        $payload = array(
            'id' => 1,
            'name' => $user['usuario'],
            'exp' => time()+3600
        );
        $header = base64url_encode(json_encode($header));
        $payload = base64url_encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$header.$payload", $this->clave, true);
        $signature = base64url_encode($signature);
        $token = "$header.$payload.$signature";
        return $token;
    }

    function isLoggedIn(){
        $payload = $this->getToken();
        if(isset($payload->id))
            return true;
        else
            return false;
    }

    function getHeader(){

        if(isset($_SERVER['HTTP_AUTHORIZATION'])){
            return $_SERVER['HTTP_AUTHORIZATION'];
        } else if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
            return $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }else{
            return null;
        }
    }
}
