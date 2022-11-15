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
        
        //filtro de albums
        if(isset($_GET['search'])){
            echo($_GET['search']);
            $search = $_GET['search'];
            $albums = $this->model->search($search);
            return $this->view->response($albums, 200);
        }
        //ordenamiento
        else if(isset($_GET['sort'] )){
            $sort = $_GET['sort'];
            $order = "ASC";
            if($_GET['order']){
                $order = $_GET['order'];
            }
            $albums = $this->model->getFiltro($sort, $order);
            return $this->view->response($albums, 200);
        }
        //paginacion 
        else if(isset($_GET['limit'])){
            $limit = $this->setLimit();
            $page = $this->setPages($limit);
            $albums = $this->model->getPaginated($limit, $page);
            return $this->view->response($albums, 200);
        }
        // obtener un solo album
        else if(isset($params[":ID"])){
            $album = $this->model->getAlbum($params[":ID"]);
            if($album){
                return $this->view->response($album, 200);
            }else{
                return $this->view->response('Error', 404);
            }
        }
        else{
            $albums = $this->model->getAll();
            return $this->view->response($albums, 200);
        }  
    } 
    

    function delete($params){
        $id = $params[':ID'];
        if($this->model->getAlbum($id)){
            $this->model->delete($id);
            return $this->view->response("Album con id: " .  $params[':ID'] . " eliminado" , 200);
        }else{
            return $this->view->response("Album con id: " .  $params[':ID'] . " no existe" , 404);
        } 
    }

    function setLimit()
    {
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $size = $this->getSize();
            $limit = $size;
        }
        return $limit;
    }

    function setPages($limit)
    {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $page = ($limit * $page) - $limit;
        } else {
            $page = 0;
        }
        return $page;
    }
}