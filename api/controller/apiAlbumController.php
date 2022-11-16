<?php

require_once './api/models/albumsModel.php';
require_once './api/views/apiView.php';
require_once './api/helpers/authHelper.php';


class ApiAlbumController {
    
    private $model; 
    private $view;
    private $data;
    private $helper;

    function __construct(){
        $this->model = new AlbumsModel();
        $this->view = new ApiView();
        $this->helper = new AuthHelper();
        $this->data = file_get_contents("php://input"); 
    }
    
    private function getData() {
        return json_decode($this->data);
    }

    function get($params = null){
        
        //filtro de albums
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $albums = $this->model->search($search);
            if(!empty($albums)){
                return $this->view->response($albums, 200);
            }else{
                return $this->view->response('Resultado no encontrado', 204);
            }
        }
        //ordenamiento
        else if(isset($_GET['sort'] )){
            $sort = $_GET['sort'];
            $order = "ASC";
            if(isset($_GET['order'])){
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
                return $this->view->response('Error, Not found', 404);
            }
        }
        else{
            $albums = $this->model->getAll();
            return $this->view->response($albums, 200);
        }  
    } 
    
    function delete($params){
        $id = $params[':ID'];
        if(!$this->hasSongs($id)){
             if($this->model->getAlbum($id)){
                    $this->model->delete($id);
                    return $this->view->response("Album con id: " .  $params[':ID'] . " eliminado" , 200);
             }else{
                    return $this->view->response("Album con id: " .  $params[':ID'] . " Error, Not found" , 404);
             } 
        }else{return $this->view->response("Album con id: " .  $params[':ID'] . " tiene canciones" , 400);}
    }

    function insert($params = null){
        if($this->helper->isLoggedIn()){
            $album = $this->getData();
            if (empty($album->nombre) || empty( $album->banda) || empty($album->genero) || empty($album->anio) || empty($album->cant_canciones) || empty($album->imgURL)) {
                $this->view->response("Complete todos los datos", 400);
            }else{
                $id = $this->model->insert($album->nombre, $album->banda, $album->genero, $album->anio, $album->cant_canciones, $album->imgURL);
                $album = $this->model->getAlbum($id);
                return $this->view->response("Album con id: " . $id . " creado " , 201);
            }
        }else {return $this->view->response('sin autorizcion', 403);}
    }

    function modify($params = null){
        if($this->helper->isLoggedIn()){
            $id = $params[':ID'];
            $album = $this->getData();
                if (empty($album->nombre) || empty( $album->banda) || empty($album->genero) || empty($album->anio) || empty($album->cant_canciones) || empty($album->imgURL)) {
                    $this->view->response("Complete todos los datos", 400);
                }else if($this->model->getAlbum($id)){
                    $this->model->modify($album->nombre, $album->banda, $album->genero, $album->anio, $album->cant_canciones, $album->imgURL, $params[':ID']);
                    $album = $this->model->getAlbum($params[':ID']);
                    return $this->view->response("Album con id: " . $params[':ID'] . " editado " , 200);
                }else{
                    return $this->view->response("Album con id: " .  $params[':ID'] . " Error, Not found" , 404);
                }
        }else {return $this->view->response('sin autorizcion', 403);}
    }
    
    
    function hasSongs($idAlbum) {
        $songs = $this->model->getFromAlbum($idAlbum);
        if (count($songs) != 0) {
            return true;
        } else {
            return false;
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

    function setPages($limit){
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $page = ($limit * $page) - $limit;
        } else {
            $page = 0;
        }
        return $page;
    }
}
