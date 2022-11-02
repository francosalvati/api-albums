<?php

require_once './api/models/albumsModel.php';
require_once './api/views/apiView.php';


class ApiAlbumController{
    
    private $model; 
    private $view;

    function __construct(){
        $this->model = new AlbumsModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input"); 

    }
    
    private function getData() {
        return json_decode($this->data);
    }

    function get($params = null){
        if(isset($params[":ID"])){
            $album = $this->model->getAlbum($params[":ID"]);
            if($album){
                return $this->view->response($album, 200);
            }else{
                return $this->view->response('Error', 404);
            }
        }else {
            $albums = $this->model->getAll();
            return $this->view->response($albums, 200);
        }
        
    }

    function delete($params){

        $this->model->delete($params[':ID']);
        $albums = $this->model->getAll();

        return $this->view->response("Album con id: " .  $params[':ID'] . " eliminado" , 200);
    }

    function insert(){

        $album = $this->getData();
        $this->model->insert($album->nombre, $album->banda, $album->genero, $album->anio, $album->cant_canciones, $album->imgURL);

        return $this->view->response("Album creado", 201);
    }

    function modify(){

        $album = $this->getData();
        $this->model->modify($album->nombre, $album->banda, $album->genero, $album->anio, $album->cant_canciones, $album->imgURL, $album->id);

        return $this->view->response("Album editado", 200);
    }
}