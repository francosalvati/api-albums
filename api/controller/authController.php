<?php

 require_once './api/helpers/authHelper.php';
 require_once './api/models/authModel.php';
 require_once './api/models/albumsModel.php';
 require_once './api/views/apiView.php';

 function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}


class AuthController{
    private $authModel;
    private $albumsModel;
    private $view;
    private $authHelper;

    private $data;

    function __construct(){
        $this->authModel = new AuthModel();
        $this->albumsModel = new AlbumsModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthHelper();

        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }


    function getToken($params = null) {
        
        $basic = $this->authHelper->getHeader();
        if(empty($basic)){
            $this->view->response('No autorizado', 401);
            return;
        }

        $basic = explode(" ",$basic);
        if($basic[0]!="Basic"){
            $this->view->response('La autenticación debe ser Basic', 401);
            return;
        }

        //validar usuario:contraseña
        $userpass = base64_decode($basic[1]); // user:pass
        $userpass = explode(":", $userpass);
        $user = $userpass[0];
        $pass = $userpass[1];

        $modelUser = $this->authModel->getUser($user);
        if( $modelUser && password_verify($pass, $modelUser->contraseña)){
        //     //  crear un token
        $token = $this->authHelper->crearToken($modelUser);
        $this->view->response('el token = ' . $token, 200);
        }else{
            $this->view->response('sin autorizcion', 401);
        }
    }

    function getUsuario($params = null){
        $id = $params[':ID'];
        $user = $this->authHelper->authToken();
        if($user)
            if($id == $user->id){
                $this->view->response($user, 200);
            }else{
                $this->view->response("acceso denegado", 403);
            }
        else{
            $this->view->response("sin autorizcion", 401);
        }
    }


} 
